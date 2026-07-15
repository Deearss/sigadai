@props(['status', 'class' => ''])

@php
    $colors = [
        'aktif' => 'bg-green-200 text-green-800',
        'ditebus' => 'bg-blue-200 text-blue-800',
        'lelang' => 'bg-red-200 text-red-800',
    ];

    $colorClass = $colors[$status] ?? 'bg-gray-200 text-gray-800';
@endphp

<span
    class="inline-flex items-center justify-center px-2.5 py-1.5 rounded-md text-xs font-medium capitalize {{ $colorClass }} {{ $class }}">
    {{ $status }}
</span>
