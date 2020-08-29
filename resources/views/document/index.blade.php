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
                {{-- TODO: show printing errors --}}
                <table>
                    <tbody>
                        <tr>
                            <td>@lang('document.license')</td>
                            <td></td>
                            <td>
                                <a href="{{ route('documents.license.download') }}" type="submit" class="btn waves-effect coli">@lang('document.download')</a>
                            </td>
                            <td>
                                @can('print.print')
                                <a href="{{ route('documents.license.print') }}" type="submit" class="btn waves-effect coli blue">@lang('document.print')</a>
                                @endcan
                            </td>
                        </tr>
                        <tr>
                            <td>@lang('document.import')</td>
                            <td>
                                <a href="{{ route('documents.import.show') }}" type="submit" class="btn waves-effect coli">@lang('document.fill_out')</a>
                            </td>
                            <td>
                                <a href="{{-- {{ route('documents.import.download') }} --}}" type="submit" class="btn waves-effect coli">@lang('document.download')</a>
                            </td>
                            <td>
                                @can('print.print')
                                <a href="{{-- {{ route('documents.import.print') }} --}}" type="submit" class="btn waves-effect coli blue">@lang('document.print')</a>
                                @endcan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection