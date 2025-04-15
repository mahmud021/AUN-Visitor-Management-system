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

            <!-- Scanner container -->
            <div id="reader" class="w-full border-2 border-dashed border-gray-300 p-4 rounded"></div>

            <!-- Hidden form for automatic submission -->
            <form id="scan-form" method="POST" action="{{ route('visitors.scan-process') }}">
                @csrf
                <input type="hidden" name="qr_content" id="qr-content">
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner;
        let currentScanType = 'camera'; // 'camera' or 'file'

        function onScanSuccess(decodedText, decodedResult) {
            handleScanResult(decodedText);
        }

        function onScanFailure(error) {
            console.warn(`Scan error: ${error}`);
        }

        function handleScanResult(decodedText) {
            if (currentScanType === 'camera' && html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            document.getElementById('qr-content').value = decodedText;
            document.getElementById('scan-form').submit();
        }

        function startCameraScan() {
            currentScanType = 'camera';
            document.getElementById('reader').style.display = 'block';

            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                },
                false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        function handleFileUpload(event) {
            currentScanType = 'file';
            const file = event.target.files[0];
            if (!file) return;

            document.getElementById('reader').style.display = 'block';

            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            const html5QrCode = new Html5Qrcode("reader");
            html5QrCode.scanFile(file, true)
                .then(decodedText => {
                    handleScanResult(decodedText);
                })
                .catch(err => {
                    console.error(`Error scanning file: ${err}`);
                    alert('Error scanning file. Please try another image.');
                });
        }

        document.getElementById('camera-btn').addEventListener('click', startCameraScan);
        document.getElementById('file-btn').addEventListener('click', () => {
            document.getElementById('file-input').click();
        });
        document.getElementById('file-input').addEventListener('change', handleFileUpload);

        startCameraScan();
    </script>
</x-app-layout>
