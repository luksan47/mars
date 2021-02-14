@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.document_requests')</a>
@endsection
@section('admin_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.document_requests')</span>
                <table>
                    <thead>
                        <tr>
                            <th>@lang('user.name')</th>
                            <th>@lang('user.neptun')</th>
                            <th>@lang('document.request')</th>
                            <th>@lang('checkout.date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                        <tr>
                            <td>
                                {{ $request->user->name ?? 'Name not found' }}
                            </td>
                            <td>
                                {{ $request->user->educationalInformation->neptun ?? 'Neptun code not found'}}
                            </td>
                            <td>
                                @if ($request->document_type === 'StatusCertificate')    
                                    @lang('document.status-cert')
                                @else
                                    {{ $request->document_type }}
                                @endif
                            </td>
                            <td>
                                {{ $request->created_at->format('Y-m-d h:m') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection
