@extends('layouts.app')

@section('title')
<i class="material-icons left">assignment</i>@lang('document.documents')
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('document.import')</span>
                <blockquote>
                    @lang('document.report')
                    <ul class="browser-default">
                        <li>@lang('document.personal_computer')</li>
                        <li>@lang('document.electronic_devices')</li>
                        <li>@lang('document.furnitures')</li>
                    </ul>
                    @lang('document.not_report')
                    <ul class="browser-default">
                        <li>@lang('document.kitchen')</li>
                        <li>@lang('document.hair_dryer')</li>
                    </ul>
                </blockquote>
                <div class="row">
                    <div class="col s12">
                        <table>
                            <tbody>
                                <tr>
                                    <form method="POST" action="{{ route('documents.import.add') }}">
                                        @csrf
                                        <td>
                                            <input type="text" name="item" placeholder="@lang('document.item')"
                                                autofocus maxlength="100" required>
                                        </td>
                                        <td>
                                            <input type="text" name="serial_number"
                                                placeholder="@lang('document.serial_number')" maxlength="30">
                                        <td>
                                            <button class="btn-floating right waves-effect waves-light" type="submit">
                                                <i class="material-icons">add</i>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->serial_number ?? ''}}</td>
                                    <td>
                                        <form method="POST" action="{{ route('documents.import.remove') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button class="btn-floating right waves-effect waves-light" type="submit">
                                                <i class="material-icons">remove</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <a href="{{ route('documents.import.download') }}" type="submit"
                    class="btn waves-effect coli">@lang('document.download')</a>
                @can('print.print')
                <a href="{{ route('documents.import.print') }}" type="submit"
                    class="btn waves-effect coli blue right">@lang('document.print')</a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection