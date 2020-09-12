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
\Large \textsc{Eötvös József Collegium \\ Beköltözési nyilatkozat} \\ \normalsize (Házirend, 1. sz. melléklet)
\end{center}

\vspace*{2em}

\noindent{}Név: {{ $name }} \\
Állandó lakcím: {{ $address }} \\
Telefonszám: {{ $phone }} \\
E-mail: {{ $email }} \\
Születési hely és idő: {{ $place_and_of_birth }} \\
Anyja neve: {{ $mothers_name }} \\
Beköltözés dátuma: \\
\\
Megjegyzések:

A szobában lévő berendezéseket csak gondnoki engedéllyel lehet cserélni. A behozatali engedélyt a beköltözési nyilatkozattal együtt kell leadni. A ki - és beköltözést, valamint az átköltözést minden esetben jelenteni kell a gondnoknak és a Választmánynak is.

A beköltözéssel elfogadom a Házirendet, valamint az intézmény Munka-, tűz- és vagyonvédelmi
előírásait.

\vspace{4em}
A fentieket tudomásul vettem, a szobát a leltár szerint átvettem.

\vspace{2em}
\noindent{}Budapest, {{ $date }}

\hfill\lotofdots

\hfill aláírás\hspace{3.5em}

\vspace{3em}

\begin{center}
\Large \textsc{Eötvös József Collegium \\ Kiköltözési nyilatkozat} \\ \normalsize (Házirend, 3. sz. melléklet)
\end{center}
\vspace{2em}

\noindent{}Kiköltözés dátuma:

\noindent{}A szobát a leltár szerint átadtam.

\vspace{2em}

\noindent{}Budapest,

\hfill\lotofdots

\hfill aláírás\hspace{3.5em}

\end{document}
