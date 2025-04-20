<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-primary text-white min-h-screen">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-800 dark:border-red-700 dark:text-red-200 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="text-lg text-gray-300 mb-4">Scan the QR code using the camera or upload an image.</p>

            <!-- Scan options -->
            <div class="scan-options mb-4 flex gap-3">
                <button id="camera-btn" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">Use Camera</button>
                <button id="file-btn" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded">Upload Image</button>
                <input type="file" id="file-input" accept="image/*" class="hidden">
            </div>

            <!-- Hidden form for automatic submission -->
            <form id="scan-form" method="POST" action="{{ route('visitors.scan-process') }}">
                @csrf
                <input type="hidden" name="qr_content" id="qr-content">
            </form>
        </div>
    </div>

    {{-- 1) Load Scanbot UI bundle (PoC only!) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/ScanbotSDK.ui2.min.js"></script>

    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            // 2) Initialize Scanbot SDK
            const sdk = await ScanbotSDK.initialize({
                licenseKey: "",
                enginePath: "https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/bin/complete/"
            });
            console.log("✅ Scanbot initialized");

            // Camera-based scanning
            document.getElementById('camera-btn').addEventListener('click', async () => {
                console.log("🔘 Camera scan launched");
                const config = new ScanbotSDK.UI.Config.BarcodeScannerScreenConfiguration({
                    beepOnScan: true,
                    multiScanEnabled: false,
                });
                const result = await ScanbotSDK.UI.createBarcodeScanner(config);
                console.log("📷 Camera scan result:", result);
                if (result?.items?.length) {
                    // take first item
                    handleScanResult(result.items[0].barcode.text);
                }
            });

            // File-based scanning
            const fileInput = document.getElementById('file-input');
            document.getElementById('file-btn').addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = async () => {
                    try {
                        // 3) Detect barcodes in the image
                        const imageResult = await sdk.detectBarcodes(reader.result);  // :contentReference[oaicite:0]{index=0}
                        console.log("🖼️ Image scan result:", imageResult);
                        if (imageResult.items?.length) {
                            handleScanResult(imageResult.items[0].barcode.text);
                        } else {
                            alert('No QR code found in the image.');
                        }
                    } catch (err) {
                        console.error("❌ File scan error:", err);
                        alert('Error scanning the image. See console for details.');
                    }
                };
            });
        });

        // Shared handler: fills form & submits
        function handleScanResult(decodedText) {
            document.getElementById('qr-content').value = decodedText;
            document.getElementById('scan-form').submit();
        }
    </script>
</x-app-layout>
