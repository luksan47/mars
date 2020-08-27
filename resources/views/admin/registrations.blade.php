@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="#!" class="breadcrumb">@lang('admin.registrations')</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">@lang('admin.handle_registrations')</span>
                <table>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                <!-- <input type="number" name="user_id" value="{{ $user->id }}" hidden> -->
                                <a href="{{ route('admin.registrations.show', $user->id) }}" type="submit" class="btn waves-effect coli blue">@lang('admin.show')</a>
                            </td>
                            <td>
                                <form  method="POST" action="{{ route('admin.registrations.accept') }}">
                                    @csrf
                                    <input type="number" name="user_id" value="{{ $user->id }}" hidden>
                                    <button type="submit" class="btn waves-effect">@lang('admin.accept')</button>
                                </form>
                            </td>
                            <td>
                                <form  method="POST" action="{{ route('admin.registrations.reject') }}">
                                    @csrf
                                    <input type="number" name="user_id" value="{{ $user->id }}" hidden>
                                    <button type="submit" class="btn waves-effect coli blue">@lang('admin.reject')</button>
                                </form>
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