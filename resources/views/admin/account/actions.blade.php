<form action="{{ route('accounts.destroy', $account->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('accounts.show', $account->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('accounts.edit', $account->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
