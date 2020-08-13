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
                            <td>@lang($contribution->key)</td>
                            <td>{{ $contribution->value }}</td>
                            <td>{{ $contribution->contributor->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('localizations.delete') }}">
                                    @csrf
                                    <input type="number" name="id" value="{{ $contribution->id }}" hidden>
                                    <button type="submit" class="btn-floating waves-effect waves-light red"><i class="material-icons">clear</i></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('localizations.approve') }}">
                                    @csrf
                                    <input type="number" name="id" value="{{ $contribution->id }}" hidden>
                                    <button type="submit" class="btn-floating waves-effect waves-light green"><i class="material-icons">done</i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        @if(count($contributions) == 0)
                        Nothing to show.
                        @else
                        <i class="right">*You have to change to the corresponding language.</i>
                        @endif
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>


@endsection