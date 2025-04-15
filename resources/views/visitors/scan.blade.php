<!DOCTYPE html>
<html>
<head>
    <title>QR Code Scanner</title>
    <!-- Include the library -->
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
    </style>
</head>
<body>
<!-- Scan options -->
<div class="scan-options">
    <button id="camera-btn" class="btn">Use Camera</button>
    <button id="file-btn" class="btn">Upload Image</button>
    <input type="file" id="file-input" accept="image/*">
</div>

<!-- Scanner container -->
<div id="reader"></div>

<!-- Result display -->
<div id="result" style="display: none;">
    <p>Scanned Result: <span id="result-text"></span></p>
    <form id="scan-form" method="POST" action="">
        @csrf
        <input type="hidden" name="qr_content" id="qr-content">
        <button type="submit" class="btn">Process Scan</button>
        <button id="rescan-btn" type="button" class="btn">Scan Again</button>
    </form>
</div>

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

        // Hide scanner and show results
        document.getElementById('reader').style.display = 'none';
        document.getElementById('result').style.display = 'block';
        document.getElementById('result-text').textContent = decodedText;
        document.getElementById('qr-content').value = decodedText;
    }

    function startCameraScan() {
        currentScanType = 'camera';
        document.getElementById('reader').style.display = 'block';
        document.getElementById('result').style.display = 'none';

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
        document.getElementById('result').style.display = 'none';

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
    document.getElementById('rescan-btn').addEventListener('click', () => {
        document.getElementById('result').style.display = 'none';
        startCameraScan();
    });

    // Initialize camera scan by default
    startCameraScan();
</script>
</body>
</html>
