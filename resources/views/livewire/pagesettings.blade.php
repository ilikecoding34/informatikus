<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="justify-content-center">
                <select class="form-control" wire:click="changeCount($event.target.value)">
                    <option value="">-- Select Number --</option>
                    @foreach($column_count as $key => $count)
                        <option value="{{ $key }}">{{ $count }}</option>
                    @endforeach
                </select>
                <p>Selected City ID: {{ $column_count_id }}</p>
            </div>
        </div>
        @if ($column_count_id > 0)
        <div class="col-md-3">
            <div>
                <select 
                class="form-control" wire:click="changeType(1,$event.target.value)" wire:model="col1">
                    <option value="">Oszlop 1</option>
                    @foreach($selectables[0] as $key => $type)
                        <option
                       
                        value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
                <p>Tipus: {{ $col1 }}</p>
            </div>
        </div>
        @endif
        @if ($column_count_id > 1)
        <div class="col-md-3">
            <div>
                <select 
                class="form-control" wire:click="changeType(2,$event.target.value)" wire:model="col2">
                    <option value="">Oszlop 2</option>
                    @foreach($selectables[1] as $key => $type)
                        <option
                       
                        value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
                <p>Tipus: {{ $col2 }}</p>
            </div>
        </div>
        @endif
        @if ($column_count_id > 2)
        <div class="col-md-3">
            <div>
                <select 
                class="form-control" wire:click="changeType(3,$event.target.value)" wire:model="col3">
                    <option value="">Oszlop 3</option>
                    @foreach($selectables[2] as $key => $type)
                        <option
                        value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
                <p>Tipus: {{ $col3 }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
