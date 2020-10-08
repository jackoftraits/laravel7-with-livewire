<div>
    <input class="form-control search-input" wire:model.debounce.500ms="searchTerm" type="text" placeholder="Search..."/>
    <table class="table table-striped">
        <thead>
            @foreach ($headers as $key => $value)
                <th width="5%" style="cursor: pointer" wire:click="sort('{{ $key }}')">
                    @if($sortColumn == $key) 
                        <span>{!! $sortDirection == 'asc' ? '&#8659;':'&#8657;' !!}</span>
                    @endif
                    {{ is_array($value) ? $value['label'] : $value }}
                </th>
            @endforeach
        </thead>
        <tbody>
            @if(count($data))
                @foreach ($data as $item)
                    <tr>
                        @foreach ($headers as $key => $value)
                            <td>
                                {!! is_array($value) ? $value['func']($item->$key) : $item->$key !!}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr><td colspan="{{ count($headers) }}"><h2>No Results Found!</h2></td></tr>
            @endif
        </tbody>
    </table>
    {{ $data->links() }}
</div>
