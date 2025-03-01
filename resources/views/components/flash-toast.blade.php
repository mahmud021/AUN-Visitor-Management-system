@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Updated success toast markup with the new design.
            const toastMarkup = `
                <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30 relative" role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                  <div class="flex">
                    <div class="shrink-0">
                      <!-- Icon -->
                      <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                          <path d="m9 12 2 2 4-4"></path>
                        </svg>
                      </span>
                      <!-- End Icon -->
                    </div>
                    <div class="ms-3">
 <button onclick="tostifyCustomClose(this)" type="button" class="absolute top-2 right-2 inline-flex justify-center items-center rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M18 6 6 18"></path>
                      <path d="m6 6 12 12"></path>
                    </svg>
                  </button>
                      <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
                        Successfully updated.
                      </h3>
                      <p class="text-sm text-gray-700 dark:text-neutral-400">
                        You have successfully updated your email preferences.
                      </p>
                    </div>
                  </div>
                  <button onclick="tostifyCustomClose(this)" type="button" class="absolute top-2 right-2 inline-flex justify-center items-center rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M18 6 6 18"></path>
                      <path d="m6 6 12 12"></path>
                    </svg>
                  </button>
                </div>
            `;

            Toastify({
                text: toastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 fixed top-5 right-5 z-50 transition-all duration-300 w-[320px] bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400",
                duration: 3000,
                close: false,
                escapeMarkup: false
            }).showToast();
        });
    </script>
@endif

@if($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Build a string with all error messages.
            let errorMessages = "";
            @foreach($errors->all() as $error)
                errorMessages += "<p>{{ $error }}</p>";
            @endforeach

            // Updated error toast markup with the new design.
            const errorToastMarkup = `
                <div class="bg-red-50 border-s-4 border-red-500 p-4 dark:bg-red-800/30 relative" role="alert" tabindex="-1" aria-labelledby="hs-bordered-red-style-label">
                  <div class="flex">
                    <div class="shrink-0">
                      <!-- Icon -->
                      <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M18 6 6 18"></path>
                          <path d="m6 6 12 12"></path>
                        </svg>
                      </span>
                      <!-- End Icon -->
                    </div>
                    <div class="ms-3">
                      <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold dark:text-white">
                        Error!
                      </h3>
                      <p class="text-sm text-gray-700 dark:text-neutral-400">
                        ${errorMessages}
                      </p>
                    </div>
                  </div>
                  <button onclick="tostifyCustomClose(this)" type="button" class="absolute top-2 right-2 inline-flex justify-center items-center rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M18 6 6 18"></path>
                      <path d="m6 6 12 12"></path>
                    </svg>
                  </button>
                </div>
            `;

            Toastify({
                text: errorToastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 fixed top-5 right-5 z-50 transition-all duration-300 w-[320px] bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400",
                duration: 5000,
                close: false,
                escapeMarkup: false
            }).showToast();
        });
    </script>
@endif
