{{-- resources/views/visitors/scan.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen text-white">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8 space-y-6">

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

            {{-- 2) Confirmation Panel --}}
            @isset($visitor)
                <div id="confirm-ui"
                     class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Visitor Details</h3>
                    <ul class="space-y-1 mb-6">
                        <li><strong>Name:</strong> {{ $visitor->first_name }} {{ $visitor->last_name }}</li>
                        <li><strong>Phone:</strong> {{ $visitor->telephone }}</li>
                        <li><strong>Date:</strong> {{ $visitor->visit_date }}</li>
                        <li><strong>Time:</strong>
                            {{ $visitor->start_time }} –
                            {{ \Carbon\Carbon::parse($visitor->end_time)->format('H:i') }}
                        </li>
                        <li><strong>Location:</strong> {{ $visitor->location }}</li>
                        <li><strong>Purpose:</strong> {{ $visitor->purpose_of_visit }}</li>
                    </ul>

                    <div class="flex items-center gap-4 mb-4">
                        {{-- Check In Now --}}
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

                        {{-- Halt auto-checkin --}}
                        <button id="halt-btn"
                                class="bg-red-600 hover:bg-red-500 text-white py-2 px-4 rounded">
                            Halt Auto‑Check‑In
                        </button>

                        {{-- Back to Scan --}}
                        <a href="{{ route('visitors.scan') }}"
                           class="bg-gray-600 hover:bg-gray-500 text-white py-2 px-4 rounded">
                            Back to Scan
                        </a>
                    </div>

                    <p class="text-sm">
                        Auto‑check‑in in
                        <span id="countdown" class="font-bold text-lg text-red-600">60</span>
                        seconds…
                    </p>
                </div>
            @endisset

        </div>
    </div>

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

                // If we have a $visitor, start the 60s countdown
                @isset($visitor)
                (function() {
                    let seconds = 60;
                    const cdEl   = document.getElementById('countdown');
                    const halt   = document.getElementById('halt-btn');
                    const form   = document.getElementById('checkin-form');

                    const timer = setInterval(() => {
                        if (--seconds <= 0) {
                            clearInterval(timer);
                            form.submit();
                        } else {
                            cdEl.textContent = seconds;
                        }
                    }, 1000);

                    halt.addEventListener('click', () => {
                        clearInterval(timer);
                        cdEl.textContent = 'HALTED';
                        halt.disabled = true;
                    });
                })();
                @endisset

            });
        </script>
    @endpush

</x-app-layout>
