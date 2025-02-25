<form action="{{ route('floors.destroy', $floor->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('floors.show', $floor->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('floors.edit', $floor->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
