<h3 class="font-semibold text-lg">
    All Visitors
</h3>


<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
        @foreach ($allVisitors as $allVisitor)
            <x-card class="bg-brand-900 text-gray-100 border border-gray-700">
                <div class="flex justify-between items-center gap-x-3">
                    <div class="grow">
                        <h3 class="font-semibold text-lg">
                            {{ $allVisitor->first_name ?? 'Null' }} {{ $allVisitor->last_name ?? 'Null' }}
                        </h3>
                        <p class="text-sm text-gray-400 mt-2">
                            Telephone: {{ $allVisitor->telephone ?? 'Null' }}
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Hosted By: {{ $allVisitor->user->user_details->school_id ?? 'Null' }}
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Visit Date: {{ \Carbon\Carbon::parse($allVisitor->visit_date)->format('M d') }}
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Time: {{ \Carbon\Carbon::parse($allVisitor->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($allVisitor->end_time)->format('h:i A') }}
                        </p>
                        <p class="mt-2">
                            <x-status-badge status="{{ $allVisitor->status }}"/>
                        </p>

                        <!-- Status actions -->
                        <div class="mt-3">
                            @if($allVisitor->status == 'pending')
                                @if(auth()->user()?->user_details?->role === 'HR Admin' || auth()->user()?->user_details?->role === 'super admin')
                                    <!-- Approve Form -->
                                    <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                        <x-primary-button class="bg-green-600 hover:bg-green-700 text-white">
                                            Approve
                                        </x-primary-button>
                                    </form>

                                    <!-- Deny Form -->
                                    <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline ml-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="denied">
                                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                        <x-primary-button class="bg-red-600 hover:bg-red-700 text-white">
                                            Deny
                                        </x-primary-button>
                                    </form>
                                @endif
                            @elseif($allVisitor->status == 'approved')
                                @include('visitors.partials.checkin_form', ['visitor' => $allVisitor])
                            @elseif($allVisitor->status == 'checked_in')
                                <!-- Check-out Form -->
                                <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="checked_out">
                                    <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                    <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                                        Check Out
                                    </x-primary-button>
                                </form>
                            @elseif($allVisitor->status == 'denied')
                                <span class="text-red-400">Visitor denied</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('visitors.timeline', $allVisitor->id) }}">
                        <svg class="shrink-0 size-5 text-gray-300"
                             xmlns="http://www.w3.org/2000/svg"
                             width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </x-card>
        @endforeach
    </div>
    <div class="mt-6 flex justify-center">
        {{ $allVisitors->links() }}
    </div>
</div>
