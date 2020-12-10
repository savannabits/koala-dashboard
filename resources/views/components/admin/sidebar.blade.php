@props(['footer' => null])
@php
    $sidebar = adminSidebarMenu();
@endphp
<!-- Desktop sidebar -->
<aside
    class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block"
>
    <div class="pb-4 text-gray-500 dark:text-gray-200">
        <div class="py-0 my-0 bg-primary dark:bg-gray-900">
            <a
                class="mx-auto flex items-center h-16 ml-2 text-lg font-bold text-gray-200 dark:text-gray-200"
                href="{{route('home')}}"
            >
                <div><img src="{{asset('images/brand/banner-white.png')}}"></div>
            </a>
        </div>
        {!! $sidebar->render() !!}
        @if($footer)
            <hr class="my-4">
            {{$footer}}
        @endif
    </div>
</aside>
<!-- Mobile sidebar -->
<!-- Backdrop -->
<div
    x-show="isSideMenuOpen"
    x-cloak
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
></div>
<aside
    x-cloak
    class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20"
    @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu"
>
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a
            class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
            href="#"
        >
            {{config('app.name')}}
        </a>
        <ul class="mt-6"></ul>
        {!! $sidebar->render() !!}
        @if($footer)
            <hr class="my-4">
            {{$footer}}
        @endif
    </div>
</aside>
