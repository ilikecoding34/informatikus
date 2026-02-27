<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Főoldal elrendezése</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Válaszd ki, mi jelenjen meg a bal és a jobb oldali oszlopban. A középső oszlop (összes bejegyzés) mindig látható. Mindkét oldalról választhatsz egyet az alábbi lehetőségek közül; ha „Nincs” van kiválasztva, az oszlop rejtve marad.
                    </p>

                    <form wire:submit="save">
                        <div class="form-group mb-3">
                            <label for="left_sidebar">Bal oldali oszlop</label>
                            <select id="left_sidebar" class="form-control" wire:model.live="left_sidebar">
                                @foreach ($sidebarOptions as $value => $label)
                                    @if ($value === '' || $value !== $right_sidebar)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="right_sidebar">Jobb oldali oszlop</label>
                            <select id="right_sidebar" class="form-control" wire:model.live="right_sidebar">
                                @foreach ($sidebarOptions as $value => $label)
                                    @if ($value === '' || $value !== $left_sidebar)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('right_sidebar')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Mentés</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
