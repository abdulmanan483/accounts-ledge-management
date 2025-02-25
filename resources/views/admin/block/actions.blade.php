<form action="{{ route('blocks.destroy', $block->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('blocks.show', $block->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('blocks.edit', $block->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
