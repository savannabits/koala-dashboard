<div x-cloak x-data="test()">
    <button class="btn bg-success hover:bg-success-darker py-3 my-4" @click="toggleOpen" @click.away="open=false">Welcome to the Neighborhood</button>
    <p x-show="open">You can now see this bbecause we have expanded the div.</p>
</div>
@push('scripts')
    <script>
        function test() {
            return {
                open: false,
                toggleOpen() {
                    this.open = !this.open;
                }
            }
        }
    </script>
@endpush
