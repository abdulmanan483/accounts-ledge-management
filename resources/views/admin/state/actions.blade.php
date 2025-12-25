<form action="{{ route('states.destroy', $state->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('states.show', $state->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('states.edit', $state->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
