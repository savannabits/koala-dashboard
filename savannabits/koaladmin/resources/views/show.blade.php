@php
echo "@props(['payload' => []])".PHP_EOL
@endphp
<div x-data="show{{$modelBaseName}}Form()">
@foreach($columns as $column)
    <template x-if="payload.{{$column['name']}}" >
        <x-card>
            <h4 class="font-black text-primary my-1">{{$column['label']}}</h4>
            <p class="font-semibold my-1" x-html="payload.{{$column['name']}}"></p>
        </x-card>
    </template>
@endforeach
@if (isset($relations['belongsTo']) && count($relations["belongsTo"]))
    @foreach($relations["belongsTo"] as $parent)
        <template x-if="payload.{{$parent['relationship_variable']}}">
            <x-card>
                <h4 class="font-black my-1">{{$parent['related_model_title']}}</h4>
                <p class="font-semibold my-1" x-html="payload.'.{{$parent['relationship_variable']}}.'.'.{{$parent["label_column"]}}.'"></p>
            </x-card>
        </template>
    @endforeach
@endif
</div>
{{'@'}}push('scripts')
    {!! '<script>' !!}
        function show{{$modelBaseName}}Form() {
            return {
                payload: JSON.parse({{'{'}}!! json_encode($payload) !!{{'}'}}),
            }
        }
    {!! '</script>' !!}
{{'@'}}endpush
