@extends('layouts.app')

@section('content')
    @php
    $menu = makeMenu();
    @endphp
<main x-data="home()" class="md:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-3">

        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="flex flex-col lg:flex-row w-full">
            <x-card title="Modules" class="w-full lg:bg-transparent mb-4 lg:w-1/5 shadow md:shadow-none rounded-none" bodyClasses="px-0">
                {!! $menu->render() !!}
            </x-card>
            <section class="w-full lg:ml-2">
                <x-card title="Dashboard" class="h-full" headerBackground="bg-primary-lighter">
                    This is your dashboard
                </x-card>
            </section>
        </div>
    </div>
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
