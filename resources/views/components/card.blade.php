@props(['title' => null,'headerBackground' =>'bg-gray-200','bodyClasses' =>''])
<div {{$attributes->merge(['class' =>'break-words bg-white dark:text-gray-200 dark:bg-gray-600 sm:border-1 sm:rounded-md'])}}>
    @if($title)
    <header class="font-semibold {{$headerBackground}} text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
        {{$title}}
    </header>
    @endif
    <div class="w-full p-4 {{$bodyClasses}}">
        {{$slot}}
    </div>
</div>
