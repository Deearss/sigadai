@props(['status'])

@php
    $colors = [
        'aktif' => 'bg-green-100 text-green-800',
        'ditebus' => 'bg-blue-100 text-blue-800',
        'lelang' => 'bg-red-100 text-red-800',
    ];
    
    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $colorClass }}">
    {{ $status }}
</span>
