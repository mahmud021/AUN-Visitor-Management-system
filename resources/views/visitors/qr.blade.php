<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('QR code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-white">

            <div class="container">
                <h1>Visitor QR Code</h1>
                <p><strong>Name:</strong> {{ $visitor->first_name }} {{ $visitor->last_name }}</p>
                <p><strong>Visit Date:</strong> {{ $visitor->visit_date }}</p>
                <p><strong>Start Time:</strong> {{ $visitor->start_time }}</p>
                <p><strong>End Time:</strong> {{ $visitor->end_time }}</p>

                @if($qrCode)
                    <img id="qrCodeImage" src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
                @else
                    <p style="color: red;">Error: QR Code not generated.</p>
                @endif

                <p>Please save or print this QR code and present it at check-in.</p>
                <div>
                    <a href="#" id="downloadBtn" class="btn download-btn">Download QR Code</a>
                    <a href="{{ route('visitors.index') }}" class="btn">Back to Visitors</a>
                </div>
            </div>

            <script>
                document.getElementById('downloadBtn').addEventListener('click', function(e) {
                    e.preventDefault();
                    const qrImage = document.getElementById('qrCodeImage');
                    const link = document.createElement('a');
                    link.href = qrImage.src;
                    link.download = 'visitor-qr-code-{{ $visitor->first_name }}-{{ $visitor->last_name }}.png';
                    link.click();
                });
            </script>
        </div>
    </div>
</x-app-layout>
