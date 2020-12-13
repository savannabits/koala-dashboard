@props([
    'tableId' =>'',
    'processing' => false,
    'serverSide' => true,
    'columns' => [],
    'columnDefs' => [],
    'ajaxUrl' => '',
    'ajaxParams' => [],
    ])
<div
    x-data="koalaDatatable()"
    x-init="created()"
    x-on:refresh-dt.window="refreshDT"
>
    @if(isset($tableheader))
    <div class="ml-auto text-right my-4 py-2">
        {{$tableheader}}
    </div>
    @endif
    <table id="{{$tableId}}" x-cloak {{$attributes->merge(['class' => 'table text-left table-auto stripe hover'])}} style="width: 100%"></table>
</div>
@push('scripts')
<script>
    function koalaDatatable() {
        return {
            table: null,
            tableId: "{{$tableId}}",
            ajaxUrl: "{{$ajaxUrl}}",
            processing: !!'{{$processing}}',
            serverSide: !!'{{$serverSide}}',
            columnnDefs: JSON.parse('{!! json_encode($columnDefs) !!}'),
            columns: JSON.parse('{!! json_encode($columns) !!}'),
            ajaxParams: JSON.parse('{!! json_encode($ajaxParams) !!}'),
            created() {
                console.log('component is created')
                return () => this.mounted();
            },
            mounted() {
                console.log('component is mounted');
                this.initDt();
            },
            initDt() {
                let vm = this;
                let columns = [
                    ...vm.columns,
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'text-right no-export',
                        orderable: false,
                        searchable: false
                    }
                ];
                $(document).ready(function() {
                    vm.table = $(`#${vm.tableId}`).DataTable({
                        processing: true,
                        serverSide: true,
                        stateSave: true,
                        ajax: {
                            url: vm.ajaxUrl,
                            data: function(d) {
                                for (const [key, value] of Object.entries(vm.ajaxParams)) {
                                    d[key] = value;
                                }
                            },
                            /*beforeSend: function(request) {
                                if (vm.tenant && vm.tenantHeaderName) {
                                    request.setRequestHeader(`${vm.tenantHeaderName}`,`${vm.tenant}`);
                                }
                            }*/
                        },
                        columns: columns,
                        columnDefs: vm.columnDefs,
                        responsive: true,
                        autoWidth: false,
                        fullWidth: true,
                        dom: 'Blfrtip',
                        buttons: [
                            'copy',
                            {
                                'extend':'excel',
                                className: 'btn bg-green-400',
                                exportOptions: {
                                    columns: ':visible :not(.no-export)'
                                }
                            },
                            {'extend':'pdf','className':'btn bg-red-400'}
                        ]
                    }).columns.adjust().responsive.recalc();
                    vm.table.on('click', '.action-button', function (e) {
                        console.log('action button clicked');
                        var ev = $(this)
                        if (ev.data('tag') ==='button') {
                            vm.dispatchCustomEvent(ev.data('action'),ev.data('id'))
                        }
                    });
                })
            },
            refreshDT(e) {
                console.log('refreshing table')
                console.log(e.detail);
                let tid = e.detail;
                if (tid === this.tableId) {
                    //Refresh Table here
                    if (this.table) {
                        this.table.ajax.reload(null,false);
                    }
                }
            },
            dispatchCustomEvent(name, data) {
                this.$el.dispatchEvent(new CustomEvent(name,{bubbles: true,detail: data}));
            }
        }
    }
</script>
@endpush
