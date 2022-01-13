@extends('auth.application.app')

@section('files-active') active @endsection

@section('form')

    {{-- desktop profile pic --}}
    <div class="card horizontal hide-on-small-only">
        <div class="card-image">
            <img src="{{ url($user->profilePicture?->path ?? '/img/avatar.png') }}" style="max-width:300px">
        </div>
        <div class="card-stacked">
            <div class="card-content">
                <div class="card-title">Profilkép</div>
            </div>
            <form action="{{ route('application.store', ['page' => 'files.profile']) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-action valign-center">
                    <x-input.file s="12" xl="8" id="picture" style="margin-top:auto" accept=".jpg,.png,.jpeg"
                        text="Böngészés" required />
                    <x-input.button only_input class="right" style="margin-top: 20px" text="general.upload" />
                </div>
            </form>
        </div>
    </div>
    {{-- mobile profile pic --}}
    <div class="card hide-on-med-and-up">
        <div class="card-image">
            <img src="{{ url('/img/avatar.png') }}">
        </div>
        <div class="card-stacked">
            <div class="card-content">
                <div class="card-title">Profilkép</div>
                <div class="row">
                    <form action="{{ route('application.store', ['page' => 'files.profile']) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <x-input.file s="12" xl="8" id="picture" style="margin-top:auto" accept=".jpg,.png,.jpeg"
                            text="Böngészés" required />
                        <x-input.button only_input class="right" style="margin-top: 20px" text="general.upload" />
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- uploaded files --}}
    <div class="card">
        <div class="card-content">
            <div class="card-title">Feltöltött fájlok</div>
            <blockquote>
                A pályázatnak az alábbiakat kell tartalmaznia:
                <ul style="margin-left:20px;margin-top:0">
                    <li style="list-style-type: circle !important">Hagyományos önéletrajz</li>
                    <li style="list-style-type: circle !important">Felvételi határozat (Neptun: Tanulmányok - Hivatalos
                        bejegyzések menüpont alatt letölthető)</li>
                    <li style="list-style-type: circle !important">Érettségi bizonyítvány másolata</li>
                    <li style="list-style-type: circle !important">Opcionális: oklevelek, igazolások, ajánlások</li>
                </ul>
            </blockquote>

            <div style="margin: 0 20px 0 20px;">
                @forelse ($user->application?->files ?? [] as $file)
                    @if (!$loop->first)<div class="divider"></div>@endif
                    <div class="row" style="margin-bottom: 0; padding: 10px">
                        <form method="POST"
                            action="{{ route('application.store', ['page' => 'files.delete', 'id' => $file->id]) }}"
                            enctype='multipart/form-data'>
                            @csrf

                            <div class="col s10" style="margin-top: 5px">
                                <a href="{{ url($file->path) }}">{{ $file->name }}</a>
                            </div>
                            <div class="col s2">
                                <x-input.button floating class="right btn-small" icon="delete" />
                            </div>
                        </form>
                    </div>
                @empty
                    <p>Még nem töltött fel egy fájlt sem.</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- upload --}}
    <div class="card">
        <form method="POST" action="{{ route('application.store', ['page' => 'files']) }}" enctype='multipart/form-data'>
            @csrf
            <div class="card-content">
                <div class="card-title">Feltöltés</div>

                <div class="row">
                    {{-- TODO max size --}}
                    <x-input.file s=12 m=6 id="file" accept=".pdf,.jpg,.png,.jpeg" text="Böngészés" required />
                    <x-input.text s=12 m=6 id="name" text="Fájl megnevezése" required />
                </div>
                <x-input.button only_input class="right" text="general.upload" />
                <blockquote>A feltölteni kívánt fájlok maximális mérete: 2 MB, az engedélyezett formátumok: .pdf, .jpg,
                    .jpeg, .png</blockquote>
            </div>
        </form>
    </div>

@endsection
