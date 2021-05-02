<form action="{{ route('internet.mac_addresses.add') }}" method="post">
    <div class="form-row align-items-center">
        @csrf
        <div class="row">
            <x-input.text l=5 id="mac_address" placeholder="01:23:45:67:89:AB" required locale="internet"/>
            <x-input.text l=5 id="comment" placeholder="Laptop" required locale="internet"/>
            <x-input.button l=2 text="internet.add"/>
        </div>
    </div>
</form>
