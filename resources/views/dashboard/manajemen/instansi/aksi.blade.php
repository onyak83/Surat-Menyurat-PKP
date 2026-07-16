<div class="btn-group" role="group">
    <a href="{{ route('edit.Instansi', $row->id) }}" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
        title="Edit Data"><i class="fas fa-edit"></i>
    </a>

    <!-- Tombol Hapus -->
    <button type="button" class="btn btn-danger btn-icon btn-round btn-delete" data-id="{{ $row->id }}"
        data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i>
    </button>

</div>

<form id="form-delete-{{ $row->id }}" action="{{ route('delete.Instansi', $row->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>
