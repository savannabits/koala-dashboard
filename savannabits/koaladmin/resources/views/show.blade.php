<{{'x-card'}} class="border bg-gray-100">
@foreach($columns as $column)
    <{{'x-card'}} class="my-2">
        <div class="w-full p-3">
            <h4 class="font-black text-primary my-1">{{$column['label']}}</h4>
            <p class="my-1" x-html="payload.{{$column['name']}}"></p>
        </div>
    </{{'x-card'}}>
@endforeach
@if (isset($relations['belongsTo']) && count($relations["belongsTo"]))
@foreach($relations["belongsTo"] as $parent)
    <template x-if="payload.{{$parent['relationship_variable']}}">
        <{{'x-card'}} class="my-2">
            <div class="w-full p-3">
                <h4 class="font-black text-primary my-1">{{$parent['related_model_title']}}</h4>
                <p class="my-1" x-html="payload.'.{{$parent['relationship_variable']}}.'.'.{{$parent["label_column"]}}.'"></p>
            </div>
        </{{'x-card'}}>
    </template>
@endforeach
@endif
</{{'x-card'}}>
