@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form>
                            <div>
                                <h4>
                                    @lang('user.personal_information'):
                                </h4>
                            </div>
                            <div class="inputField" >
                                <label for="name">@lang('user.name')</label>
                                <input type="text" name="name" id="name" required>
                            </div>

                            <div class="inputField">
                                <label for="surname">@lang('user.surname')</label>
                                <input type="text" name="surname" id="surname" required>
                            </div>
                            <div class="inputField">
                                <label for="email">@lang('user.email')</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div class="inputField">
                                <label for="date_and_place_of_birth">@lang('user.date_and_place_of_birth')</label>
                                <input type="text" name="date_and_place_of_birth" id="date_and_place_of_birth" required>
                            </div>
                            <div class="inputField">
                                <label for="mother_name">@lang('user.mother_name')</label>
                                <input type="text" name="mother_name" id="mother_name" required>
                            </div>
                            <div class="inputField">
                                <label for="phone_number">@lang('user.phone_number')</label>
                                <input type="text" name="phone_number" id="phone_number" required>
                            </div>
                            <div>
                                <h4>
                                    @lang('user.address_information'):
                                </h4>
                            </div>

                            <div class="inputField">
                                <label for="zip_code">@lang('user.zip_code')</label>
                                <input type="text" name="zip_code" id="zip_code" required>
                            </div>

                            <div class="inputField">
                                <label for="city">@lang('user.city')</label>
                                <input type="text" name="city" id="city" required>
                            </div>
                            <div class="inputField">
                                <label for="address">@lang('user.address')</label>
                                <input type="text" name="address" id="address" required>
                            </div>
                            <div>
                                <h4>
                                    @lang('user.information_of_studies'):
                                </h4>
                            </div>
                            <div class="inputField">
                                <label for="year_of_the_leaving_exam">@lang('user.year_of_the_leaving_exam')</label>
                                <input type="text" name="year_of_the_leaving_exam" id="year_of_the_leaving_exam"
                                       required>
                            </div>
                            <div class="inputField">
                                <label for="neptun_identifier">@lang('user.neptun_identifier')</label>
                                <input type="text" name="neptun_identifier" id="neptun_identifier" required>
                            </div>
                            <div class="inputField">
                                <label for="year_of_enrollment">@lang('user.year_of_enrollment')</label>
                                <input type="text" name="year_of_enrollment" id="year_of_enrollment" required>
                            </div>
                            @lang('user.faculty'):
                            <select id="faculty">
                                <option value="jogtudomanyi_kar">@lang('user.jogtudomanyi_kar')</option>
                                <option value="barczi_gusztav_gyogypedagogiai_kar">@lang('user.barczi_gusztav_gyogypedagogiai_kar')</option>
                                <option value="bolcseszettudomanyi_kar">@lang('user.bolcseszettudomanyi_kar')</option>
                                <option value="pedagogiai_es_pszichologiai_kar">@lang('user.pedagogiai_es_pszichologiai_kar')</option>
                                <option value="tanito_eso_vokepzo_kar">@lang('user.tanito_eso_vokepzo_kar')</option>
                                <option value="tarsadalomtudomanyi_kar">@lang('user.tarsadalomtudomanyi_kar')</option>
                                <option value="termeszettudomanyi_kar">@lang('user.termeszettudomanyi_kar')</option>
                            </select><br>
                            <div>
                                @lang('user.workshop'):

                                <select multiple id="workshop">
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
                            <div class="inputField">
                                <input type="submit" value="@lang('user.save')">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        //    $('#workshop').multiSelect({ keepOrder: true });

    </script>
@endsection

