<form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('permissions.show', $permission->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('permissions.edit', $permission->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
