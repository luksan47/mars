@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-default">
                    <div class="card-header">@lang('user.personal_information'):</div>
                    <div class="card-body">
                        <form method="post" action="/safe_basic_data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-sm-12 control" for="first_name">@lang('user.first_name')</label>
                                    <div class="col-sm-12">
                                    <input class="form-control" type="text" name="first_name" id="first_name" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-sm-12 control" for="last_surname">@lang('user.surname')</label>
                                    <div class="col-sm-12">
                                    <input class="form-control" type="text" name="last_surname" id="last_surname" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control" for="email">@lang('user.email')</label>
                                <div class="col-sm-8">
                                <input class="form-control" type="email" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control" for="date_and_place_of_birth">@lang('user.date_and_place_of_birth')</label>
                                <div class="col-sm-8">
                                <input class="form-control" class="control" type="text" name="date_and_place_of_birth"
                                       id="date_and_place_of_birth" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control" for="mother_name">@lang('user.mother_name')</label>
                                <div class="col-sm-8">
                                <input class="form-control" type="text" name="mother_name" id="mother_name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control" for="phone_number">@lang('user.phone_number')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="+36 12 345 6789" required>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <input class="btn btn-primary" type="submit" value="@lang('user.save')">
                            </div>
                        </form>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">@lang('user.address_information'):</div>
                        <div class="card-body">
                            <form method="post" action="safe_address">
                                @csrf

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="col-sm-12 control" for="zip_code">@lang('user.zip_code')</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="zip_code" id="zip_code" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-sm-12 control" for="city">@lang('user.city')</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="city" id="city" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-4 control" for="address">@lang('user.address')</label>
                                    <div class="col-sm-8">
                                    <input class="form-control" type="text" name="address" id="address" required>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input class="btn btn-primary" type="submit" value="@lang('user.save')">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">@lang('user.information_of_studies'):</div>
                        <div class="card-body">
                            <form method="post" action="safe_studium">
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-4 control" for="year_of_the_leaving_exam">@lang('user.year_of_the_leaving_exam')</label>
                                    <div class="col-sm-8">

                                        <input class="form-control" type="number" min="1900" max="2099" step="1" value="2016" required/>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control" for="neptun_identifier">@lang('user.neptun_identifier')</label>
                                    <div class="col-sm-8">
                                    <input class="form-control" type="text" name="neptun_identifier"
                                           id="neptun_identifier" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control" for="year_of_enrollment">@lang('user.year_of_enrollment')</label>
                                    <div class="col-sm-8">
                                    <input class="form-control" type="number" name="year_of_enrollment" id="year_of_enrollment" required>
                                    </div>
                                </div>
                                <label class="col-sm-4 control" for="faculty">@lang('user.faculty')</label>
                                <div class="col-sm-8">
                                <select id="faculty" class="form-control">
                                    <option value="jogtudomanyi_kar">@lang('user.jogtudomanyi_kar')</option>
                                    <option value="barczi_gusztav_gyogypedagogiai_kar">@lang('user.barczi_gusztav_gyogypedagogiai_kar')</option>
                                    <option value="bolcseszettudomanyi_kar">@lang('user.bolcseszettudomanyi_kar')</option>
                                    <option value="pedagogiai_es_pszichologiai_kar">@lang('user.pedagogiai_es_pszichologiai_kar')</option>
                                    <option value="tanito_eso_vokepzo_kar">@lang('user.tanito_eso_vokepzo_kar')</option>
                                    <option value="tarsadalomtudomanyi_kar">@lang('user.tarsadalomtudomanyi_kar')</option>
                                    <option value="termeszettudomanyi_kar">@lang('user.termeszettudomanyi_kar')</option>
                                </select>
                                </div>
                                <div>
                                    <label class="col-sm-4 control" for="workshop">@lang('user.workshop')</label>
                                    <div class="col-sm-8">
                                    <select multiple class="form-control" id="workshop">
                                        <option value="angol_amerikai_muhely">@lang('user.angol_amerikai_muhely')</option>
                                        <option value="barczi_gusztav_gyogypedagogiai_kar">@lang('user.barczi_gusztav_gyogypedagogiai_kar')</option>
                                        <option value="biologia_kemia_muhely">@lang('user.biologia_kemia_muhely')</option>
                                        <option value="bollok_janos_klasszika_filologia_muhely">@lang('user.bollok_janos_klasszika_filologia_muhely')</option>
                                        <option value="aurelien_sauvageot_francia_muhely">@lang('user.aurelien_sauvageot_francia_muhely')</option>
                                        <option value="filozofia_muhely">@lang('user.filozofia_muhely')</option>
                                        <option value="magyar_muhely">@lang('user.magyar_muhely')</option>
                                        <option value="matematika_fizika_muhely">@lang('user.matematika_fizika_muhely')</option>
                                        <option value="mendol_tibor_foldrajz">@lang('user.mendol_tibor_foldrajz')</option>
                                        <option value="spanyol_muhely">@lang('user.spanyol_muhely')</option>
                                        <option value="szlavisztika_muhely">@lang('user.szlavisztika_muhely')</option>
                                        <option value="tarsadalomtudomanyi_muhely">@lang('user.tarsadalomtudomanyi_muhely')</option>
                                        <option value="törtenesz_muhely">@lang('user.törtenesz_muhely')</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input class="btn btn-primary" type="submit" value="@lang('user.save')">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


