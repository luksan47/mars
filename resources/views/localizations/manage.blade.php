@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('localizations.translate')</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('localizations.translate')</span>
                <table>
                    <thead>
                      <tr>
                          <th>Language</th>
                          <th>Key</th>
                          <th>Original value*</th>
                          <th>New value</th>
                          <th>Contributor</th>
                          <th></th>
                          <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($contributions as $contribution)
                        <tr>
                            <td>{{ $contribution->language }}</td>
                            <td>{{ $contribution->key }}</td>
                            @php
                            $fname = explode('.', $contribution->key)[0];
                            $key = explode('.', $contribution->key)[1];
                            @endphp
                            <td>@lang($fname . ($fname == 'validation' ? '.attributes.' : '.') . $key)</td>
                            <td>{{ $contribution->value }}</td>
                            <td>{{ ($contribution->contributor != null) ? $contribution->contributor->name : 'null' }}</td>
                            <td>
                                <form method="POST" action="{{ route('localizations.delete') }}">
                                    @csrf
                                    <x-input.text type="number" id="id" :value="$contribution->id" hidden/>
                                    <x-input.button floating class="red" icon="clear" />
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('localizations.approve') }}">
                                    @csrf
                                    <x-input.text type="number" id="id" :value="$contribution->id" hidden/>
                                    <x-input.button floating class="green" icon="done" />
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col s12">
                        @if(count($contributions) == 0)
                        Nothing to show.
                        @else
                        <i>*You have to change to the corresponding language.</i>
                        {{-- This should be deleted later: --}}
                        <form method="POST" action="{{ route('localizations.approve_all') }}">
                            @csrf
                            <x-input.button only_input class="right" text="Approve all"/>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
