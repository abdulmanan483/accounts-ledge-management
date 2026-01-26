<form action="{{ route('countries.destroy', $country->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('countries.show', $country->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('countries.edit', $country->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
