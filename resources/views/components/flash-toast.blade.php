@if(session('success'))
    <script>
        function tostifyCustomClose(el) {
            const parent = el.closest('.toastify');
            const close = parent.querySelector('.toast-close');
            close.click();
        }

        document.addEventListener("DOMContentLoaded", function () {
            const toastMarkup = `
        <div class="flex p-4">
            <p class="text-sm text-gray-700 dark:text-neutral-400">{{ session('success') }}</p>
            <div class="ms-auto">
                <button onclick="tostifyCustomClose(this)" type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
        </div>`;

            Toastify({
                text: toastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 fixed top-5 right-5 z-50 transition-all duration-300 w-[320px] bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 [&>.toast-close]:hidden",
                duration: 3000,
                close: true,
                escapeMarkup: false
            }).showToast();
        });
    </script>
@endif

@if($errors->any())
    <script>
        function tostifyCustomClose(el) {
            const parent = el.closest('.toastify');
            const close = parent.querySelector('.toast-close');
            close.click();
        }

        document.addEventListener("DOMContentLoaded", function () {
            let errorMessages = "";
            @foreach($errors->all() as $error)
                errorMessages += "<p>{{ $error }}</p>";
            @endforeach

            const errorToastMarkup = `
        <div class="flex p-4">
            <div>
                <h3 class="text-gray-800 font-semibold dark:text-white">Error!</h3>
                <div class="text-sm text-gray-700 dark:text-neutral-400">${errorMessages}</div>
            </div>
            <div class="ms-auto">
                <button onclick="tostifyCustomClose(this)" type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
        </div>`;

            Toastify({
                text: errorToastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 fixed top-5 right-5 z-50 transition-all duration-300 w-[320px] bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 [&>.toast-close]:hidden",
                duration: 5000,
                close: true,
                escapeMarkup: false
            }).showToast();
        });
    </script>
@endif
