@extends('auth.application.app')

@section('personal-active') active @endsection

@section('form')

<div class="card">
    <form method="POST" action="{{ route('application.store', ['page' => 'personal']) }}">
        @csrf
        <div class="card-content">
            <div class="row" style="margin-bottom: 0">
                <x-input.text id='name' required autocomplete='name' locale='user' :value="$user->name" />
                <x-input.text l=6 id='place_of_birth' required locale='user'
                    :value="$user->personalInformation->place_of_birth" />
                <x-input.datepicker l=6 id='date_of_birth' required locale='user'
                    :value="$user->personalInformation->date_of_birth" />
                <x-input.text id='mothers_name' required locale='user'
                    :value="$user->personalInformation->mothers_name" />
                <x-input.text id='phone_number' type='tel' required pattern="[+][0-9]{1,4}[-\s()0-9]*" minlength="8"
                    maxlength="18" locale='user' helper='+36 (20) 123-4567'
                    :value="$user->personalInformation->phone_number" />
                <x-input.select id="country" :elements="$countries" locale="user"
                    :default="$user->personalInformation->country" />
                <x-input.text l=6 id='county' locale='user' required :value="$user->personalInformation->county" />
                <x-input.text l=6 id='zip_code' locale='user' type='number' required
                    :value="$user->personalInformation->zip_code" />
                <x-input.text id='city' locale='user' required :value="$user->personalInformation->city" />
                <x-input.text id='street_and_number' locale='user' required
                    :value="$user->personalInformation->street_and_number" />
            </div>
        </div>
        <div class="card-action">
            <div class="row" style="margin-bottom: 0">
                <x-input.button only_input class="right" text="general.save" />
            </div>
        </div>
    </form>
</div>

@endsection
