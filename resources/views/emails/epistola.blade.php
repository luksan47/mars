<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;1,300;1,400;1,600&display=swap" rel="stylesheet">
</head>
<body>
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
@-ms-viewport{
    width: extend-to-zoom;
    zoom: 1.0;
}
@viewport{
    zoom: 1.0;
    width: extend-to-zoom;
}
</style>
<div style="max-width: 800px;">
<!--[if (gte mso 9)|(IE)]>
    <table cellspacing="0" cellpadding="0" border="0" width="800"><tr><td>
<![endif]-->
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 800px;">

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <!-- Header -->
    <tr>
        <td class="header" style="vertical-align:middle">
            <table align="center">
                <tr>
                    <td>
                        <img src="{{ asset('img/eotvos_logo.png') }}" width="90" alt="">
                    </td>
                    <td>
                        <span class="title">Epistola Collegii</span><br>
                        <span class="subtitle">A Választmány hírlevele</span><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Email Body -->
    <tr>
        <td class="body" width="100%" cellpadding="0" cellspacing="0">
            <!-- Prelude -->
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="content-cell">
                        <p class="date">{{ now()->format('Y. m. d.') }}</p>
                        <h1>
                            Kedves Collegisták!<br>
                            Az alábbiakban a collegiumi Választmány hírlevelét olvashatjátok.<br>
                            A mai hírlevélben a következő témákról lesz szó:
                        </h1>

                        @php $i=1; @endphp
                        @foreach ($news as $article)
                            <h2>{{ $i }}.<span>{{$article->title }}</span></h2>
                            <h3>{{ $article->subtitle}}</h3>
                            @php $i++; @endphp
                        @endforeach
                        </ol>
                        </h2>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr><td style="border-bottom:1px solid #242851;">&nbsp;</td></tr><tr>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
                        <p class="center">További eseményeket az <a href="{{route('epistola')}}" target="_blank" rel="noopener">Uránban</a> várjuk feltöltésre.</p>
                        @php
                            $names = $news->map(function($item) {return $item->uploader->name;})->unique()->toArray();
                        @endphp
                        <p class="center">Szerkesztette: {{ implode(", ",$names)}}.</p>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
            <tr><td style="height: 50px">&nbsp;</td></tr>
            </table>
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="content-cell">
                        @php $i=1; @endphp
                        @foreach ($news as $article)
                            <h2>{{ $i }}.<span>{{$article->title }}</span></h2>
                            <h3>{{$article->date_time}}</h3>
                            <p class="description">@markdown($article->description)</p>
                            @if($article->picture_path)
                            <img src="{{ $article->picture_path }}">
                            @endif
                            <div style="margin-left: 10px">
                                @if($article->further_details_url)
                                <a href="{{$article->further_details_url}}" class="button" target="_blank" rel="noopener">További részletek</a>
                                @endif
                                @if($article->website_url)
                                <a href="{{$article->website_url}}" class="button" target="_blank" rel="noopener">Weboldal</a>
                                @endif
                                @if($article->facebook_event_url)
                                <a href="{{$article->facebook_event_url}}" class="button" target="_blank" rel="noopener">Facebook esemény</a>
                                @endif
                                @if($article->fill_url)
                                <a href="{{$article->fill_url}}" class="button" target="_blank" rel="noopener">Kitöltés</a>
                                @endif
                                @if($article->registration_url)
                                <a href="{{$article->registration_url}}" class="button" target="_blank" rel="noopener">Regisztráció</a>
                                @endif
                            </div>
                            @if($article->registration_deadline)
                            <div class="warning">Regisztráció határideje: <i>{{$article->registration_deadline->format('Y. m. d.')}}</i></div>
                            @endif
                            @if($article->filling_deadline)
                            <div class="warning">Kitöltés határideje: <i>{{$article->filling_deadline->format('Y. m. d.')}}</i></div>
                            @endif
                            @php $i++; @endphp
                        @endforeach
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Footer -->
    <tr>
        <td>
            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="content-cell" align="center">
                        <a href="https://eotvos.elte.hu" target="_blank" rel="noopener">Eötvös József Collegium</a><br>
                        <img src="{{ asset('img/valasztmany_logo.png') }}" width="120" alt=""><br>
                        <p>
                        <a href="mailto:{{env('MAIL_VALASZTMANY')}}">{{env('MAIL_VALASZTMANY')}}</a><br>
                        <a href="mailto:{{env('MAIL_KOMMBIZ')}}">{{env('MAIL_KOMMBIZ')}}</a>
                        </p>
                        <div class="subcopy">
                            <p>
                                Amennyiben nem szeretnél több hírlevelet kapni, a lemondási szándékodat az alábbi linken tudod jelezni:<br>
                                <a href="https://listbox.elte.hu/mailman/listinfo/eotvos-epistolacollegii?fbclid=IwAR1hq1q5z0lsIQ5lMPX231FKsAmibXt4o_Kf7jlCoOClFdk6Q4xAkuDlGro">Leiratkozás</a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</table>
<!--[if (gte mso 9)|(IE)]>
  </td></tr></table>
<![endif]-->
</div>
</body>
</html>
