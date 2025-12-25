<form action="{{ route('settings.destroy', $setting->id) }}" method="POST">
    @csrf
    <a class="" href="{{ route('settings.show', $setting->id) }}"><i class="text-dark ph-eye"></i></a>
    <a class="" href="{{ route('settings.edit', $setting->id) }}"><i class="ph-pencil"></i></a>
    @method('DELETE')
    <a type="submit" class="text-danger sa-confirm"><i class="ph-trash"></i></a>
</form>
