@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">@lang('print.print')</div>
                <div class="card-body">
                    @if (session('print.status'))
                        <div class="alert alert-success">
                            {{ session('print.status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="alert alert-info">
                        <strong>@lang('general.note'):</strong>
                        @lang('print.available_money'): {{ Auth::user()->printAccount->balance }} HUF
                    </div>
                    @include("print.print")
                    @include("print.free")
                    @include("print.modify")
                    @include("print.free-admin")
                    @include("print.send")
                    @include("print.history")
                </div>
            </div>
        </div>
    </div>
    </div>


<!-- Datepicker script -->
<script type="text/javascript">
	$(function(){
		$('.date').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			clearBtn: true,
			weekStart: 1,
			startView: "century"
		})
	});
</script>

@endsection
