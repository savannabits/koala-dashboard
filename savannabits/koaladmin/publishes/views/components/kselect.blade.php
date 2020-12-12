@props(['id' => null, 'options'  => [],'key' => 'id', 'label' => 'name','uid' => '','fromApi' => false,'sourceUrl' =>null])
<div
    x-cloak
    class="bg-transparent rounded"
    x-data="choicesData()"
    x-init="
        () => {
            const choices = new Choices($refs['{{$uid}}'],{
                    shouldSort: false,
                    searchResultLimit: 40,
                    itemSelectText: '',
                    classNames: {
                        containerOuter: 'choices bg-transparent
                        containerInner: 'form-input  py-1 bg-white',
                        item: 'choices__item w-full'
                    }
                });
                choices.passedElement.element.addEventListener(
                    'change',
                    function(event) {
                        values = event.detail.value;
                    @this.set('{{ $attributes->wire('model')->value() }}', values);
                    },
                    false,
                );
        }
    "
>
    <select @change="$dispatch('input', $event.target.selected)" :x-ref="inputRef" x-cloak id="{{ $id }}">
        <option value="">{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : '-- Select --' }}</option>
        @if(count($options))
        @foreach($options as $option)
        <option value="{{ $option[$key] }}">{{$option[$label]}}</option>
        @endforeach
        @else
        {{ $slot }}
        @endif
    </select>
</div>
@push('scripts')
<script>
    function choicesData() {
        return {
            'fromApi': {{$fromApi}},
            "sourceUrl": {{$sourceUrl}},
            "uid": {{$uid}},
            "id": {{$id}},
            "key": {{$key}},
            "label": {{$name}}
        }
    }
    document.addEventListener('livewire:load', function(e) {
        let el = document.getElementById('{{$id}}');
        if (el) {
            el.value = @this.get("{{$attributes->wire('model')->value()}}");
            const choices = new Choices(el,{
                shouldSort: false,
                itemSelectText: '',
                searchResultLimit: 40,
                classNames: {
                    containerOuter: 'choices bg-transparent',
                    containerInner: 'form-input  py-1 bg-white',
                    item: 'choices__item w-full'
                }
            });
            choices.passedElement.element.addEventListener(
                'change',
                function(event) {
                    values = event.detail.value;
                @this.set('{{ $attributes->wire('model')->value() }}', values);
                },
                false,
            );
        }
    });
</script>
@endpush
