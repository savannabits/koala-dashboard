@extends('layouts.app')

@section('content')
    @php
    $menu = makeMenu();
    @endphp
<main x-data="alerts()" class="md:container sm:mx-auto sm:mt-10">
    <x-body>
        <x-slot name="sidebar">
            {!! $menu->render() !!}
        </x-slot>
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
    </x-body>
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
