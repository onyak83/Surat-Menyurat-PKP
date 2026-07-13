<a href="{{ route('edit.User', $user->id) }}" class="btn btn-warning btn-icon btn-round" title="Edit">
    <i class="fas fa-edit"></i>
</a>

<button class="btn btn-danger btn-icon btn-round btn-delete" data-id="{{ $user->id }}" title="Hapus">
    <i class="fas fa-trash"></i>
</button>

<form id="form-delete-{{ $user->id }}" action="{{ route('delete.User', $user->id) }}" method="POST"
    style="display:none">
    @csrf
    @method('DELETE')
</form>
