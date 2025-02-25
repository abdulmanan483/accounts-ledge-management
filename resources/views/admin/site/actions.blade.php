<form action="{{ route('sites.destroy', $site->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('sites.show', $site->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('sites.edit', $site->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
