<div class="container">
    <div class="row justify-content-center mb-2">
        <div class="col-md-3">
            <div class="justify-content-center">
                <label>Select Number of columns</label>
                <select class="form-control" wire:click="changeCount($event.target.value)">
                    @foreach($column_count as $key => $count)
                        <option value="{{ $key }}">{{ $count }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <label>Select Number of columns</label>
    </div>
    <div class="row justify-content-center">
        @if ($column_count_id > 0)
        <div class="col-md-3">
            <div>
                <select 
                class="form-control" wire:click="changeType(1,$event.target.value)" wire:model="col1">
                    @foreach($selectables[0] as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        @if ($column_count_id > 1)
        <div class="col-md-3">
            <div>
                <select 
                class="form-control" wire:click="changeType(2,$event.target.value)" wire:model="col2">
                    @foreach($selectables[1] as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        @if ($column_count_id > 2)
        <div class="col-md-3">
            <div>
                <select 
                class="form-control" wire:click="changeType(3,$event.target.value)" wire:model="col3">
                    @foreach($selectables[2] as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
    </div>
    <button class="btn btn-primary" wire:click="savesettings">Save</button>
</div>
