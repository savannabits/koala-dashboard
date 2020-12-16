{{"@"}}extends('layouts.koaladmin')
{{"@"}}section('content')
    <div x-data="{{$modelVariableNamePlural}}()"
         x-on:show-{{$modelJSNameSingular}}.window="show{{$modelBaseName}}(event.detail)"
         x-on:edit-{{$modelJSNameSingular}}.window="edit{{$modelBaseName}}(event.detail)"
         x-on:delete-{{$modelJSNameSingular}}.window="confirmDelete{{$modelBaseName}}(event.detail)"
         class="sm:container px-2 mx-auto"
    >
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">List of {{$modelTitlePlural}}</h2>
            {{'@'}}can('{{$modelRouteAndViewName}}.create')
            <button type="button" x-on:click="create{{$modelBaseName}}" class="btn p-2 text-current bg-primary text-gray-50 rounded">
                <i class="fas fa-plus mr-2"></i>Create New {{$modelTitle}}
            </button>
            {{'@'}}endcan
        </div>
        {{'@'}}can('{{$modelRouteAndViewName}}.index')
            <{{'x-card'}}>
                <{{'x-koala'}}.datatable
                    tableId="{{$modelRouteAndViewName}}-dt"
                    :ajaxUrl="route('api.{{$modelRouteAndViewName}}.dt')"
                    :columns="$columns"
                >
                </{{'x-koala'}}.datatable>
            </{{'x-card'}}>
        {{'@'}}endcan

        {{'@'}}can('{{$modelRouteAndViewName}}.show')
        <{{'x-koala'}}.modal size="2xl" class="text-primary bg-secondary" id="show-{{$modelJSNameSingular}}-modal">
            <{{'x-slot'}} name="title">
                <span x-text="`Details for {{$modelTitle}} #${payload?.id}`"></span>
            </{{'x-slot'}}>
            {{'@'}}include('koaladmin.{{$modelRouteAndViewName}}.show')
        </{{'x-koala'}}.modal>
        {{'@'}}endcan

        {{'@'}}can('{{$modelRouteAndViewName}}.create')
        <form id="{{$modelJSNameSingular}}-create-form" novalidate x-on:submit.prevent="store{{$modelBaseName}}">
            <{{'x-koala'}}.modal size="2xl" class="text-primary" id="create-{{$modelJSNameSingular}}-modal">
                <{{'x-slot'}} name="title">
                    <h2 x-text="`Create New {{$modelTitle}}`"></h2>
                </{{'x-slot'}}>
                {{'@'}}include('koaladmin.{{$modelRouteAndViewName}}.create')
                <{{'x-slot'}} name="footer">
                    <button type="submit" class="btn py-2 ml-2 bg-success">Submit</button>
                </{{'x-slot'}}>
            </{{'x-koala'}}.modal>
        </form>
        {{'@'}}endcan

        {{'@'}}can('{{$modelRouteAndViewName}}.edit')
        <form id="{{$modelJSNameSingular}}-edit-form" x-on:submit.prevent="update{{$modelBaseName}}">
            <{{'x-koala'}}.modal size="2xl" class="text-primary" id="edit-{{$modelJSNameSingular}}-modal">
                <{{'x-slot'}} name="title">
                    <span x-text="`Edit {{$modelTitle}} #${payload?.id}`"></span>
                </{{'x-slot'}}>
                {{'@'}}include('koaladmin.{{$modelRouteAndViewName}}.edit')
                <{{'x-slot'}} name="footer">
                    <button type="submit" class="btn py-2 ml-2 bg-success">Submit</button>
                </{{'x-slot'}}>
            </{{'x-koala'}}.modal>
        </form>
        {{'@'}}endcan

        {{'@'}}can('{{$modelRouteAndViewName}}.delete')
        <form x-on:submit.prevent="delete{{$modelBaseName}}">
            <{{'x-koala'}}.modal size="xl" centered class="text-danger bg-danger-lighter" id="delete-{{$modelJSNameSingular}}-modal">
                <{{'x-slot'}} name="title">
                    <span class="text-danger" x-text="`Delete {{$modelTitle}} #${payload?.id}?`"></span>
                </{{'x-slot'}}>
                <p class="text-danger font-semibold">
                    Are you sure you want to delete this {{$modelTitle}}?
                </p>
                <{{'x-slot'}} name="footer">
                    <button type="submit" class="btn py-2 ml-2 bg-danger">Yes, Delete</button>
                </{{'x-slot'}}>
            </{{'x-koala'}}.modal>
        </form>
        {{'@'}}endcan
    </div>
{{"@"}}endsection

{{"@"}}push('styles')
{{"@"}}endpush

{{"@"}}push('scripts')
<{{'script'}}>
    function {{$modelVariableNamePlural}}() {
        return {
            payload: {},
            form: {},
            created() {
                return this.mounted()
            },
            mounted() {
                /* Component is mounted and DOM is ready */
            },
            async create{{$modelBaseName}}() {
                this.payload = {};
                MicroModal.show('create-author-modal');
            },
            async show{{$modelBaseName}}(id) {
                this.payload = {};
                let res = await apiFetch(`{{'{{'}}route('api.authors.index')}}/${id}`);
                this.payload = res.payload;
                MicroModal.show('show-{{$modelJSNameSingular}}-modal');
            },
            async edit{{$modelBaseName}}(id) {
                this.payload = {};
                let res = await apiFetch(`{{'{{'}}route('api.authors.index')}}/${id}`);
                this.payload = res.payload;
                MicroModal.show('edit-{{$modelJSNameSingular}}-modal');
            },
            confirmDelete{{$modelBaseName}}(id) {
                this.payload.id = id;
                MicroModal.show('delete-{{$modelJSNameSingular}}-modal');
            },
            async delete{{$modelBaseName}}() {
                console.log('Submitting delete request')
                let res = await apiSend(`{{'{{'}}route('api.authors.index')}}/${this.payload.id}`,{},'delete');
                if (res?.success) {
                    alert(res?.message);
                    MicroModal.close('delete-{{$modelJSNameSingular}}-modal');
                    this.payload = {};
                    dispatchAlpineEvent('refresh-dt','{{$modelRouteAndViewName}}-dt')
                }
            },
            async update{{$modelBaseName}}() {
                console.log("TODO: Implement this");
            }
        }
    }
</{{'script'}}>
{{"@"}}endpush
