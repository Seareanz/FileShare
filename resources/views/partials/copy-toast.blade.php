<div id="copy-toast"
     class="pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2 translate-y-4 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-2.5 rounded-xl border border-emerald-500/30 bg-slate-900 px-4 py-3 shadow-2xl shadow-black/50">
        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span id="copy-toast-text" class="text-sm font-medium text-slate-200">Link copied to clipboard</span>
    </div>
</div>

<script>
    (function () {
        const toast = document.getElementById('copy-toast');
        const toastText = document.getElementById('copy-toast-text');
        let hideTimer = null;

        function showToast(message) {
            if (!toast) return;
            if (message) toastText.textContent = message;
            toast.classList.remove('opacity-0', 'translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            clearTimeout(hideTimer);
            hideTimer = setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-4');
                toast.classList.remove('opacity-100', 'translate-y-0');
            }, 2200);
        }

        async function copyText(text) {
            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    const el = document.createElement('textarea');
                    el.value = text;
                    el.style.position = 'fixed';
                    el.style.opacity = '0';
                    document.body.appendChild(el);
                    el.select();
                    document.execCommand('copy');
                    document.body.removeChild(el);
                }
                return true;
            } catch (e) {
                return false;
            }
        }

        document.addEventListener('click', function (event) {
            const trigger = event.target.closest('.js-copy');
            if (!trigger) return;
            event.preventDefault();

            const text = trigger.getAttribute('data-copy') || '';
            copyText(text).then((ok) => {
                showToast(ok ? 'Link copied to clipboard' : 'Could not copy link');
            });
        });

        window.copyToClipboard = copyText;
        window.showCopyToast = showToast;
    })();
</script>
