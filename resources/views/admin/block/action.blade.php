<form action="{{ route('blocks.destroy', $block->id) }}" method="POST">
    @csrf
    <a class="btn btn-sm btn-primary" href="{{ route('blocks.show', $block->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
    <a class="btn btn-sm btn-success" href="{{ route('blocks.edit', $block->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm sa-confirm"><i class="fa fa-fw fa-trash"></i> Delete</button>
</form>
