@if(session('success'))
    <script>
        function tostifyCustomClose(el) {
            const parent = el.closest('.toastify');
            const close = parent.querySelector('.toast-close');
            close.click();
        }

        document.addEventListener("DOMContentLoaded", function () {
            const toastMarkup = `
         <!-- Toast -->
            <div id="dismiss-toast" class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-success-example-label">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p id="hs-toast-success-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                            {{ session('success') }}
            </p>
        </div>
    </div>
</div>
<!-- End Toast -->`;



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
       <!-- Toast -->
            <div id="dismiss-toast" class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-error-example-label">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                        </svg>
                    </div>
                    <div class="ms-3">
                        <h2>Error</h2>
                        <p id="hs-toast-error-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                            ${errorMessages}
                        </p>

                    </div>
                </div>
            </div>
            <!-- End Toast -->`;

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
