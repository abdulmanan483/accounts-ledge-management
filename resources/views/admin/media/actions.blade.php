<form action="{{ route('media.destroy', $media->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('media.show', $media->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('media.edit', $media->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
