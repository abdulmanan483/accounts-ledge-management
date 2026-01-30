<form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('transactions.show', $transaction->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('transactions.edit', $transaction->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
