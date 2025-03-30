<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight text-center">
            {{ __('QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 text-center text-white">

            <div class="mb-4">
                <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                    <a href="{{ route('dashboard') }}" class="btn">Back to Home</a>
                </x-primary-button>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg shadow-md inline-block">
                @if($qrCode)
                    <img id="qrCodeImage" src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" class="mx-auto">
                    <h3 class="font-semibold text-lg mt-4">
                        Please save or print this QR code and present it at check-in.
                    </h3>
                    <div class="mt-4">
                        <a href="#" id="downloadBtn" class="bg-brand-700 hover:bg-brand-600 text-white font-semibold py-2 px-4 rounded">
                            Download QR Code
                        </a>
                    </div>
                @else
                    <p class="text-red-500">Error: QR Code not generated.</p>
                @endif
            </div>

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
</x-app-layout>
