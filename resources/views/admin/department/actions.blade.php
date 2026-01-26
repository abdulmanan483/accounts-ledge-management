<form action="{{ route('departments.destroy', $department->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('departments.show', $department->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('departments.edit', $department->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
