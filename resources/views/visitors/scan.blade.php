<!DOCTYPE html>
<html>
<head>
    <title>QR Code Scanner</title>
    <!-- Include the library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
<div id="reader" style="width: 600px;"></div>

<!-- Result display -->
<div id="result" style="display: none;">
    <p>Scanned Result: <span id="result-text"></span></p>
    <form id="scan-form" method="POST" action="">
        @csrf
        <input type="hidden" name="qr_content" id="qr-content">
        <button type="submit">Process Scan</button>
    </form>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning
        html5QrcodeScanner.clear();
        document.getElementById('reader').style.display = 'none';

        // Display results
        document.getElementById('result').style.display = 'block';
        document.getElementById('result-text').textContent = decodedText;
        document.getElementById('qr-content').value = decodedText;

        // Optional: Auto-submit form
        // document.getElementById('scan-form').submit();
    }

    function onScanFailure(error) {
        console.warn(`Scan error: ${error}`);
    }

    // Initialize scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
        },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
</body>
</html>
