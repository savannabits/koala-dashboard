@props([
    'picSrc' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    'title' => null,
    ])
<div x-data="{open: false}" @keydown.escape="open=false">
    <div>
        <button @click="open=!open" @click.away="open=false" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu" aria-haspopup="true">
            <span class="sr-only">Open user menu</span>
            <img class="h-8 w-8 rounded-full" src="{{$picSrc}}" alt="">
        </button>
    </div>
    <!--
      Profile dropdown panel, show/hide based on dropdown state.

      Entering: "transition ease-out duration-100"
        From: "transform opacity-0 scale-95"
        To: "transform opacity-100 scale-100"
      Leaving: "transition ease-in duration-75"
        From: "transform opacity-100 scale-100"
        To: "transform opacity-0 scale-95"
    -->
    <div x-show="open" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
        @if($title)
        <h2 class="bg-gray-50 p-3 text-primary font-semibold">{{$title}}</h2>
        @endif
        {{$slot}}
    </div>
</div>
