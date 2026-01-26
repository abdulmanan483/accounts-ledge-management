<form action="{{ route('cities.destroy', $city->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('cities.show', $city->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('cities.edit', $city->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
