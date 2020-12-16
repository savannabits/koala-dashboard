@props(['title' => '','centered' => false, 'id' , 'footer' => '', 'size' => 'xl','class' => ''])
<div class="modal z-20" id="{{$id}}" aria-hidden="true">
    <div
        class="modal__overlay z-30 justify-center {{$centered!==false && $centered!=='false' ? 'items-center': 'items-start py-16'}}"
        tabindex="-1" data-micromodal-close>
        <div class="modal__container z-50 w-full max-w-{{$size}}" role="dialog" aria-modal="true" aria-labelledby="{{$id}}-title"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
        >
            <div {{$attributes->merge(['class' => "modal-content w-full"])}}>
                <header class="modal__header">
                    <h2 class="modal__title font-black" id="{{$id}}-title">
                        {{$title}}
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="{{$id}}-content">
                    {{--JUST TO ENSURE ALL SIZE CLASSES ARE PURGED IN TAILWINDCSS--}}
                    <div class="hidden max-w-xl max-w-2xl max-w-3xl max-w-4xl max-w-5xl max-w-6xl max-w-7xl max-w-full"></div>
                    {{--END PURGE FIX--}}
                    {{$slot}}
                </main>
                <footer class="flex justify-end p-2 sm:rounded-br sm:rounded-bl border-t bottom-0 left-0 right-0">
                    <button type="button" class="btn py-2 bg-gray-100" data-micromodal-close aria-label="Close this dialog window">Close</button>
                    {{$footer}}
                </footer>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <style>
        .modal {
            display: none;
        }
        .modal.is-open {
            display: block;
        }
        .modal__overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            justify-content: center;
        }

        .modal__container {
            background-color: transparent;
            max-height: 100vh;
            overflow-y: auto;
            box-sizing: border-box;
            /*Hide scrollbar*/
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE 10+ */
        }
        .modal-content {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
       }
        .modal__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal__title {
            margin-top: 0;
            margin-bottom: 0;
            font-weight: 600;
            font-size: 1.25rem;
            line-height: 1.25;
            color: #00449e;
            box-sizing: border-box;
        }

        .modal__close {
            background: transparent;
            border: 0;
        }

        .modal__header .modal__close:before { content: "\2715"; }

        .modal__content {
            margin-top: 2rem;
            margin-bottom: 2rem;
            line-height: 1.5;
            color: rgba(0,0,0,.8);
        }

        .modal__btn {
            font-size: .875rem;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: .5rem;
            padding-bottom: .5rem;
            background-color: #e6e6e6;
            color: rgba(0,0,0,.8);
            border-radius: .25rem;
            border-style: none;
            border-width: 0;
            cursor: pointer;
            -webkit-appearance: button;
            text-transform: none;
            overflow: visible;
            line-height: 1.15;
            margin: 0;
            will-change: transform;
            -moz-osx-font-smoothing: grayscale;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            transition: -webkit-transform .25s ease-out;
            transition: transform .25s ease-out;
            transition: transform .25s ease-out,-webkit-transform .25s ease-out;
        }

        .modal__btn:focus, .modal__btn:hover {
            -webkit-transform: scale(1.05);
            transform: scale(1.05);
        }

        .modal__btn-primary {
            background-color: #00449e;
            color: #fff;
        }



        /**************************\
          Demo Animation Style
        \**************************/
        @keyframes mmfadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes mmfadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @keyframes mmslideIn {
            from { transform: translateY(15%); }
            to { transform: translateY(0); }
        }

        @keyframes mmslideOut {
            from { transform: translateY(0); }
            to { transform: translateY(-10%); }
        }

        .micromodal-slide {
            display: none;
        }

        .micromodal-slide.is-open {
            display: block;
        }

        .micromodal-slide[aria-hidden="false"] .modal__overlay {
            animation: mmfadeIn .3s cubic-bezier(0.0, 0.0, 0.2, 1);
        }

        .micromodal-slide[aria-hidden="false"] .modal__container {
            animation: mmslideIn .3s cubic-bezier(0, 0, .2, 1);
        }

        .micromodal-slide[aria-hidden="true"] .modal__overlay {
            animation: mmfadeOut .3s cubic-bezier(0.0, 0.0, 0.2, 1);
        }

        .micromodal-slide[aria-hidden="true"] .modal__container {
            animation: mmslideOut .3s cubic-bezier(0, 0, .2, 1);
        }

        .micromodal-slide .modal__container,
        .micromodal-slide .modal__overlay {
            will-change: transform;
        }
    </style>
@endpush
