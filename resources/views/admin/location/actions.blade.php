<form action="{{ route('locations.destroy', $location->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('locations.show', $location->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('locations.edit', $location->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="sa-confirm text-danger"><i class="ph-trash"></i></a>
</form>
