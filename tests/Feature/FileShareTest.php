<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileShareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_user_can_upload_file(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($user)->post('/files/upload', [
            'file' => $file,
            'expiration' => 'never',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('files', [
            'user_id' => $user->id,
            'original_name' => 'document.pdf',
        ]);
    }

    public function test_upload_fails_without_file(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/files/upload', [
            'file' => null,
            'expiration' => 'never',
        ]);

        $response->assertSessionHasErrors('file');
    }

    public function test_upload_fails_with_invalid_extension(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('malware.exe', 100);

        $response = $this->actingAs($user)->post('/files/upload', [
            'file' => $file,
            'expiration' => 'never',
        ]);

        $response->assertSessionHasErrors('file');
    }

    public function test_upload_fails_with_large_file(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('large.pdf', 60000); // 60 MB

        $response = $this->actingAs($user)->post('/files/upload', [
            'file' => $file,
            'expiration' => 'never',
        ]);

        $response->assertSessionHasErrors('file');
    }

    public function test_user_can_view_own_files(): void
    {
        $user = User::factory()->create();
        $file = File::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/files');
        $response->assertStatus(200);
        $response->assertSee($file->original_name);
    }

    public function test_user_can_download_own_file(): void
    {
        $user = User::factory()->create();
        $file = File::factory()->create(['user_id' => $user->id]);

        // Create the file in storage
        Storage::disk('local')->put($file->path, 'test content');

        $response = $this->actingAs($user)->get("/files/{$file->id}/download");
        $response->assertStatus(200);
    }

    public function test_user_cannot_download_others_file(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $file = File::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get("/files/{$file->id}/download");
        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_file(): void
    {
        $user = User::factory()->create();
        $file = File::factory()->create(['user_id' => $user->id]);

        // Create the file in storage
        Storage::disk('local')->put($file->path, 'test content');

        $response = $this->actingAs($user)->delete("/files/{$file->id}/delete");
        $response->assertRedirect('/dashboard');
        $this->assertDatabaseMissing('files', ['id' => $file->id]);
    }

    public function test_user_cannot_delete_others_file(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $file = File::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->delete("/files/{$file->id}/delete");
        $response->assertStatus(403);
        $this->assertDatabaseHas('files', ['id' => $file->id]);
    }

    public function test_share_link_works(): void
    {
        $file = File::factory()->create();

        // Create the file in storage
        Storage::disk('local')->put($file->path, 'test content');

        $response = $this->get("/s/{$file->token}");
        $response->assertStatus(200);
        $response->assertSee($file->original_name);
    }

    public function test_share_link_download_works(): void
    {
        $file = File::factory()->create();

        // Create the file in storage
        Storage::disk('local')->put($file->path, 'test content');

        $response = $this->get("/s/{$file->token}/download");
        $response->assertStatus(200);
    }

    public function test_share_link_increments_download_count(): void
    {
        $file = File::factory()->create(['download_count' => 0]);

        // Create the file in storage
        Storage::disk('local')->put($file->path, 'test content');

        $this->get("/s/{$file->token}/download");

        $this->assertEquals(1, $file->fresh()->download_count);
    }

    public function test_expired_file_cannot_be_downloaded(): void
    {
        $file = File::factory()->expired()->create();

        $response = $this->get("/s/{$file->token}");
        $response->assertStatus(200);
        $response->assertSee('expired');
    }

    public function test_invalid_token_shows_error(): void
    {
        $response = $this->get('/s/invalidtoken123');
        $response->assertStatus(200);
        $response->assertSee('not valid');
    }

    public function test_dashboard_shows_stats(): void
    {
        $user = User::factory()->create();
        File::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Total Files');
        $response->assertSee('Storage Used');
        $response->assertSee('Total Downloads');
    }

    public function test_files_index_has_search(): void
    {
        $user = User::factory()->create();
        File::factory()->create(['user_id' => $user->id, 'original_name' => 'report.pdf']);

        $response = $this->actingAs($user)->get('/files?search=report');
        $response->assertStatus(200);
        $response->assertSee('report.pdf');
    }

    public function test_files_index_filters_by_extension(): void
    {
        $user = User::factory()->create();
        File::factory()->create(['user_id' => $user->id, 'original_name' => 'report.pdf']);
        File::factory()->create(['user_id' => $user->id, 'original_name' => 'photo.jpg']);

        $response = $this->actingAs($user)->get('/files?extension=pdf');
        $response->assertStatus(200);
        $response->assertSee('report.pdf');
        $response->assertDontSee('photo.jpg');
    }
}
