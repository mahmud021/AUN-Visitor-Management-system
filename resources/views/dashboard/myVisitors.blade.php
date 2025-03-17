<h3 class="font-semibold text-lg">
    My Visitors
</h3>
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
        @foreach ($myVisitors as $myVisitor)
            <x-card class="text-gray-100 border border-gray-700">
                <div class="flex justify-between items-center gap-x-3">
                    <div class="grow">
                        <h3 class="font-semibold text-lg mt-2">
                            {{ $myVisitor->first_name ?? 'Null' }} {{ $myVisitor->last_name ?? 'Null' }}
                        </h3>
                        <p class="text-sm text-gray-400 mt-2">
                            Telephone: {{ $myVisitor->telephone ?? 'Null' }}
                        </p>
                        <p class="mt-2 text-base font-semibold text-blue-400">
                            Access Code:
                            <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                                {{ $myVisitor->visitor_code ?? 'Null' }}
                                            </span>
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Visit Date: {{ \Carbon\Carbon::parse($myVisitor->visit_date)->format('M d') }}
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Time: {{ \Carbon\Carbon::parse($myVisitor->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($myVisitor->end_time)->format('h:i A') }}
                        </p>

                        <p class="mt-2">
                            <x-status-badge status="{{ $myVisitor->status ?? 'Null' }}"/>
                        </p>
                    </div>
                    <a href="{{ route('visitors.timeline', $myVisitor->id) }}">
                        <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
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
        {{ $myVisitors->links() }}
    </div>
</div>
