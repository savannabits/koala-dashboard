<{{'x-card'}}>
@foreach($columns as $col)
@if($col['type'] === 'date' )
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input datepicker mt-2 block w-full" type="date" x-model="payload.{{$col['name']}}">
</div>
    @elseif($col['type'] === 'time')
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input mt-2 block w-full" type="time" x-model="payload.{{$col['name']}}">
</div>
    @elseif($col['type'] === 'datetime')
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input datetimepicker mt-2 block w-full" type="date" x-model="payload.{{$col['name']}}">
</div>
    @elseif($col['type'] === 'boolean')
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">
        <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input p-3" type="checkbox" x-model="payload.{{$col['name']}}"> {{$col['label']}}
    </label>
</div>
    @elseif($col['type'] ==='string')
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input mt-2 block w-full" type="text" x-model="payload.{{$col['name']}}">
</div>
    @elseif(in_array($col['type'],['float','integer','double']))
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input mt-2 block w-full" type="number" x-model="payload.{{$col['name']}}">
</div>
    @elseif($col['type'] === 'text')
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <textarea rows="5" name="{{$col['name']}}" id="{{$col['name']}}" class="form-textarea mt-2 block w-full" x-model="payload.{{$col['name']}}"></textarea>
</div>
    @elseif($col['name'] === 'password')
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input datetimepicker mt-2 block w-full" type="password" x-model="payload.{{$col['name']}}">
</div>

<div class="form-group my-2">
    <label for="{{$col['name']}}_confirmation" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}_confirmation" id="{{$col['name']}}_confirmation" class="form-input mt-2 block w-full" type="password" x-model="payload.{{$col['name']}}_confirmation">
</div>
    @else
<div class="form-group my-2">
    <label for="{{$col['name']}}" class="font-semibold">{{$col['label']}}</label>
    <input name="{{$col['name']}}" id="{{$col['name']}}" class="form-input mt-2 block w-full" type="text" x-model="payload.{{$col['name']}}">
</div>
@endif
@endforeach
{{--@if (count($relations))
@if(isset($relations['belongsTo']) && count($relations['belongsTo']))
@foreach($relations['belongsTo'] as $belongsTo)
<b-form-group label-class="font-weight-bolder" label="{{$belongsTo['related_model_title']}}">
    <infinite-select
        label="{{$belongsTo["label_column"]}}" v-model="form.{{$belongsTo['relationship_variable']}}" name="{{$belongsTo['relationship_variable']}}"
         @php
             echo 'api-url="{{route(\'api.'.$belongsTo['related_route_name'].'.index\')}}"'.PHP_EOL;
         @endphp
         :per-page="10"
        v-validate="'{{ implode('|', collect($relatable[$belongsTo['foreign_key']]['frontendRules'])->reject(function($rule){ return str_contains($rule,'integer');})->toArray()) }}'"
        :class="{'is-invalid': validateState('{{$belongsTo['relationship_variable']}}')===false, 'is-valid': validateState('{{$belongsTo['relationship_variable']}}')===true}"
    >
    </infinite-select>
    <b-form-invalid-feedback v-if="errors.has('{{$belongsTo['relationship_variable']}}')">
        @php
            echo '@{{errors.first(\''.$belongsTo['relationship_variable'].'\')}}';
        @endphp
    </b-form-invalid-feedback>
</b-form-group>
@endforeach
@endif
@endif--}}
</{{'x-card'}}>

