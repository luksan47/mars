\documentclass[11pt]{article}
\usepackage[utf8]{inputenc}
\usepackage[T1]{fontenc} % Output font encoding for international characters
\usepackage[magyar]{babel} %language
\usepackage{setspace} %for onehalfspacing

\onehalfspacing

%-----Margins-----%
\usepackage{geometry}
\geometry{
	paper=a4paper, % Change to letterpaper for US letter
	inner=2.54cm, % Inner margin
	outer=2.54cm, % Outer margin
	bindingoffset=0cm, % Binding offset
	top=2.54cm, % Top margin
	bottom=2.54cm, % Bottom margin
}

\newcommand{\lotofdots}{.....................................}

\date{}

\pagenumbering{gobble}

\begin{document}

\begin{center}
\Large \textsc{Eötvös József Collegium \\ Behozatali engedély} \\ \normalsize (Házirend, 2. sz. melléklet)
\end{center}

\vspace*{2em}

\noindent{}Tisztelt Igazgató Úr!

\vspace*{1em}
\noindent{}Kérem engedélyezze a tulajdonomban lévő eszközök behozatalát az Eötvös József Collegiumba:

\begin{enumerate}
@foreach($items as $item)
    \item {{ $item->name }} @if(isset($item->serial_number)) ({{ $item->serial_number }}) @endif 
@endforeach
\end{enumerate}

\vspace*{1em}
\noindent{}Útmutató:
\begin{enumerate}
    \item Nem kell bejelenteni
    \begin{enumerate}
        \item konyhai eszközök (pl. edények)
        \item hajszárító, hajsütő
    \end{enumerate}
    \item Be kell bejelenteni:
    \begin{enumerate}
        \item személyi számítógép
        \item egyéb nem említett elektronikai eszközök (kenyérpirító, vízforraló)
        \item  egyéb bútorzat, irodai eszköz (szék, asztal, tábla, stb.)
    \end{enumerate}
\end{enumerate}

\vspace*{1em}
\noindent{}Büntetőjogi felelősségem tudatában kijelentem, hogy számítógépem nem tartalmaz illegálisan
birtokolt programokat és egyéb tartalmakat.

\vspace{2em}
\noindent{}Budapest, {{ $date }}

\hfill\lotofdots

\hfill {{ $name }} \hspace{3.5em}

\vspace{3em}

\vspace{2em}
\noindent{}Engedélyező:
\vspace*{1em}

\noindent{}Budapest,

\hfill\lotofdots

\hfill aláírás\hspace{3.5em}

\end{document}
