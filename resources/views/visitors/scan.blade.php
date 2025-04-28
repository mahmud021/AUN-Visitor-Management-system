{{-- resources/views/visitors/scan.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Scanner') }}
        </h2>
    </x-slot>

    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid sm:grid-cols-2 sm:items-start gap-8">

            {{-- Error block --}}
            @if ($errors->any())
                <div class="rounded border px-4 py-3 bg-red-100 text-red-700 border-red-400
                            dark:bg-red-800 dark:text-red-200 dark:border-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 1) Scan UI (hidden once a $visitor is present) --}}
            <div id="scan-ui" @isset($visitor) class="hidden" @endisset>
                <p class="text-lg text-gray-300 mb-4">
                    Scan the QR code using the camera or upload an image.
                </p>
                <div class="flex gap-3 mb-4">
                    <button id="camera-btn"
                            class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">
                        Use Camera
                    </button>
                    <button id="file-btn"
                            class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">
                        Upload Image
                    </button>
                    <input type="file" id="file-input" accept="image/*" class="hidden">
                </div>
                <form id="scan-form" method="POST" action="{{ route('visitors.scan-process') }}">
                    @csrf
                    <input type="hidden" name="qr_content" id="qr-content">
                </form>
            </div>


            @isset($visitor)
                <div id="confirm-ui">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base/7 font-semibold text-brand-50"></h3>
                        <p class="mt-1 max-w-2xl text-sm/6 text-brand-300">Visitor details.</p>
                    </div>
                    <div class="mt-6 border-t border-brand-800">
                        <dl class="divide-y divide-brand-800">
                            <!-- Name & Host -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Visitor Name</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                    <p>
                                        Hosted by:
                                        @if(is_null($visitor->user_id))
                                            Walk-In
                                        @else
                                            {{ $visitor->user->first_name ?? 'Null' }} {{ $visitor->user->last_name ?? 'Null' }}
                                        @endif
                                    </p>
                                </dd>
                            </div>

                            <!-- Telephone -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Telephone</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->telephone ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Date and Time -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Date and Time</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($visitor->visit_date)->format('d M, Y') }}
                                    <p>{{ \Carbon\Carbon::parse($visitor->start_time)->format('g:i a') }}
                                        - {{ \Carbon\Carbon::parse($visitor->end_time)->format('g:i a') }}</p>
                                </dd>
                            </div>

                            <!-- Location -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Location</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->location ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Purpose of Visit -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Purpose of Visit</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->purpose_of_visit ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Visitor Code -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Visitor Code</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->visitor_code ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Status -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Status</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <x-status-badge status="{{ $visitor->status ?? 'Null' }}"/>
                                </dd>
                            </div>

                            <!-- Created At -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Created</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($visitor->created_at)->format('d M, Y') }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Action Buttons</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <div class="flex items-center gap-4 mb-4">
                                        <form id="checkin-form"
                                              method="POST"
                                              action="{{ route('visitors.autoCheckin', $visitor) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="bg-green-600 hover:bg-green-500 text-white py-2 px-4 rounded">
                                                Check In Now
                                            </button>
                                        </form>
                                    </div>
                                </dd>
                            </div>

                            <!-- Back Home Button -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50"></dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <a
                                        href="{{ route('visitors.scan') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                                hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700
                                                focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Back To QR Scanner
                                    </a>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            @endisset
        </div>
    </div>


    {{-- 2) Confirmation Panel --}}

    {{--                <div id="confirm-ui"--}}
    {{--                     class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-gray-900 dark:text-gray-100">--}}
    {{--                    <h3 class="text-xl font-semibold mb-4">Visitor Details</h3>--}}
    {{--                    <ul class="space-y-1 mb-6">--}}
    {{--                        <li><strong>Name:</strong> {{ $visitor->first_name }} {{ $visitor->last_name }}</li>--}}
    {{--                        <li><strong>Phone:</strong> {{ $visitor->telephone }}</li>--}}
    {{--                        <li><strong>Date:</strong> {{ $visitor->visit_date }}</li>--}}
    {{--                        <li><strong>Time:</strong>--}}
    {{--                            {{ $visitor->start_time }} –--}}
    {{--                            {{ \Carbon\Carbon::parse($visitor->end_time)->format('H:i') }}--}}
    {{--                        </li>--}}
    {{--                        <li><strong>Location:</strong> {{ $visitor->location }}</li>--}}
    {{--                        <li><strong>Purpose:</strong> {{ $visitor->purpose_of_visit }}</li>--}}
    {{--                    </ul>--}}

    {{--                    <div class="flex items-center gap-4 mb-4">--}}
    {{--                        --}}{{-- Check In Now --}}
    {{--                        <form id="checkin-form"--}}
    {{--                              method="POST"--}}
    {{--                              action="{{ route('visitors.autoCheckin', $visitor) }}">--}}
    {{--                            @csrf--}}
    {{--                            @method('PATCH')--}}
    {{--                            <button type="submit"--}}
    {{--                                    class="bg-green-600 hover:bg-green-500 text-white py-2 px-4 rounded">--}}
    {{--                                Check In Now--}}
    {{--                            </button>--}}
    {{--                        </form>--}}

    {{--                        --}}{{-- Halt auto-checkin --}}
    {{--                        <button id="halt-btn"--}}
    {{--                                class="bg-red-600 hover:bg-red-500 text-white py-2 px-4 rounded">--}}
    {{--                            Halt Auto‑Check‑In--}}
    {{--                        </button>--}}

    {{--                        --}}{{-- Back to Scan --}}
    {{--                        <a href="{{ route('visitors.scan') }}"--}}
    {{--                           class="bg-gray-600 hover:bg-gray-500 text-white py-2 px-4 rounded">--}}
    {{--                            Back to Scan--}}
    {{--                        </a>--}}
    {{--                    </div>--}}

    {{--                    <p class="text-sm">--}}
    {{--                        Auto‑check‑in in--}}
    {{--                        <span id="countdown" class="font-bold text-lg text-red-600">60</span>--}}
    {{--                        seconds…--}}
    {{--                    </p>--}}
    {{--                </div>--}}


    {{-- Scanbot bundle --}}
    @push('head')
        <script defer src="{{ asset('vendor/scanbot/ScanbotSDK.ui2.min.js') }}"></script>
    @endpush

    {{-- Page scripts --}}
    @push('scripts')
        <script>
            window.addEventListener('DOMContentLoaded', async () => {
                // 1) Initialize Scanbot
                const sdk = await ScanbotSDK.initialize({
                    licenseKey: "",  // ← your key here
                    enginePath: "/vendor/scanbot/bin/complete/"
                });

                // If no $visitor, wire up scan buttons
                if (!@json(isset($visitor))) {
                    // Camera scan
                    document.getElementById('camera-btn')
                        .addEventListener('click', async () => {
                            const result = await ScanbotSDK.UI.createBarcodeScanner(
                                new ScanbotSDK.UI.Config.BarcodeScannerScreenConfiguration({
                                    beepOnScan: true,
                                    multiScanEnabled: false
                                })
                            );
                            if (result?.items?.length) {
                                document.getElementById('qr-content').value =
                                    result.items[0].barcode.text;
                                document.getElementById('scan-form').submit();
                            }
                        });

                    // File scan
                    const fileInput = document.getElementById('file-input');
                    document.getElementById('file-btn')
                        .addEventListener('click', () => fileInput.click());

                    fileInput.addEventListener('change', e => {
                        const file = e.target.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = async () => {
                            const res = await sdk.detectBarcodes(reader.result);
                            if (res.items?.length) {
                                document.getElementById('qr-content').value =
                                    res.items[0].barcode.text;
                                document.getElementById('scan-form').submit();
                            } else {
                                alert('No QR code found.');
                            }
                        };
                    });
                }

            });
        </script>
    @endpush

</x-app-layout>
