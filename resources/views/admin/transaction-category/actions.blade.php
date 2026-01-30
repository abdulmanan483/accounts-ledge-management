<form action="{{ route('transaction-categories.destroy', $transaction_category->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('transaction-categories.show', $transaction_category->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('transaction-categories.edit', $transaction_category->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
