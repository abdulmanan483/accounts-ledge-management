<form action="{{ route('departments.destroy', $department->id) }}" method="POST">
    @csrf
    <a class="btn btn-sm btn-primary" href="{{ route('departments.show', $department->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
    <a class="btn btn-sm btn-success" href="{{ route('departments.edit', $department->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm sa-confirm"><i class="fa fa-fw fa-trash"></i> Delete</button>
</form>
