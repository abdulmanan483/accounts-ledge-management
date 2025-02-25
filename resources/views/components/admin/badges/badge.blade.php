@props(['type' => 'primary', 'message' => ''])

@php
    $badgeClasses = match($type) {
        'primary' => 'bg-primary text-white',
        'secondary' => 'bg-secondary text-white',
        'success' => 'bg-success text-white',
        'danger' => 'bg-danger text-white',
        default => 'bg-light text-dark',
    };
@endphp

<span class="badge   {{ $badgeClasses }}">
    {{ $message }}
</span>
