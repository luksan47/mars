<div class="card hoverable
    @if($article->shouldBeSent())
    @can('send', \App\Models\EpistolaNews::class)
        orange lighten-4
    @endcan
    @else
        @if($article->sent)
        grey lighten-2
        @endif
    @endif
    ">
    <div class="card-image" style="overflow-x: auto;overflow-y: hidden;">
        <img class="materialboxed" id="{{$article->id}}" src="{{ $article->picture_path ?? url('/img/committee-logos/kommbiz.jpg')}}" onerror="standby({{$article->id}})">
    </div>
    <div class="card-content activator">
        <i class="material-icons float right" style="cursor: pointer">more_vert</i></span>
        <span class="card-title ">{{$article->title}}</span>
        <p>{{$article->subtitle}}</p>
        <p><i>{{$article->date_time}}</i></p>
        @can('send', \App\Models\EpistolaNews::class)
        @if($article->valid_until)
            <p><i @if($article->shouldBeSent()) class="red-text" @endif>Releváns {{$article->valid_until}}-ig.</i></p>
        @endif
        @endcan
    </div>
    <div class="card-reveal">
        <span class="card-title grey-text text-darken-4">{{$article->title}}<i class="material-icons right">close</i></span>
        <i>{{$article->date_time}}</i>
        <p>@markdown($article->description)</p>
        @if($article->registration_deadline)
            <blockquote>Jelentkezési határidő:<br> <i>{{$article->registration_deadline}}</i></blockquote>
        @endif
        @if($article->filling_deadline)
            <blockquote>Kitöltési határidő:<br><i>{{$article->filling_deadline}}</i></blockquote>
        @endif
        @if($article->details_url)
            <a class="chip" href="{{$article->details_url}}">További részletek</a><br>
        @endif
        @if($article->website_url)
            <a class="chip" href="{{$article->website_url}}">Honlap</a><br>
        @endif
        @if($article->registration_url)
            <a class="chip" href="{{$article->registration_url}}">Regisztráció</a><br>
        @endif
        @if($article->fill_url)
            <a class="chip" href="{{$article->fill_url}}">Kitöltés</a><br>
        @endif
        @if($article->facebook_event_url)
            <a class="chip" href="{{$article->facebook_event_url}}">Facebook esemény</a><br>
        @endif
        @can('edit', \App\Models\EpistolaNews::class)
            <p>({{$article->uploader->name}})</p>
            <a class="btn-floating waves-effect waves-light grey right" style="margin-bottom: 20px;margin-left:10px" href="{{route('epistola.edit', ['epistola' => $article->id])}}"><i class="material-icons">edit</i></a>
            @if($article->sent)
            <a class="btn-floating waves-effect waves-light grey right" style="margin-bottom: 20px" href="{{route('epistola.restore', ['epistola' => $article->id])}}"><i class="material-icons">restore</i></a>
            @endif
        @endcan
    </div>
</div>
