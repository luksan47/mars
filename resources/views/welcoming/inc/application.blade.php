{{--
<div class="card mt-4 card-danger offset-sm-2 col-sm-8">
    <div class="card-content">
        <div class="d-felx   py-4" >

            <h4>Határidő meghosszabbítása</h4>
            <p>
                A felvételi folyamatát érintő kisebb technikai hibák miatt felvételi beküldési határideje meghosszabbításra került.<br>
                A pályázat beküldési határideje: <strong class="text-danger">2020. augusztus 15. 23:59 óra</strong>
            </p>
        </div>
    </div>
</div>
--}}
<div class="card mt-4 card-secondary offset-sm-1 col-sm-10">
    <div class="card-content">
        <div class="d-felx py-4" >

            <div class="row">

                <div class="col-sm-3 text-center pb-4">
                    <img src="{{ asset('img/ec_logo.png') }}" class="img-fluid">
                </div>
                <div class="col-sm-8">

                    <span class="h5 mt-4 font-italic">Kedves jelentkező!</span>
                    <p>
                        Jelentkezése megkezdéséhez első lépésben olvassa végig az alább látható felhívásokat, majd ezt követően egy rövid regisztráció után el is tudja kezdeni a jelentkezéshez szükséges pályázat kitöltését.
                        <br>
                        <br>
                        Fontos, hogy a regisztráció önmagában nem minősül jelentkezésnek, hanem a pályázat véglegesítése és beküldése után válik érvényessé a jelentkezés.

                    </p>
                </div>

            </div>
            <div class="row">

                <div class="btn-group col-sm-8 offset-sm-3">
                    <a href="{{ route('register') }}" class="btn btn-primary w-50">Regisztráció</a>&nbsp;
                    <a href="{{ route('login') }}" class="btn btn-primary w-50">Belépés</a>
                </div>
            </div>
        </div>
    </div>
</div>

