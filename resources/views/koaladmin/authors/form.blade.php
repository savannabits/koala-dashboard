<x-card>
<div class="form-group my-2">
    <label for="name" class="font-semibold">Name</label>
    <input name="name" id="name" class="form-input mt-2 block w-full" type="text" x-model="payload.name">
</div>
    <div class="form-group my-2">
    <label for="description" class="font-semibold">Description</label>
    <textarea rows="5" name="description" id="description" class="form-textarea mt-2 block w-full" x-model="payload.description"></textarea>
</div>
    <div class="form-group my-2">
    <label for="activated" class="font-semibold">
        <input name="activated" id="activated" class="form-input p-3" type="checkbox" x-model="payload.activated"> Activated
    </label>
</div>
    
</x-card>

