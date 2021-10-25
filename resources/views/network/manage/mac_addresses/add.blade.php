<form action="{{ route('internet.mac_addresses.add') }}" method="post">
    <div class="row">
        @csrf
        <x-input.select xl=3 :elements="$users" id="user_id" text="general.user"/>
        <x-input.text xl=3 id="mac_address" placeholder="00:00:00:00:00:00" required locale="internet" />
        <x-input.text xl=3 id="comment" placeholer="Laptop" required locale="internet"/>
        <x-input.button xl=3 class="right" text="internet.add"/>
    </div>
</form>
