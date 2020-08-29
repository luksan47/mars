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
                <table>
                    <tbody>
                        <tr>
                            <td>@lang('document.license')</td>
                            <td>
                                <a href="{{ route('documents.license.download') }}" type="submit" class="btn waves-effect coli">@lang('document.download')</a>
                            </td>
                            <td>
                                @can('print.print')
                                <a href="{{ route('documents.license.print') }}" type="submit" class="btn waves-effect coli blue">@lang('document.print')*</a>
                                @endcan
                            </td>
                        </tr>
                    </tbody>
                </table>
                <i>*@lang('document.clarify_print')</i>
            </div>
        </div>
    </div>
</div>
@endsection