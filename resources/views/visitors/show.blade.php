<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Visitor Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Carousel and Details -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 sm:items-start gap-8">
                <!-- Left Column: Visitor Details -->
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base/7 font-semibold text-brand-50"></h3>
                        <p class="mt-1 max-w-2xl text-sm/6 text-brand-300">Visitor details.</p>
                    </div>
                    <div class="mt-6 border-t border-brand-800">
                        <dl class="divide-y divide-brand-800">
                            <!-- Name & Host -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Visitor Name</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                    <p>
                                        Hosted by:
                                        @if(is_null($visitor->user_id))
                                            Walk-In
                                        @else
                                            {{ $visitor->user->first_name ?? 'Null' }} {{ $visitor->user->last_name ?? 'Null' }}
                                        @endif
                                    </p>
                                </dd>
                            </div>

                            <!-- Telephone -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Telephone</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->telephone ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Date and Time -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Date and Time</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($visitor->visit_date)->format('d M, Y') }}
                                    <p>{{ \Carbon\Carbon::parse($visitor->start_time)->format('g:i a') }} - {{ \Carbon\Carbon::parse($visitor->end_time)->format('g:i a') }}</p>
                                </dd>
                            </div>

                            <!-- Location -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Location</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->location ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Purpose of Visit -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Purpose of Visit</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ $visitor->purpose_of_visit ?? 'Null' }}
                                </dd>
                            </div>

                            <!-- Visitor Code (Only show to creator) -->
                            @if(auth()->id() === $visitor->user_id)
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-brand-50">Visitor Code</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                        {{ $visitor->visitor_code ?? 'Null' }}
                                    </dd>
                                </div>
                            @endif

                            <!-- Status -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Status</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                                </dd>
                            </div>

                            <!-- Created At -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Created</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($visitor->created_at)->format('d M, Y') }}
                                </dd>
                            </div>

                            <!-- Back Home Button -->
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50"></dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                                hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700
                                                focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Back Home
                                    </a>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Right Column: QR Code -->
                <!-- Right Column: QR Code (Only show to creator) -->
                @if(auth()->id() === $visitor->user_id && $qrCode)
                    <div class="flex justify-center sm:justify-end items-start">
                        <div class="max-w-sm w-full">
                            <img id="qrCodeImage" src="data:image/png;base64,{{ base64_encode($qrCode) }}"
                                 alt="QR Code" class="mx-auto w-[400px] h-[400px]">
                            <h3 class="font-semibold text-lg mt-4 text-brand-50">
                                Please save or print this QR code and present it at check-in.
                            </h3>
                            <div class="mt-4">
                                <button id="downloadBtn" class="bg-brand-700 hover:bg-brand-600 text-white font-semibold py-2 px-4 rounded">
                                    Download QR Code
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for QR Code Download -->
    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const img = document.getElementById('qrCodeImage');
            const link = document.createElement('a');
            link.href = img.src;
            link.download = 'visitor-qr-code.png';
            link.click();
        });
    </script>
</x-app-layout>
