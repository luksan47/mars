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
                                <x-input.button :href="route('documents.register-statement.download')" text="document.download" />
                            </td>
                            <td>
                                @can('print.print')
                                <x-input.button :href="route('documents.register-statement.print')" class="coli blue" text="document.print" />
                                @endcan
                            </td>
                        </tr>
                        @endcan
                        @can('document.import-license')
                        <tr>
                            <td>@lang('document.import')</td>
                            <td>
                                <x-input.button :href="route('documents.import.show')" text="document.fill_out" />
                            </td>
                            <td>
                                <x-input.button :href="route('documents.import.download')" text="document.download" />
                            </td>
                            <td>
                                @can('print.print')
                                <x-input.button :href="route('documents.import.print')" class="coli blue" text="document.print" />
                                @endcan
                            </td>
                        </tr>
                        @endcan
                        @can('document.status-certificate')
                        <tr>
                            <td>@lang('document.status-cert')</td>
                            <td></td>
                            <td>
                                <x-input.button :href="route('documents.status-cert.download')" text="document.download" />
                            </td>
                            <td>
                                <x-input.button :href="route('documents.status-cert.request')" class="coli blue" text="document.request" />
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
