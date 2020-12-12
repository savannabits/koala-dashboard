<div class="w-full">
    <div class="w-full lg:table">
        @if($sidebar)
        <div class="lg:sticky top-16 lg:pr-2 lg:max-w-xs w-full">
            <div class="lg:table-cell w-full">
                {{--SIDE CONTENT START--}}
                <x-card x-cloak title="Menu" headerBackground="bg-gray-300" class="w-full lg:w-64 mb-4 lg:bg-transparent shadow md:shadow-none rounded-none" bodyClasses="px-0">
                    {{$sidebar}}
                </x-card>
                {{--SIDE CONTENT END--}}
            </div>
        </div>
        @endif
        <div class="lg:table-cell block w-full">
            <div class="w-full mb-10">
                {{--MAIN CONTENT START--}}
                {{$slot}}
                {{--MAIN CONTENT END--}}
            </div>
        </div>
    </div>
</div>
