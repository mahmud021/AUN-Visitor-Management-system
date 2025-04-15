<!-- visitors/scan.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        #reader {
            width: 600px;
            position: relative;
        }
        #file-input {
            display: none;
        }
        .scan-options {
            margin: 10px 0;
        }
        .btn {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<!-- Display errors if any -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Scan options -->
<div class="scan-options">
    <button id="camera-btn" class="btn">Use Camera</button>
    <button id="file-btn" class="btn">Upload Image</button>
    <input type="file" id="file-input" accept="image/*">
</div>

<!-- Scanner container -->
<div id="reader"></div>

<!-- Hidden form for automatic submission -->
<form id="scan-form" method="POST" action="{{ route('visitors.scan-process') }}">
    @csrf
    <input type="hidden" name="qr_content" id="qr-content">
</form>

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
        // Stop scanning if using camera
        if (currentScanType === 'camera' && html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }

        // Set the hidden input value and submit the form
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

        // Clear previous scanner if exists
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

    // Event listeners
    document.getElementById('camera-btn').addEventListener('click', startCameraScan);
    document.getElementById('file-btn').addEventListener('click', () => {
        document.getElementById('file-input').click();
    });
    document.getElementById('file-input').addEventListener('change', handleFileUpload);

    // Start camera scan by default
    startCameraScan();
</script>
</body>
</html>
