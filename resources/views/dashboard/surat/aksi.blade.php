<a href="{{ route('edit.Surat', $surat->id) }}" class="btn btn-warning btn-icon btn-round" title="Edit">
    <i class="fas fa-edit"></i>
</a>

<button class="btn btn-danger btn-icon btn-round btn-delete" data-id="{{ $surat->id }}" title="Hapus">
    <i class="fas fa-trash"></i>
</button>

<form id="form-delete-{{ $surat->id }}" action="{{ route('delete.Surat', $surat->id) }}" method="POST"
    style="display:none">
    @csrf
    @method('DELETE')
</form>
