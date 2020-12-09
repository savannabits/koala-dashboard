@props([
    'active' => url()->current(),
    'href' => '',
])
@php
$isActive = $href && url($href) === url($active);
@endphp
@if ($isActive)
    <a href="{{$href}}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">{{$slot}}</a>
@else
    <a href="{{$href}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{$slot}}</a>
@endif
