@extends('layouts.koaladmin')
@section('content')
    <div x-data="authors()"
         x-on:show-author.window="showAuthor(event.detail)"
         x-on:edit-author.window="editAuthor(event.detail)"
         x-on:delete-author.window="confirmDeleteAuthor(event.detail)"
         class="sm:container px-2 mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">List of Authors</h2>
            <button type="button" x-on:click="createAuthor" class="btn p-2 text-current bg-primary text-gray-50 rounded"><i class="fas fa-plus mr-2"></i>Crate New Author</button>
        </div>

        <x-card>
            <x-koala.datatable
                tableId="authors-dt"
                :ajaxUrl="route('api.authors.dt')"
                :columns="$columns"
            >
            </x-koala.datatable>
        </x-card>
        <x-koala.modal size="2xl" class="text-primary bg-secondary" id="show-author-modal">
            <x-slot name="title">
                <span x-text="`Details for Author #${payload?.id}`"></span>
            </x-slot>
            @include('koaladmin.authors.show')
        </x-koala.modal>
        <form id="author-create-form" novalidate x-on:submit.prevent="storeAuthor">
            <x-koala.modal size="2xl" class="text-primary" id="create-author-modal">
                <x-slot name="title">
                    <span x-text="`Create New Author`"></span>
                </x-slot>
                @include('koaladmin.authors.create')
                <x-slot name="footer">
                    <button type="submit" class="btn py-2 ml-2 bg-success">Submit</button>
                </x-slot>
            </x-koala.modal>
        </form>
        <form id="author-edit-form" x-on:submit.prevent="updateAuthor">
            <x-koala.modal size="2xl" class="text-primary" id="edit-author-modal">
                <x-slot name="title">
                    <span x-text="`Edit Author #${payload?.id}`"></span>
                </x-slot>
                @include('koaladmin.authors.edit')
                <x-slot name="footer">
                    <button type="submit" class="btn py-2 ml-2 bg-success">Submit</button>
                </x-slot>
            </x-koala.modal>
        </form>
        <form x-on:submit.prevent="deleteAuthor">
            <x-koala.modal size="xl" centered class="text-danger bg-danger-lighter" id="delete-author-modal">
                <x-slot name="title">
                    <span class="text-danger" x-text="`Delete Author #${payload?.id}?`"></span>
                </x-slot>
                <p class="text-danger font-semibold">
                    Are you sure you want to delete the record?
                </p>
                <x-slot name="footer">
                    <button type="submit" class="btn py-2 ml-2 bg-danger">Yes, Delete</button>
                </x-slot>
            </x-koala.modal>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        function authors() {
            return {
                payload: {},
                form: {},
                dob: '2020-10-20',
                created() {
                    return this.mounted()
                },
                mounted() {
                    /* Component is mounted and DOM is ready */
                },
                async createAuthor() {
                    this.payload = {};
                    MicroModal.show('create-author-modal');
                },
                async showAuthor(id) {
                    this.payload = {};
                    let res = await apiFetch(`{{route('api.authors.index')}}/${id}`);
                    this.payload = res.payload;
                    MicroModal.show('show-author-modal');
                },
                async editAuthor(id) {
                    this.payload = {};
                    let res = await apiFetch(`{{route('api.authors.index')}}/${id}`);
                    this.payload = res.payload;
                    MicroModal.show('edit-author-modal');
                },
                confirmDeleteAuthor(id) {
                    this.payload.id = id;
                    MicroModal.show('delete-author-modal');
                },
                async deleteAuthor() {
                    console.log('Submitting delete request')
                    let res = await apiSend(`{{route('api.authors.index')}}/${this.payload.id}`,{},'delete');
                    if (res?.success) {
                        alert(res?.message);
                        MicroModal.close('delete-author-modal');
                        this.payload = {};
                        dispatchAlpineEvent('refresh-dt','authors-dt')
                    }
                },
                async updateAuthor() {
                    console.log("Updating author");
                }
            }
        }
    </script>
@endpush
