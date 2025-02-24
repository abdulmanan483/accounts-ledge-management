<form action="{{ route('floors.destroy', $floor->id) }}" method="POST">
    @csrf
    <a class="btn btn-sm btn-primary" href="{{ route('floors.show', $floor->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
    <a class="btn btn-sm btn-success" href="{{ route('floors.edit', $floor->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm sa-confirm"><i class="fa fa-fw fa-trash"></i> Delete</button>
</form>
