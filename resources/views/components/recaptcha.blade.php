<div>
    <div
        wire:ignore
        x-data="{
            siteKey: '{{ config('recaptcha.site_key') }}',
            init() {
                // Load reCAPTCHA script if not already loaded
                if (!document.getElementById('recaptcha-script')) {
                    const script = document.createElement('script');
                    script.id = 'recaptcha-script';
                    script.src = 'https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit';
                    script.async = true;
                    script.defer = true;
                    document.head.appendChild(script);
                }

                // Define the callback for when the script loads
                window.onRecaptchaLoad = () => {
                    this.renderCaptcha();
                };

                // If script already loaded, render immediately
                if (window.grecaptcha && window.grecaptcha.render) {
                    this.renderCaptcha();
                }
            },
            renderCaptcha() {
                const container = this.$refs.recaptchaContainer;
                if (container && container.childElementCount === 0) {
                    grecaptcha.render(container, {
                        'sitekey': this.siteKey,
                        'callback': (response) => {
                            @this.set('data.recaptcha', response);
                        },
                        'expired-callback': () => {
                            @this.set('data.recaptcha', '');
                        }
                    });
                }
            }
        }"
    >
        <div x-ref="recaptchaContainer"></div>
    </div>

    @error('data.recaptcha')
        <p class="fi-fo-field-wrp-error-message text-sm text-danger-600 dark:text-danger-400" style="margin-top: 0.25rem;">
            {{ $message }}
        </p>
    @enderror
</div>
