@extends('layouts.app')

@section('content')
    @php
    $menu = makeMenu();
    @endphp
<main x-data="alerts()" class="md:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-3">

        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="flex flex-col lg:flex-row w-full">
            <x-card x-cloak title="Modules" class="w-full lg:bg-transparent mb-4 lg:w-1/5 shadow md:shadow-none rounded-none" bodyClasses="px-0">
                {!! $menu->render() !!}
            </x-card>
            <section class="w-full lg:ml-2">
                <x-card headerBackground="bg-primary-lighter" title="Tailwind Custom Alerts" x-cloak>
                    <div class="grid md:grid-cols-3">
                        <div class="m-2">
                            <x-alert.primary class="m-2" message="Hello There!" title="Primary"/>
                        </div>
                        <div  class="m-2">
                            <x-alert.success class="m-2" title="Success">This is a message</x-alert.success>
                        </div>
                        <div class="m-2">
                            <x-alert.danger class="m-2" title="Danger">This is a message</x-alert.danger>
                        </div>
                        <div class="m-2">
                            <x-alert.accent class="m-2" title="Nice Accent!">This is a message</x-alert.accent>
                        </div>
                        <div class="m-2">
                            <x-alert.warning class="m-2" title="I Warn you">This is a message</x-alert.warning>
                        </div>
                    </div>
                </x-card>
            </section>
        </div>
    </div>
</main>
@endsection
@push('scripts')
    <script>
        function alerts() {
            return {
            }
        }
    </script>
@endpush
