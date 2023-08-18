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

    'accepted' => ':attribute は受諾されなければなりません。',
    'accepted_if' => ':other が :value　の際、:attribute は受諾されなければなりません。',
    'active_url' => ':attribute は 有効なURLではありません。',
    'after' => ':attribute は　:date　よりも後の日付でなければなりません。',
    'after_or_equal' => ':attribute は　:date　と同日か、後の日付でなければなりません。',
    'alpha' => ':attribute は文字だけでなければなりません。',
    'alpha_dash' => ':attribute はアルファベット、数字、ダッシュ、アンダースコアのみでなければなりません。',
    'alpha_num' => ':attribute は文字と数字だけでなければなりません。',
    'array' => ':attribute は配列でなければなりません。',
    'ascii' => ':attribute　は半角英数字と記号のみでなければなりません。',
    'before' => ':attribute は :date　よりも前の日付でなければなりません。',
    'before_or_equal' => ':attribute は　:date　と同日か、前の日付でなければなりません。',
    'between' => [
        'array' => ':attribute は :min と :max の間でなければなりません。',
        'file' => ':attribute は :min と :max の間のキロバイトでないとなりません。',
        'numeric' => ':attribute は :min と :max の間のでなければなりません。',
        'string' => ':attribute は :min と :max の間の文字数でなければなりません。',
    ],
    'boolean' => ':attribute フィールドはtrueかfalseでなければなりません。',
    'confirmed' => ':attribute 確認が一致しません。',
    'current_password' => 'パスワードが間違っています。',
    'date' => ':attribute は有効な日付ではありません。',
    'date_equals' => ':attribute は :date　と同日でなければなりません。',
    'date_format' => ':attribute は :format　のフォーマットと一致しません。',
    'decimal' => ':attribute は :decimal の小数点以下の桁数でないとなりません。',
    'declined' => ':attribute は辞退しなければなりません。',
    'declined_if' => ':attribute は :other が :value　の時辞退しなければなりません。',
    'different' => ':attribute と :other は違う値でないとなりません。',
    'digits' => ':attribute は :digits 桁でなければなりません。',
    'digits_between' => ':attribute は :min と :max の間の桁でなければなりません。',
    'dimensions' => ':attribute 画像の寸法が無効です。',
    'distinct' => ':attribute フィールドの値が重複しています。',
    'doesnt_end_with' => ':attribute は次のいずれかで終わってはなりません: :values.',
    'doesnt_start_with' => ':attributeは次のいずれかで始まってはなりません。: :values.',
    'email' => ':attribute は有効なメールアドレスでなければなりません。',
    'ends_with' => ':attribute は次のいずれかで終わらなければなりません: :values.',
    'enum' => '選択された :attribute は無効です。',
    'exists' => '選択された :attribute は無効です。',
    'file' => ':attribute はファイルでなければなりません。',
    'filled' => ':attribute フィールドに値がなければなりません。',
    'gt' => [
        'array' => ':attribute は :value よりも多くなければなりません。',
        'file' => ':attribute は :value キロばいつよりも大きくなければなりません。',
        'numeric' => ':attribute は :value　よりも大きくなければなりません。',
        'string' => ':attribute は :value よりも多い文字数でなければなりません。',
    ],
    'gte' => [
        'array' => ':attribute は :value かそれ以上多くないとなりません。',
        'file' => ':attribute は :value かそれ以上大きいキロバイトでなければなりません。',
        'numeric' => ':attribute は :value かそれ以上大きくないとなりません。',
        'string' => ':attribute は :value かそれ以上多い文字数でなければなりません。',
    ],
    'image' => ':attribute は画像でなければなりません。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute フィールドは :other　の中に存在しません。',
    'integer' => ':attribute は整数でなければなりません。',
    'ip' => ':attribute は有効なIPアドレスでなければなりません。',
    'ipv4' => ':attribute は有効なIPv4アドレスでなければなりません。',
    'ipv6' => ':attribute は有効なIPv6アドレスでなければなりません。',
    'json' => ':attribute は有効なJSON文字列でなければなりません。',
    'lowercase' => ':attribute は小文字でなければなりません。',
    'lt' => [
        'array' => ':attribute は :value よりも少なくないとなりません。',
        'file' => ':attribute　は :value よりも少ないキロバイトでなければなりません。',
        'numeric' => ':attribute は :value　よりも小さくないとなりません。',
        'string' => ':attribute は :value よりも少ない文字数でなければなりません。',
    ],
    'lte' => [
        'array' => ':attribute は :value よりも多いとなりません。',
        'file' => ':attribute は :value かそれ以下のキロバイトでなければなりません。',
        'numeric' => ':attribute は :value　かそれ以下でなければなりません。',
        'string' => ':attribute は :value かそれ以下の文字数でないとなりません。',
    ],
    'mac_address' => ':attribute は有効なMACアドレスでなければなりません。',
    'max' => [
        'array' => ':attribute は :max 以上であってはなりません。',
        'file' => ':attribute は :max キロバイト以上であってはなりません。',
        'numeric' => ':attribute は :max　以上であってはなりません。',
        'string' => ':attribute は :max 文字数以上であってはなりません。',
    ],
    'max_digits' => ':attribute は :max 桁以上であってはなりません。',
    'mimes' => ':attribute は以下のファイルタイプでないとなりません: :values.',
    'mimetypes' => ':attribute は以下のファイルタイプでないとなりません: :values.',
    'min' => [
        'array' => ':attribute は少なくとも :min でなければなりません。',
        'file' => ':attribute は少なくとも :min キロバイトでなければなりません。',
        'numeric' => ':attribute は少なくとも :min　でなければなりません。',
        'string' => ':attribute は少なくとも :min 文字数でなければなりません。',
    ],
    'min_digits' => ':attribute は少なくとも :min 桁でなければなりません。',
    'missing' => ':attribute フィールドが欠けていなければなりません。',
    'missing_if' => ':attribute フィールドは　:other が :value　の時に欠けていなければなりません。',
    'missing_unless' => ':attribute フィールドは :other が :value　でない限り欠けていなければなりません。',
    'missing_with' => ':attribute フィールドは :values がある場合欠けていなければなりません。',
    'missing_with_all' => ':attribute フィールドは :values がある場合欠けていなければなりません。',
    'multiple_of' => ':attribute は :value　の倍数でなければなりません。',
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute のフォーマットは無効です。',
    'numeric' => ':attribute は数字でなければなりません。',
    'password' => [
        'letters' => ':attribute には少なくとも1文字が含まれていなければなりません。',
        'mixed' => ':attribute　は少なくとも大文字と小文字を1文字ずつ含まなければなりません。',
        'numbers' => ':attribute には少なくとも1つの数字が含まれていなければなりません。',
        'symbols' => ':attribute には少なくとも1つのシンボルが含まれていなければなりません。',
        'uncompromised' => '指定された :attribute がデータリークに現れました。別の　:attribute　を選択してください。',
    ],
    'present' => ':attribute フィールドは存在しないとなりません。。',
    'prohibited' => ':attribute フィールドは禁止されています。',
    'prohibited_if' => ':attribute フィールドは :other が :value　の時禁止されています。',
    'prohibited_unless' => ':attribute フィールドは :other が :values　の中に含まれていない限り禁止されています。',
    'prohibits' => ':attribute フィールドは :other の存在を禁止しています。',
    'regex' => ':attribute フォーマットは無効です。',
    'required' => ':attribute フィールドは必要です。',
    'required_array_keys' => ':attribute フィールドは、以下のエントリーを含んでいなければなりません: :values.',
    'required_if' => ':attribute フィールドは :other が :value　の場合に必要です。',
    'required_if_accepted' => ':attribute フィールドは :other が受け入れられた場合に必要です。',
    'required_unless' => ':attribute フィールドは :other が :values　に存在する場合に必要です。',
    'required_with' => ':attribute フィールドは :values が存在する場合に必要です。',
    'required_with_all' => ':attribute フィールドは :values が存在する場合に必要です。',
    'required_without' => ':attribute フィールドは :values が存在しない場合に必要です。',
    'required_without_all' => ':attribute フィールドは :values が1つも存在しない場合に必要です。',
    'same' => ':attribute と :other は一致しなければなりません。',
    'size' => [
        'array' => ':attribute は :size のサイズを含まなければなりません。',
        'file' => ':attribute は :size のキロバイトでなければなりません。',
        'numeric' => ':attribute は :size　のサイズでなければなりません。',
        'string' => ':attribute は :size のサイズでないければなりません。',
    ],
    'starts_with' => ':attribute はこれらから始まらないとなりません。: :values.',
    'string' => ':attribute は文字列でなければなりません。',
    'timezone' => ':attribute は有効なタイムゾーンでなければなりません。',
    'unique' => ':attribute は既に使われています。',
    'uploaded' => ' :attribute はアップロードに失敗しました。',
    'uppercase' => ':attribute は大文字でなければなりません。',
    'url' => ':attribute は有効なURLでなければなりません。',
    'ulid' => ':attribute は有効なULIDでなければなりません。',
    'uuid' => ':attribute は有効なUUIDでなければなりません。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name lines. This makes it quick to
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
    | following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
