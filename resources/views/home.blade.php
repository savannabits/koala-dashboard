@extends('layouts.app')

@section('content')
    @php
    $menu = makeMenu();
    @endphp
<main x-data="home()" class="md:container sm:mx-auto sm:mt-10">
    <x-body>
        <x-slot name="sidebar">
            {!! $menu->render() !!}
        </x-slot>
        <x-card title="Dashboard" class="h-full" headerBackground="bg-primary-lighter">
            <h4 class="font-black text-lg">Welcome to the World</h4>
            <p class="h-full">I start here and go, yet you can't catch</p>
        </x-card>
    </x-body>
</main>
@endsection
@push('scripts')
    <script>
        function home() {
            return {
                message: "Hello There Button!",
                showMsg: false,
                showMessage() {
                    this.message = "We are now greeting you. How are you?";
                    this.showMsg = true;
                }
            }
        }
    </script>
@endpush
