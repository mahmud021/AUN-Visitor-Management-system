<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen text-white">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 rounded border px-4 py-3
                            bg-red-100 text-red-700 border-red-400
                            dark:bg-red-800 dark:text-red-200 dark:border-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="text-lg text-gray-300 mb-4">
                Scan the QR code using the camera or upload an image.
            </p>

            <div class="flex gap-3 mb-4">
                <button id="camera-btn" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Use Camera
                </button>
                <button id="file-btn" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Upload Image
                </button>
                <input type="file" id="file-input" accept="image/*" class="hidden">
            </div>

            <form id="scan-form" method="POST" action="{{ route('visitors.scan-process') }}">
                @csrf
                <input type="hidden" name="qr_content" id="qr-content">
            </form>
        </div>
    </div>

    {{-- Push Scanbot + page‑specific JS --}}
    @push('head')
        <script defer src="https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/ScanbotSDK.ui2.min.js"></script>
    @endpush

    @push('scripts')
        <script>
            window.addEventListener('DOMContentLoaded', async () => {
                /* 1) Initialise Scanbot */
                const sdk = await ScanbotSDK.initialize({
                    licenseKey: "",   // TODO: add your key
                    enginePath: "https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/bin/complete/"
                });
                console.log("✅ Scanbot initialised");

                /* 2) Camera scan */
                document.getElementById('camera-btn')
                    .addEventListener('click', async () => {
                        const result = await ScanbotSDK.UI.createBarcodeScanner(
                            new ScanbotSDK.UI.Config.BarcodeScannerScreenConfiguration({
                                beepOnScan: true,
                                multiScanEnabled: false
                            })
                        );
                        if (result?.items?.length) {
                            handleScanResult(result.items[0].barcode.text);
                        }
                    });

                /* 3) File scan */
                const fileInput = document.getElementById('file-input');
                document.getElementById('file-btn')
                    .addEventListener('click', () => fileInput.click());

                fileInput.addEventListener('change', e => {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = async () => {
                        try {
                            const res = await sdk.detectBarcodes(reader.result);
                            if (res.items?.length) {
                                handleScanResult(res.items[0].barcode.text);
                            } else {
                                alert('No QR code found in the image.');
                            }
                        } catch (err) {
                            console.error(err);
                            alert('Error scanning the image.');
                        }
                    };
                });

                /* 4) Shared handler */
                function handleScanResult(text) {
                    document.getElementById('qr-content').value = text;
                    document.getElementById('scan-form').submit();
                }
            });
        </script>
    @endpush
</x-app-layout>
