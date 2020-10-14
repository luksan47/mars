@extends('layouts.app')

@section('title')
<i class="material-icons left">assignment</i>@lang('document.documents')
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('document.documents')</span>
                <blockquote>@lang('document.clarify_print')</blockquote>
                <blockquote>@lang('document.clarify_request')</blockquote>
                {{-- TODO: show printing errors --}}
                <table>
                    <tbody>
                        @can('document.register-statement')
                        <tr>
                            <td>@lang('document.register-statement')</td>
                            <td></td>
                            <td>
                                <a href="{{ route('documents.register-statement.download') }}" type="submit" class="btn waves-effect coli">@lang('document.download')</a>
                            </td>
                            <td>
                                @can('print.print')
                                <a href="{{ route('documents.register-statement.print') }}" type="submit" class="btn waves-effect coli blue">@lang('document.print')</a>
                                @endcan
                            </td>
                        </tr>
                        @endcan
                        @can('document.import-license')
                        <tr>
                            <td>@lang('document.import')</td>
                            <td>
                                <a href="{{ route('documents.import.show') }}" type="submit" class="btn waves-effect coli">@lang('document.fill_out')</a>
                            </td>
                            <td>
                                <a href="{{ route('documents.import.download') }}" type="submit" class="btn waves-effect coli">@lang('document.download')</a>
                            </td>
                            <td>
                                @can('print.print')
                                <a href="{{ route('documents.import.print') }}" type="submit" class="btn waves-effect coli blue">@lang('document.print')</a>
                                @endcan
                            </td>
                        </tr>
                        @endcan
                        @can('document.status-certificate')
                        <tr>
                            <td>@lang('document.status-cert')</td>
                            <td></td>
                            <td>
                                <a href="{{ route('documents.status-cert.download') }}" type="submit" class="btn waves-effect coli">@lang('document.download')</a>
                            </td>
                            <td>
                                <a href="{{ route('documents.status-cert.request') }}" type="submit" class="btn waves-effect coli blue">@lang('document.request')</a>
                            </td>
                        </tr>
                        @endcan
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection