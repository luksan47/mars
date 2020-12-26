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
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">

<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
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
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
    <p class="date">{{ now()->format('Y. m. d.') }}</p>
    <h1>
        Kedves Collegisták!<br>
        Az alábbiakban a collegiumi Választmány hírlevelét olvashatjátok.<br>
        A mai hírlevélben a következő témákról lesz szó:
    </h1>

    <h2>
    <ol>
        @foreach ($news as $article)
        <li><h2>{{ $article->title }}</h2><h3>{{ $article->subtitle}}</h3></li>
        @endforeach
    </ol>
    </h2>
<hr>
Szerkesztette: sljadlj
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">

    <img src="{{ asset('img/valasztmany_logo.png') }}" width="120" alt=""><br>
    <a href="https://eotvos.elte.hu" style="">Eötvös József Collegium</a>
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
</body>
</html>
