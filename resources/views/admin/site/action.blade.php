<form action="{{ route('sites.destroy', $site->id) }}" method="POST">
    @csrf
    <a class="btn btn-sm btn-primary" href="{{ route('sites.show', $site->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
    <a class="btn btn-sm btn-success" href="{{ route('sites.edit', $site->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm sa-confirm"><i class="fa fa-fw fa-trash"></i> Delete</button>
</form>
