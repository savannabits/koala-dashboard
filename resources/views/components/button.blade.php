<div x-cloak>
    <button role="button" {{ $attributes->merge(['class' => 'p-2 my-2 bg-gray-100 hover:bg-gray-800 hover:text-gray-200 rounded shadow'])}}>
        {{$slot}}
    </button>
</div>
