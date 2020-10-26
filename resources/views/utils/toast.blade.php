@push('scripts')
    {{-- basic toast notification --}}
    @if (session('message'))
        <script>
            M.toast({html: "{{ session('message') }}"});
        </script>
    @endif

    {{-- for general errors only that cannot be linked to particular inputs --}}
    @if (session('error'))
        <script>
            var toastHTML=`
            <i class='material-icons' style='margin-right:5px'>error</i>
            {{ session('error') }}
            <button
                class='btn-flat toast-action'
                onclick="dismissToast()">
                <i class='material-icons white-text'>clear</i>
            </button>
            `;
            function dismissToast(){M.Toast.dismissAll();}
            M.toast({
                html: toastHTML,
                displayLength: 10000,
            });
        </script>
    @endif
@endpush