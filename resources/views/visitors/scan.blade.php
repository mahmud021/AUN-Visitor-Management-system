<!DOCTYPE html>
<html>
<head>
    <title>Scan Visitor QR Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            max-width: 100%;
            margin: 0 auto;
        }
        video {
            width: 100%;
            max-width: 500px;
            border: 2px solid #007bff;
            border-radius: 5px;
        }
        #result {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Scan Visitor QR Code</h1>
    <video id="video" autoplay playsinline></video>
    <canvas id="canvas" style="display: none;"></canvas>
    <p id="result"></p>
    <a href="{{ route('visitors.index') }}" class="btn">Back to Visitors</a>
</div>

<!-- Include jsQR library from CDN -->
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const result = document.getElementById('result');

    // Request access to the camera with minimal constraints
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
            video.play();
            // Wait for the video to load metadata before scanning
            video.onloadedmetadata = () => {
                scanQRCode();
            };
        })
        .catch(err => {
            result.innerText = 'Error accessing camera: ' + err;
            result.classList.add('error');
        });

    function scanQRCode() {
        // Ensure video dimensions are available
        if (video.videoWidth === 0 || video.videoHeight === 0) {
            result.innerText = 'Video dimensions not available, retrying...';
            result.classList.add('error');
            setTimeout(scanQRCode, 1000);
            return;
        }

        // Set canvas size to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw the video frame to the canvas
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
            // QR code found, extract the token
            const token = code.data;
            checkIn(token);
        } else {
            // No QR code found, continue scanning
            requestAnimationFrame(scanQRCode);
        }
    }

    function checkIn(token) {
        fetch('{{ route('visitors.checkInWithQR') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ token: token })
        })
            .then(response => response.json())
            .then(data => {
                result.innerText = data.message;
                result.classList.add(data.success ? 'success' : 'error');
                // Stop the camera after successful check-in
                if (data.success) {
                    const stream = video.srcObject;
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                } else {
                    // Continue scanning if check-in fails
                    setTimeout(() => {
                        result.innerText = '';
                        result.classList.remove('error');
                        scanQRCode();
                    }, 2000);
                }
            })
            .catch(error => {
                result.innerText = 'Error: ' + error;
                result.classList.add('error');
                setTimeout(() => {
                    result.innerText = '';
                    result.classList.remove('error');
                    scanQRCode();
                }, 2000);
            });
    }
</script>
</body>
</html>
