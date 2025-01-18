@props([
'type' => 'button',
'class' => 'btn',
])

<button {{ $attributes->merge([
    'class' => $class,
    'type' => $type 
    ]) }}
    >
    {{$slot}}
</button>