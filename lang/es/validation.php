<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Líneas de idioma de validación
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma contienen los mensajes de error predeterminados 
    | utilizados por la clase de validación. Algunas de estas reglas tienen múltiples 
    | versiones, como las reglas de tamaño. Siéntete libre de modificar estos 
    | mensajes según sea necesario para tu aplicación.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'accepted_if'          => 'El campo :attribute debe ser aceptado cuando :other sea :value.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un arreglo.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe tener entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'La confirmación de :attribute no coincide.',
    'current_password'     => 'La contraseña es incorrecta.',
    'date'                 => 'El campo :attribute no es una fecha válida.',
    'date_equals'          => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format'          => 'El campo :attribute no coincide con el formato :format.',
    'declined'             => 'El campo :attribute debe ser rechazado.',
    'declined_if'          => 'El campo :attribute debe ser rechazado cuando :other sea :value.',
    'different'            => 'Los campos :attribute y :other deben ser diferentes.',
    'digits'               => 'El campo :attribute debe tener :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'dimensions'           => 'El campo :attribute tiene dimensiones de imagen no válidas.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'ends_with'            => 'El campo :attribute debe terminar con uno de los siguientes valores: :values.',
    'enum'                 => 'El campo :attribute seleccionado es inválido.',
    'exists'               => 'El campo :attribute seleccionado no existe.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'gt'                   => [
        'numeric' => 'El campo :attribute debe ser mayor que :value.',
        'file'    => 'El archivo :attribute debe pesar más de :value kilobytes.',
        'string'  => 'El campo :attribute debe tener más de :value caracteres.',
        'array'   => 'El campo :attribute debe tener más de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => 'El campo :attribute debe ser mayor o igual que :value.',
        'file'    => 'El archivo :attribute debe pesar :value o más kilobytes.',
        'string'  => 'El campo :attribute debe tener :value o más caracteres.',
        'array'   => 'El campo :attribute debe tener :value o más elementos.',
    ],
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute seleccionado no es válido.',
    'in_array'             => 'El campo :attribute debe existir en :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo :attribute debe ser una cadena JSON válida.',
    'lt'                   => [
        'numeric' => 'El campo :attribute debe ser menor que :value.',
        'file'    => 'El archivo :attribute debe pesar menos de :value kilobytes.',
        'string'  => 'El campo :attribute debe tener menos de :value caracteres.',
        'array'   => 'El campo :attribute debe tener menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => 'El campo :attribute debe ser menor o igual que :value.',
        'file'    => 'El archivo :attribute debe pesar :value o menos kilobytes.',
        'string'  => 'El campo :attribute debe tener :value o menos caracteres.',
        'array'   => 'El campo :attribute no debe tener más de :value elementos.',
    ],
    'mac_address'          => 'El campo :attribute debe ser una dirección MAC válida.',
    'max'                  => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'file'    => 'El archivo :attribute no debe pesar más de :max kilobytes.',
        'string'  => 'El campo :attribute no debe tener más de :max caracteres.',
        'array'   => 'El campo :attribute no debe tener más de :max elementos.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
        'array'   => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'multiple_of'          => 'El campo :attribute debe ser múltiplo de :value.',
    'not_in'               => 'El campo :attribute seleccionado no es válido.',
    'not_regex'            => 'El formato del campo :attribute no es válido.',
    'numeric'              => 'El campo :attribute debe ser un número.',
    'password'             => [
        'letters'       => 'El campo :attribute debe contener al menos una letra.',
        'mixed'         => 'El campo :attribute debe contener al menos una letra mayúscula y una minúscula.',
        'numbers'       => 'El campo :attribute debe contener al menos un número.',
        'symbols'       => 'El campo :attribute debe contener al menos un símbolo.',
        'uncompromised' => 'El valor proporcionado en el campo :attribute ha aparecido en una filtración de datos. Por favor, elige un :attribute diferente.',
    ],
    'present'              => 'El campo :attribute debe estar presente.',
    'prohibited'           => 'El campo :attribute está prohibido.',
    'prohibited_if'        => 'El campo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless'    => 'El campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits'            => 'El campo :attribute prohíbe que :other esté presente.',
    'regex'                => 'El formato del campo :attribute no es válido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_array_keys'  => 'El campo :attribute debe contener entradas para: :values.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los valores :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'string'  => 'El campo :attribute debe tener :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size elementos.',
    ],
    'starts_with'          => 'El campo :attribute debe comenzar con uno de los siguientes valores: :values.',
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El campo :attribute debe ser una zona horaria válida.',
    'unique'               => 'El valor del campo :attribute ya está en uso.',
    'uploaded'             => 'El archivo :attribute no se pudo subir.',
    'url'                  => 'El campo :attribute debe ser una URL válida.',
    'uuid'                 => 'El campo :attribute debe ser un UUID válido.',

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

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de contraseña',
        'current_password' => 'contraseña actual',
        'birth_date' => 'fecha de nacimiento',
        'species' => 'especie',
        'breed' => 'raza',
        'gender' => 'género',
        'description' => 'descripción',
        'sterilized' => 'esterilizado',
        'conditions' => 'padecimientos',
        'treatments' => 'tratamientos',
    ],
];
