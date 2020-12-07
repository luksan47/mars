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
\Large \textsc{Eötvös József Collegium \\ Hallgatói adatlap --tag--. tanév}
\end{center}

\vspace*{2em}

\noindent{}Név: --name-- \\
Neptun: --neptun-- \\ 
Állandó lakcím: --address-- \\
Telefonszám: -- \\ 
E-mail: --email-- \\ 
Születési hely és idő: --placeandtimeofbirth-- \\
Anyja neve: --mothersname-- \\
Középiskola neve: \\
Nyelvvizsgák (nyelv, szint, típus): TODO \\
Érettségi éve: TODO Egyetemi felvétel éve: TOOD Collegiumi felvétel éve: TODO
Státusz: --status--
Műhely:
\begin{itemize}
    \item TODO foreach, workshop
\end{itemize}
\noindent{}Szak: TODO

\vspace*{1em}
\noindent{}Aláírásommal hozzájárulok, hogy az Eötvös Collegium tanulmányi ügyekkel megbízott munkatársa a NEPTUN-ban hozzáférést kapjon a tanulmányaimmal kapcsolatos adatokhoz, illetve azokat az Urán informatikai rendszerben kezelje.

\vspace{3em}
\noindent{}Budapest,

\hfill\lotofdots

\hfill --name--\hspace{3.5em}

\end{document}
