@props([
    'id' => '',
    'class' => 'form-select',
    'name' => ''
])

<select {{$attributes->merge([
    'id' => $id,
    'class' => $class,
    'name' => $name,
    'aria-label' => $id
])}}>
{{$slot}}
</select>