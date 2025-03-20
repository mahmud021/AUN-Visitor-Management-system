<table class="min-w-full divide-y divide-neutral-700">
    <thead>
    <tr>
        @foreach ($columns as $column)
            <th class="px-4 py-2 text-left text-xs font-medium text-neutral-400 uppercase">
                {{ $column }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody class="divide-y divide-neutral-700">
    @foreach ($visitors as $visitor)
        <tr class="visitor-row">
            <td class="px-4 py-2 whitespace-nowrap">
                    <span class="block text-sm font-semibold text-neutral-200">
                        {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                    </span>
                <span class="block text-sm text-neutral-400">
                        {{ $visitor->telephone ?? 'Null' }}
                    </span>
            </td>
            <td class="px-4 py-2 whitespace-nowrap">
                    <span class="block text-sm font-semibold text-neutral-200">
                        @if(in_array('Visit Date', $columns))
                            {{ \Illuminate\Support\Carbon::parse($visitor->start_time)->format('h:i A') }}
                        @else
                            {{ \Illuminate\Support\Carbon::parse($visitor->end_time)->format('h:i A') }}
                        @endif
                    </span>
            </td>
            <td class="px-4 py-2 whitespace-nowrap">
                    <span class="block text-sm font-semibold text-neutral-200">
                        {{ $visitor->user->user_details->school_id ?? 'Null' }}
                    </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
