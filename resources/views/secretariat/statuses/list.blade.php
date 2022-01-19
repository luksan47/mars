@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('admin.admin')</a>
<a href="{{ route('secretariat.user.list') }}" class="breadcrumb" style="cursor: pointer">@lang('admin.user_management')</a>
<a href="#!" class="breadcrumb">@lang('admin.statuses')</a>
@endsection
@section('student_council_module') active @endsection

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">{{ App\Models\Semester::current()->tag }}
                </span>
                <table>
                    <tbody>
                        @foreach($collegists as $user)
                        <tr>
                            <td>
                                <b><a href="{{ route('secretariat.user.show', ['id' => $user->id]) }}" class="black-text" >{{ $user->name }}</a></b>
                                @if($user->hasEducationalInformation())
                                <br>{{ $user->educationalInformation->neptun ?? '' }}
                                @endif
                            </td>
                            <td>
                                @livewire('edit-resident', ['user' => $user])
                            </td>
                            <td>
                                @livewire('edit-status', ['user' => $user, 'semester' => \App\Models\Semester::current()])
                            </td>
                            <td>
                                <x-input.button :href="route('secretariat.user.semesters', ['id' => $user->id])" class="coli blue right" icon="event_note" floating />
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();
        });
    </script>
@endpush
