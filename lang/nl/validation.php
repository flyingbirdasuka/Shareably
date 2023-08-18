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

    'accepted' => 'Het :attribute moet worden geaccepteerd.',
    'accepted_if' => 'Het :attribute moet worden geaccepteerd als :other :value is.',
    'active_url' => 'Het :attribute is geen geldige URL.',
    'after' => 'Het :attribute moet een datum zijn na :date.',
    'after_or_equal' => 'Het :attribute moet een datum zijn na of gelijk aan :date.',
    'alpha' => 'Het :attribute mag alleen letters bevatten.',
    'alpha_dash' => 'Het :attribute mag alleen letters, cijfers, streepjes en underscores bevatten.',
    'alpha_num' => 'Het :attribute mag alleen letters en cijfers bevatten.',
    'array' => 'Het :attribute moet een matrix zijn.',
    'ascii' => 'Het :attribute mag alleen alfanumerieke tekens en symbolen van één byte bevatten.',
    'before' => 'Het :attribute moet een datum zijn voor :date.',
    'before_or_equal' => 'Het :attribute moet een datum zijn voor of gelijk aan :date.',
    'between' => [
        'array' => 'Het :attribute moet tussen :min en :max keren.',
        'file' => 'Het :attribute moet tussen :min en :max kilobytes.',
        'numeric' => 'Het :attribute moet tussen :min en :max.',
        'string' => 'Het :attribute moet tussen :min en :max tekens.',
    ],
    'boolean' => 'Het :attribute veld moet true of false zijn.',
    'confirmed' => 'Het :attribute bevestiging komt niet overeen.',
    'current_password' => 'Het wachtwoord is onjuist.',
    'date' => 'Het :attribute is geen geldige datum.',
    'date_equals' => 'Het :attribute moet een datum zijn die gelijk is aan :date.',
    'date_format' => 'Het :attribute komt niet overeen met het formaat :format.',
    'decimal' => 'Het :attribute moet :decimal decimalen hebben.',
    'declined' => 'Het :attribute moet worden geweigerd.',
    'declined_if' => 'Het :attribute moet worden geweigerd als :other :value is.',
    'different' => 'Het :attribute en :other moeten verschillend zijn.',
    'digits' => 'Het :attribute moet :digits cijfers zijn.',
    'digits_between' => 'Het :attribute moet tussen :min en :max cijfers zijn.',
    'dimensions' => 'Het :attribute heeft ongeldige afbeeldingsafmetingen.',
    'distinct' => 'Het :attribute veld heeft een dubbele waarde.',
    'doesnt_end_with' => 'Het :attribute mag niet eindigen met een van de volgende: :values.',
    'doesnt_start_with' => 'Het :attribute mag niet beginnen met een van de volgende: :values.',
    'email' => 'Het :attribute moet een geldig e-mailadres zijn.',
    'ends_with' => 'Het :attribute moet eindigen met een van de volgende: :values.',
    'enum' => 'Het geselecteerde :attribute is ongeldig.',
    'exists' => 'Het geselecteerde :attribute is ongeldig.',
    'file' => 'Het :attribute moet een bestand zijn.',
    'filled' => 'Het :attribute veld moet een waarde hebben.',
    'gt' => [
        'array' => 'Het :attribute moet meer dan :value items hebben.',
        'file' => 'Het :attribute moet groter zijn dan :value kilobytes.',
        'numeric' => 'Het :attribute moet groter zijn dan :value.',
        'string' => 'Het :attribute moet groter zijn dan :value tekens.',
    ],
    'gte' => [
        'array' => 'Het :attribute moet :value items of meer hebben.',
        'file' => 'Het :attribute moet groter zijn dan of gelijk aan :value kilobytes.',
        'numeric' => 'Het :attribute moet groter zijn dan of gelijk aan :value.',
        'string' => 'Het :attribute moet groter zijn dan of gelijk aan :value tekens.',
    ],
    'image' => 'Het :attribute moet een afbeelding zijn.',
    'in' => 'Het geselecteerde :attribute is ongeldig.',
    'in_array' => 'Het :attribute veld bestaat niet in :other.',
    'integer' => 'Het :attribute moet een geheel getal zijn.',
    'ip' => 'Het :attribute  moet een geldige IP address zijn',
    'ipv4' => 'Het :attribute moet een geldige IPv4 address zijn.',
    'ipv6' => 'Het :attribute moet een geldige IPv6 address zijn.',
    'json' => 'Het :attribute moet een geldige JSON string zijn.',
    'lowercase' => 'Het :attribute moeten kleine letters zijn.',
    'lt' => [
        'array' => 'Het :attribute moet minder dan :value items hebben.',
        'file' => 'Het :attribute moet minder dan :value kilobytes.',
        'numeric' => 'Het :attribute moet minder dan :value.',
        'string' => 'Het :attribute moet minder dan :value tekens.',
    ],
    'lte' => [
        'array' => 'Het :attribute mag niet meer dan :value items hebben.',
        'file' => 'Het :attribute moet kleiner zijn dan of gelijk aan :value kilobytes.',
        'numeric' => 'Het :attribute moet kleiner zijn dan of gelijk aan :value.',
        'string' => 'Het :attribute moet kleiner zijn dan of gelijk aan :value tekens.',
    ],
    'mac_address' => 'Het :attribute moet een geldige MAC address zijn.',
    'max' => [
        'array' => 'Het :attribute mag niet meer dan :max items hebben.',
        'file' => 'Het :attribute mag niet groter dan :max kilobytes.',
        'numeric' => 'Het :attribute mag niet groter dan :max.',
        'string' => 'Het :attribute mag niet groter dan :max tekens.',
    ],
    'max_digits' => 'Het :attribute mag niet meer dan :max cijfers hebben.',
    'mimes' => 'Het :attribute moet een bestand zijn van het type: :values.',
    'mimetypes' => 'Het :attribute moet een bestand zijn van het type: :values.',
    'min' => [
        'array' => 'Het :attribute moet minstens :min items hebben.',
        'file' => 'Het :attribute moet minstens :min kilobytes zijn.',
        'numeric' => 'Het :attribute moet minstens :min zijn.',
        'string' => 'Het :attribute moet minstens :min tekens.',
    ],
    'min_digits' => 'Het :attribute moet ten minste :min cijfers hebben.',
    'missing' => 'Het :attribute veld moet ontbreken.',
    'missing_if' => 'Het :attribute veld moet ontbreken als :other :value is.',
    'missing_unless' => 'Het :attribute veld moet ontbreke tenzij :other :value is.',
    'missing_with' => 'Het :attribute veld moet ontbreken als :values aanwezig is.',
    'missing_with_all' => 'Het :attribute veld moet ontbreken als :values aanwezig zijn.',
    'multiple_of' => 'Het :attribute moet een veelvoud zijn van :value.',
    'not_in' => 'Het geselecteerd :attribute is ongeldig.',
    'not_regex' => 'Het :attribute formaat is ongeldig.',
    'numeric' => 'Het :attribute moet een getal zijn.',
    'password' => [
        'letters' => 'Het :attribute moet minstens één letter bevatten.',
        'mixed' => 'Het :attribute moet minstens één hoofdletter en één klein letter bevatten.',
        'numbers' => 'Het :attribute moet minstens één getal bevatten.',
        'symbols' => 'Het :attribute moet ten minste één symbool bevatten.',
        'uncompromised' => 'Het opgegeven :attribute is verschenen in een gegevenslek. Kies een ander :attribute.',
    ],
    'present' => 'Het :attribute veld moet aanwezig zijn.',
    'prohibited' => 'Het :attribute veld is verboden.',
    'prohibited_if' => 'Het :attribute veld is verbonen als :other :value is.',
    'prohibited_unless' => 'Het :attribute veld is verboden tenzij :other in :values is.',
    'prohibits' => 'Het :attribute veld verbiedt dat :other aanwezig is.',
    'regex' => 'Het :attribute formaat is ongeldig.',
    'required' => 'Het :attribute veld is vereist.',
    'required_array_keys' => 'Het :attribute veld moet vermeldingen bevatten voor: :values.',
    'required_if' => 'Het :attribute eld is verplicht als :other :value is.',
    'required_if_accepted' => 'Het :attribute veld is verplicht als :other is geaccepteerd.',
    'required_unless' => 'Het :attribute veld is verplicht tenzij :other in :values staat.',
    'required_with' => 'Het :attribute veld is verplicht als :values aanwezig is.',
    'required_with_all' => 'Het :attribute veld is verplicht als hen :values aanwezig zijn.',
    'required_without' => 'Het :attribute veld is verplicht als :values niet aanwezig is.',
    'required_without_all' => 'Het :attribute is vereist als geen van de :values aanwezig is.',
    'same' => 'Het :attribute en :other moeten overeenkomen.',
    'size' => [
        'array' => 'Het :attribute moet :size items bevatten.',
        'file' => 'Het :attribute moet :size kilobytes zijn.',
        'numeric' => 'Het :attribute moet :size zijn.',
        'string' => 'Het :attribute moet :size tekens zijn.',
    ],
    'starts_with' => 'Het :attribute moet beginnen met een van de volgende: :values.',
    'string' => 'Het :attribute moet een string zijn.',
    'timezone' => 'Het :attribute moet een geldige tijdzone zijn.',
    'unique' => 'Het :attribute is al gebruikt.',
    'uploaded' => 'Het :attribute kan niet worden geüpload.',
    'uppercase' => 'Het :attribute moet hoofdletter zijn.',
    'url' => 'Het :attribute moet een geldige URL zijn.',
    'ulid' => 'Het :attribute moet een geldige ULID zijn.',
    'uuid' => 'Het :attribute moet een geldige UUID zijn.',

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
