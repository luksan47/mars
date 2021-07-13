@extends('layouts.app')

@section('content')


<div class="card mt-4">
    <div class="card-content">
        <div class="d-felx offset-sm-1 col-md-10">

            <h2 class="mt-3">Felhasználók regisztrálása</h2>



            <form action="{{ route('admin.register.register') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="register_data" class="font-weight-bolder text-justify">
                        Név, E-mail:
                    </label>
                    <textarea required name="register_data" id="register_data" class="form-control" rows="17" placeholder="Super User ; root@eotvos.elte.hu&#10;Http Admin ; webmaster@eotvos.elte.hu&#10;...">{{ $prev_submit['register_data'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="" class="font-weight-bolder text-justify">
                        Engedélyek:
                    </label>
                </div>
                <table class="table table-hover">
                    <tbody>
                        @foreach ( \App\Permissions::PERMISSIONS as $permission_code => $permission )
                        <tr>
                            <td class="py-0 px-0">
                                <label for="permission_id_{{ $permission_code }}" class="d-flex mb-0" style="padding: 0.75rem;">
                                    {{ $permission['name'] }}
                                </label>
                            </td>
                            <td>
                                <input type="checkbox" name="perimission_ids[]" value="{{ $permission_code }}" id="permission_id_{{ $permission_code }}" {{ isset($prev_submit['perimission_ids']) }}>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="form-group">
                    <input type="submit" value="Regisztrálás" class="form-control btn btn-primary">
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
