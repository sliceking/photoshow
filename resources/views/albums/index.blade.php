@extends('layouts.app')

@section('content')
<div class="container">
  @if (count($albums) > 0)
    <div class="row">
      @foreach($albums as $album)
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <img src="/storage/album_covers/{{ $album->cover_image }}" alt="" height="200px">
            <div class="card-body">
              <p class="card-text">{{ $album->description }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                </div>
                <small class="text-muted">{{ $album->name }}</small>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <h3>No Albums yet</h3>
  @endif
</div>

@endsection
