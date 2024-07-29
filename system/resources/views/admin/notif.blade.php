@foreach(['success', 'warning', 'danger'] as $status)
    @if (session($status))
        <div class="alert alert-{{$status}} alert-dismissible" role="alert">
            {{session($status)}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach