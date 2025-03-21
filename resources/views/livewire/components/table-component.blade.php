<div class="p-4 bg-white shadow rounded-lg">
    <!-- Check if records exist -->
    @if ($records->count() > 0)
        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-100">
                @foreach ($columns as $column)
                    <th
                        class="p-2 text-left cursor-pointer"
                        wire:click="sort('{{ $column['field'] }}')"
                    >
                        {{ $column['label'] }}
                        @if ($sortBy === $column['field'])
                            <span class="text-xs">
                                    {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                                </span>
                        @endif
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($records as $record)
                <tr class="border-t">
                    @foreach ($columns as $column)
                        <td class="p-2">
                            {{ data_get($record, $column['field']) }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $records->links() }}
        </div>
    @else
        <p class="text-center text-gray-500">No records found.</p>
    @endif
</div>
