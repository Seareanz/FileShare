<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:51200', // 50 MB in KB
                'mimes:jpg,jpeg,png,gif,webp,pdf,txt,doc,docx,xls,xlsx,ppt,pptx,zip',
            ],
            'expiration' => ['required', 'in:never,1day,7days,30days'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please select a file to upload.',
            'file.max' => 'File size must not exceed 50 MB.',
            'file.mimes' => 'Invalid file type. Allowed: jpg, jpeg, png, gif, webp, pdf, txt, doc, docx, xls, xlsx, ppt, pptx, zip.',
            'expiration.required' => 'Please select an expiration option.',
            'expiration.in' => 'Invalid expiration option.',
        ];
    }
}
