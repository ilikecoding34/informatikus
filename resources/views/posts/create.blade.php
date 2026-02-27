@extends('layouts.app')

@section('content')

<div class="container tech-blog-main">
  <div class="topic-strip d-flex flex-wrap align-items-center justify-content-between">
    <div class="topic-label mb-0">Új bejegyzés</div>
    <a class="btn btn-sm btn-light" href="{{ route('posts.index') }}">Vissza</a>
  </div>

  <div class="main-three-cols main-no-left main-no-right">
    <main class="main-col main-col-center" style="max-width: 100%;">
      <div class="form-card">
        <div class="card-accent"></div>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-3">
            <label for="title" class="form-label">Cím</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
            <div class="form-text">Ez a bejegyzés címe lesz</div>
          </div>
          <div class="form-group mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" class="form-control" name="link" id="link" value="{{ old('link') }}" placeholder="https://…">
            <div class="form-text">Opcionális link</div>
          </div>
          <div class="form-group mb-3">
            <label for="content" class="form-label">Szöveg</label>
            <textarea class="form-control" id="content" name="content" rows="8" placeholder="Bejegyzés tartalma" required>{{ old('content') }}</textarea>
          </div>
          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label for="category" class="form-label">Kategória</label>
              <select name="category" id="category" class="form-control js-select2" required>
                @foreach ($categories as $item)
                  <option value="{{ $item->id }}" {{ old('category') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 form-group mb-3">
              <label for="tags" class="form-label">Tagek</label>
              <select name="tags[]" id="tags" class="form-control js-select2" multiple>
                @foreach ($tags as $item)
                  <option value="{{ $item->id }}" {{ in_array($item->id, old('tags', []) ?: []) ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
              </select>
              <div class="form-text">Több is kiválasztható (Ctrl/Cmd + kattintás)</div>
            </div>
          </div>
          <div class="form-group mb-4">
            <label for="file" class="form-label">Fájl csatolása</label>
            <input type="file" class="form-control-file" id="file" name="file" accept=".csv,.txt,.xlx,.xls,.pdf,.jpeg,.jpg,.png,.gif">
          </div>
          <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
      </div>
    </main>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
  $('.js-select2').select2({
    width: '100%',
    placeholder: function() {
      return $(this).data('placeholder') || 'Válassz…';
    },
    allowClear: true
  });
  $('#tags').data('placeholder', 'Tagek (több is választható)');
  $('#category').data('placeholder', 'Kategória');
});
</script>
@endpush
