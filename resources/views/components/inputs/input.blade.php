@props([
'type' => 'text',
'id' => '',
'class' => 'form-control',
'name' => '',
'placeholder' => '',
'value' => old($name,''),
'readonly' => false,
])

<input {{$attributes->merge([
    'type' => $type,
    'id' => $id,
    'name' => $name,
    'class' => $class,
    'placeholder' => $placeholder,
    'value' => $value, 
    'readonly' => $readonly
])}}>
