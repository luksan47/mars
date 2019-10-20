<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute va accettato.',
    'active_url' => ':attribute non è un URL valido.',
    'after' => ':attribute deve essere una data dopo :date.',
    'after_or_equal' => ':attribute deve essere una data dopo o uguale a :date.',
    'alpha' => ':attribute può solo contenere lettere.',
    'alpha_dash' => ':attribute può solo contenere lettere, numeri, trattini e trattini bassi.',
    'alpha_num' => ':attribute può solo contenere lettere e numeri.',
    'array' => ':attribute deve essere un vettore.',
    'before' => ':attribute deve essere una data prima di :date.',
    'before_or_equal' => ':attribute deve essere una data prima o uguale a :date.',
    'between' => [
        'numeric' => ':attribute deve essere compreso fra :min e :max.',
        'file' => ':attribute deve essere compreso fra :min e :max kilobytes.',
        'string' => ':attribute deve essere compreso fra :min e :max caratteri.',
        'array' => ':attribute deve avere fra fra :min e :max elementi.',
    ],
    'boolean' => ':attribute deve essere vero o falso.',
    'confirmed' => 'La conferma di :attribute non è valida.',
    'date' => ':attribute non è una data valida.',
    'date_equals' => ':attribute deve essere un data data uguale a :date.',
    'date_format' => ':attribute non rispetta il formato :format.',
    'different' => ':attribute e :other devono essere diverse.',
    'digits' => ':attribute deve essere di :digits cifre.',
    'digits_between' => ':attribute deve avere tra :min e :max cifre.',
    'dimensions' => ':attribute ha dimensione dell\'immagine non valida.',
    'distinct' => ':attribute ha un valore duplicato.',
    'email' => ':attribute deve essere un indirizzo e-mail valido.',
    'ends_with' => ':attribute deve finire con uno dei seguenti: :values',
    'exists' => 'Il selezionato :attribute non è valido.',
    'file' => ':attribute deve essere un file.',
    'filled' => ':attribute deve avere un valore.',
    'gt' => [
        'numeric' => ':attribute deve essere più grande di :value.',
        'file' => ':attribute deve essere più grande di :value kilobytes.',
        'string' => ':attributedeve essere più grande di :value caratteri.',
        'array' => ':attribute deve essere più grande di :value elementi.',
    ],
    'gte' => [
        'numeric' => ':attribute deve essere più grande o uguale di :value.',
        'file' => ':attribute deve essere più grande o uguale di :value kilobytes.',
        'string' => ':attribute deve essere più grande o uguale di :value caratteri.',
        'array' => ':attribute deve avere :value elementi o più.',
    ],
    'image' => ':attribute deve essere un immagine.',
    'in' => 'Il selezionato :attribute non è valido.',
    'in_array' => ':attribute non esiste in :other.',
    'integer' => ':attribute deve essere un intero.',
    'ip' => ':attribute deve essere un indirizzo IP valido.',
    'ipv4' => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => ':attribute deve essere un indirizzo IPv6 valido.',
    'json' => ':attribute deve essere una stringa JSON valida.',
    'lt' => [
        'numeric' => ':attribute deve essere meno di :value.',
        'file' => ':attribute deve essere meno di :value kilobytes.',
        'string' => ':attribute deve essere meno di :value caratteri.',
        'array' => ':attribute deve essere meno di :value elementi.',
    ],
    'lte' => [
        'numeric' => ':attribute deve essere meno o uguale di :value.',
        'file' => ':attribute deve essere meno o uguale di :value kilobytes.',
        'string' => ':attribute deve essere meno o uguale di :value caratteri.',
        'array' => ':attribute non può avere più di :value elementi.',
    ],
    'max' => [
        'numeric' => ':attribute non può essere più grande di :max.',
        'file' => ':attribute non può essere più grande di :max kilobytes.',
        'string' => ':attribute non può essere più grande di :max caratteri.',
        'array' => ':attribute non può avere più di :max elementi.',
    ],
    'mimes' => ':attribute deve essere un file di tipo: :values.',
    'mimetypes' => ':attribute deve essere un file di tipo: :values.',
    'min' => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file' => ':attribute deve essere almeno di :min kilobytes.',
        'string' => ':attribute deve essere almeno di :min caratteri.',
        'array' => ':attribute deve avere almeno :min elementi.',
    ],
    'not_in' => 'Il selezionato :attribute non è valido.',
    'not_regex' => 'Il formato di :attribute non è valido.',
    'numeric' => ':attribute deve essere un numero.',
    'present' => 'Il campo :attribute deve essere presente.',
    'regex' => 'Il formato di :attribute non è valido.',
    'required' => 'Il campo :attribute è richiesto.',
    'required_if' => 'Il campo :attribute è richiesto quando :other è :value.',
    'required_unless' => 'Il campo :attribute è richiesto finchè :other è in :values.',
    'required_with' => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all' => 'Il campo :attribute è richiesto quando :values sono presenti.',
    'required_without' => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è richiesto quando nessuno dei :values è presente.',
    'same' => ':attribute e :other devono essere uguali.',
    'size' => [
        'numeric' => ':attribute deve essere :size.',
        'file' => ':attribute deve essere di :size kilobytes.',
        'string' => ':attribute deve essere di :size caratteri.',
        'array' => ':attribute deve contenere :size elementi.',
    ],
    'starts_with' => ':attribute deve iniziare con uno dei seguenti: :values',
    'string' => ':attribute deve essere una stringa.',
    'timezone' => ':attribute deve essere un fuso orario valido.',
    'unique' => ':attribute è già stato preso.',
    'uploaded' => ':attribute ha fallito l\'upload.',
    'url' => 'Il formato di :attribute non è valido.',
    'uuid' => ':attribute deve essere un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
