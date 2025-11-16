<div>
    @if ($useButton ?? "")
        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">{{ $buttonText }}</button>
    @endif

    <div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ $actionForm }}" method="post" id="form-{{ $modalId }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ $slot }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
