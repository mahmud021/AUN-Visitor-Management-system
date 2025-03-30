<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Scan Visitor QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                // Request access to the camera
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                    .then(stream => {
                        video.srcObject = stream;
                        video.play();
                        scanQRCode();
                    })
                    .catch(err => {
                        result.innerText = 'Error accessing camera: ' + err;
                        result.classList.add('error');
                    });

                function scanQRCode() {
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
        </div>
    </div>
</x-app-layout>
