<form action="{{ route('persons.destroy', $person->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('persons.show', $person->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('persons.edit', $person->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
