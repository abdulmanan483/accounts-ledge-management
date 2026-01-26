@canany(['users-view', 'users-edit', 'users-delete'])
    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        <a class="" href="{{ route('users.show', $user->id) }}"><i class="text-dark ph-eye"></i></a>
        <a class="" href="{{ route('users.edit', $user->id) }}"><i class="ph-pencil"></i></a>
        @method('DELETE')
        <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
    </form>
@endcanany
