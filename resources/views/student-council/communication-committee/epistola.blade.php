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
    " >
    <div class="card-image" style="overflow-x: auto;overflow-y: hidden;">
        <img class="materialboxed" id="{{$article->id}}" src="{{ $article->picture_path ?? url('/img/committee-logos/kommbiz.jpg')}}" onerror="standby({{$article->id}})">
    </div>
    <div class="card-content" onclick="window.location='{{ route('epistola.preview')}}'"
    style="cursor:pointer">
        <span class="card-title ">{{$article->title}}</span>
        @if($article->sent)
        <a class="btn-floating waves-effect waves-light grey right" href="{{route('epistola.restore', ['epistola' => $article->id])}}"><i class="material-icons">restore</i></a>
        @else
        <a class="btn-floating waves-effect waves-light grey right" href="{{route('epistola.edit', ['epistola' => $article->id])}}"><i class="material-icons">edit</i></a>
        @endif
        <p>{{$article->subtitle}}</p>
        <p><i>{{$article->date_time}}</i></p>
        @can('edit', \App\Models\EpistolaNews::class)
        @if($article->valid_until)
            <p><i @if($article->shouldBeSent()) class="red-text" @endif>Releváns {{$article->valid_until}}-ig.</i></p>
        @endif
        @endcan
    </div>
</div>
