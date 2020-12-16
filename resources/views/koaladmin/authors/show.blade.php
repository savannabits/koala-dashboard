<x-card class="border bg-gray-100">
    <x-card class="my-2">
        <div class="w-full p-3">
            <h4 class="font-black text-primary my-1">Name</h4>
            <p class="my-1" x-html="payload.name"></p>
        </div>
    </x-card>
    <x-card class="my-2">
        <div class="w-full p-3">
            <h4 class="font-black text-primary my-1">Description</h4>
            <p class="my-1" x-html="payload.description"></p>
        </div>
    </x-card>
    <x-card class="my-2">
        <div class="w-full p-3">
            <h4 class="font-black text-primary my-1">Activated</h4>
            <p class="my-1" x-html="payload.activated"></p>
        </div>
    </x-card>
</x-card>
