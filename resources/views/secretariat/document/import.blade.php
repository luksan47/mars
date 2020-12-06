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
                        <li>@lang('document.computer')</li>
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
                                            <x-input.text id="item" locale="document" autofocus maxlength="100" required />
                                        </td>
                                        <td>
                                            <x-input.text id="serial_number" locale="document" maxlength="30" />
                                        <td>
                                            <x-input.button floating class="right" icon="add"/>
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
                                            <x-input.text hidden id="id" :value="$item->id" />
                                            <x-input.button floating class="right" icon="remove" />
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
