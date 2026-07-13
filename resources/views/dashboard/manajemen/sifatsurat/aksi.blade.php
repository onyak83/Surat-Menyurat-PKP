<a href="{{ route('edit.SifatSurat', $row->id) }}" class="btn btn-warning btn-icon btn-round" title="Edit">
    <i class="fas fa-edit"></i>
</a>

<button class="btn btn-danger btn-icon btn-round btn-delete" data-id="{{ $row->id }}" title="Hapus">
    <i class="fas fa-trash"></i>
</button>

<form id="form-delete-{{ $row->id }}" action="{{ route('delete.SifatSurat', $row->id) }}" method="POST"
    style="display:none">
    @csrf
    @method('DELETE')
</form>
