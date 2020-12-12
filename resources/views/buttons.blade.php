@php
    $menu = makeMenu();
@endphp
@extends('layouts.app')
@section('content')
<main x-data="buttons()" class="md:container sm:mx-auto sm:mt-10">
    <x-body>
        <x-slot name="sidebar">
            {!! $menu->render() !!}
        </x-slot>
        <x-card headerBackground="" class="shadow-lg" x-cloak>
            <h4 class="font-semibold text-lg">Rounded Buttons (.rounded)</h4>
            <div class="grid md:grid-cols-4">
                <button class="btn bg-primary rounded m-2">Primary Rounded</button>
                <button class="btn bg-success rounded m-2">Success Button</button>
                <button class="btn bg-danger rounded m-2">Danger Button</button>
                <button class="btn bg-warning rounded m-2">Warning Button</button>
                <button class="btn bg-accent rounded m-2">Accent Button</button>
                <button class="btn bg-secondary rounded m-2">Secondary Button</button>
                <button class="btn bg-purple-300 rounded m-2">Any other Color</button>
                <button class="btn rounded m-2">Default Color</button>
            </div>
        </x-card>
        <x-card headerBackground="" class="shadow-lg mt-4" x-cloak>
            <h4 class="font-semibold text-lg">Square Buttons (rounded-none)</h4>
            <div class="grid md:grid-cols-4">
                <button class="btn bg-primary text-white m-2 rounded-none">Primary</button>
                <button class="btn bg-success m-2 rounded-none">Success</button>
                <button class="btn bg-danger m-2 rounded-none">Danger</button>
                <button class="btn bg-warning m-2 rounded-none">Warning</button>
                <button class="btn bg-accent m-2 rounded-none">Accent</button>
                <button class="btn bg-secondary m-2 rounded-none">Secondary</button>
                <button class="btn bg-purple-300 m-2 rounded-none">Any other Color</button>
                <button class="btn m-2 rounded-none">Default Color</button>
            </div>
        </x-card>
        <x-card headerBackground="" class="shadow-lg mt-4" x-cloak>
            <h4 class="font-semibold text-lg">Pill Buttons (.rounded-full)</h4>
            <div class="grid md:grid-cols-4 mb-4">
                <button class="btn bg-primary text-white m-2 rounded-full">Primary</button>
                <button class="btn bg-success m-2 rounded-full">Success</button>
                <button class="btn bg-danger m-2 rounded-full">Danger</button>
                <button class="btn bg-warning m-2 rounded-full">Warning</button>
                <button class="btn bg-accent m-2 rounded-full">Accent</button>
                <button class="btn bg-secondary  rounded-full m-2">Secondary</button>
                <button class="btn bg-purple-300 m-2 rounded-full">Any other Color</button>
                <button class="btn m-2  rounded-full">Default Color</button>
            </div>
        </x-card>
        <x-card headerBackground="" class="shadow-lg mt-4" x-cloak>
            <h4 class="font-semibold text-lg">Button Sizes using padding (.p-n)</h4>
            <div class="mb-4">
                <button class="btn bg-primary p-2">Primary .p-2</button>
                <button class="py-4 btn bg-success p-3">Success .p-3</button>
                <button class="btn bg-danger m-2 rounded p-4">Danger .p-4</button>
                <button class="btn bg-warning m-2 rounded p-6">Warning .p-6</button>
                <button class="btn bg-accent m-2 rounded p-8">Accent .p-8</button>
                <button class="btn bg-secondary  rounded-full m-2 p-10">Secondary .p-10</button>
                <button class="btn bg-purple-300 m-2 rounded p-12">Any Color .p-12</button>
                <button class="btn m-2 bg-pink-600 rounded p-14">Default Color .p-14</button>
            </div>
        </x-card>
        <x-card headerBackground="" class="shadow-lg mt-4" x-cloak>
            <h4 class="font-semibold text-lg">Icon Buttons</h4>
            <div class="">
                <button class="btn bg-primary p-3"><i class="fas fa-cross"></i></button>
                <button class="btn bg-success rounded-full p-3"><i class="fas fa-envelope"></i></button>
                <button class="btn bg-danger rounded-full p-3">Send Message <i class="fa fa-send ml-2"></i></button>
                <button class="btn bg-danger rounded p-3">
                    <i class="fa fa-home"></i>
                    HOME
                </button>
                <button class="btn bg-accent rounded p-3">
                    <i class="fa fa-home"></i>
                    <p>HOME</p>
                </button>
            </div>
        </x-card>
    </x-body>
</main>
@endsection
@push('scripts')
    <script>
        function buttons() {
            return {
            }
        }
    </script>
@endpush
