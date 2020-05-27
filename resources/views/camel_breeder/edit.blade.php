<script>
$(document).ready(function(){
    $('.tabs').tabs({
        swipeable: true,
    });
});
</script>
<div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-content ">
            <div class="row">
                @if ($errors->any())
                    <blockquote class="error">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </blockquote>
                @endif
            </div>
            <div class="card-header" style="font-size:1.3em">Új pásztor hozzáadása</div>
                <form method="POST" id="add_shepherd_form" action="{{ route('camel_breeder.add_shepherd') }}">
                    @csrf
                    <div class="row">
                        <div class="input-field col s4">
                            <input id="shepherd_name" name="name" type="text" 
                                oninput="isInvalidName(this.value)" required>
                            <label for="name">Név</label>
                            <blockquote id="name_text"></blockquote>
                        </div>
                        <div class="input-field col s4">
                            <input id="shepherd_id" name="id" type="number" min="1" 
                                oninput="isInvalidId(this.value)" required>
                            <label for="id">Azonosító</label>
                            <blockquote id="id_text"></blockquote>
                        </div>
                        <div class="input-field col s2">
                            <input name="camels" type="number">
                            <label for="camels">Kezdő teveszám</label>
                        </div>
                        <div class="input-field col s2">
                            <button class="btn waves-effect" type="submit" style="width:100%">Hozzáadás</button>
                        </div>
                    </div>
                </form>
            
            <div class="card-header" style="font-size:1.3em">Új csorda hozzáadása</div>
            <form method="POST" action="{{ route('camel_breeder.add_herd') }}">
                @csrf
                <div class="row">
                    <div class="input-field col s5">
                        <input name="name" type="text" required>
                        <label for="name">Név</label>
                    </div>
                    <div class="input-field col s5">
                        <input id="camel_count" name="camel_count" min="0" type="number" required>
                        <label for="id">Hány tevéből áll?</label>
                    </div>
                    <div class="input-field col s2">
                        <button class="btn waves-effect" type="submit" style="width:100%">Hozzáadás</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col s12" style="margin-bottom: 20px">
                    <ul class="tabs">
                    <li class="tab col s4"><a href="#csordak">Csordák</a></li>
                    <li class="tab col s4"><a href="#pasztorok">Pásztorok</a></li>
                    <li class="tab col s4"><a href="#nevelesek">Tevenevelések</a></li>
                    </ul>
                </div>
                <div id="csordak" class="col s12">
                    @include('camel_breeder.tabulators.herds')
                </div>
                <div id="pasztorok" class="col s12">
                    @include('camel_breeder.tabulators.shepherds')
                </div>
                <div id="nevelesek" class="col s12">
                    @include('camel_breeder.tabulators.shepherdings')
                </div>
            </div>
            <a class="waves-effect waves-teal btn-flat scale-transition" id="advanced_button" onclick="toggle_advanced_settings()">További beállítások</a>
            <script>
                function toggle_advanced_settings(){
                    settings = document.getElementById('advanced_settings');
                    button = document.getElementById('advanced_button');
                    settings.style.display = 'block';
                    settings.classList.add("scale-in");
                    button.classList.add('scale-out');
                };
            </script>
            <div id="advanced_settings" style="display:none" class="scale-transition scale-out">
                <form method="POST" action="{{ route('camel_breeder.change_password') }}">
                    @csrf
                    <div class="row">
                        <div class="input-field col s5">
                            <input id="old_password" name="old_password" type="password" required>
                            <label for="old_password">Régi jelszó</label>
                        </div>
                        <div class="input-field col s5">
                            <input id="new=password" name="new_password" type="password" required>
                            <label for="new_password">Új jelszó</label>
                        </div>
                        <div class="input-field col s2">
                            <button type="submit" class="btn waves-effect" style="width:100%">Módosítás</button>
                        </div>
                    </div>
                </form>
                <form method="POST" action="{{ route('camel_breeder.change_def_min_camels') }}">
                    @csrf
                    <div class="row">
                        <div class="input-field col s10">
                            <input id="def_min_camels" name="def_min_camels" type="number" required>
                            <label for="def_min_camels">Alapértelmezett minimum teveszám</label>
                        </div>
                        <div class="input-field col s2">
                            <button type="submit" class="btn waves-effect" style="width:100%">Módosítás</button>
                        </div>
                    </div>
                </form>
            </div>
            <a class="right btn-floating btn-large waves-effect waves-light" 
                href="{{route('camel_breeder')}}">
                <i class="white coli-text text-orange material-icons">close</i>
            </a>
        </div>
    </div>
</div>