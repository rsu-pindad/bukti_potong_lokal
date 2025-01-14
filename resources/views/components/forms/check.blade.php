@props([
'class'=> '',
'labelClass' => '',
'labelId' => '',
'caption' => '',
])
<div {{$attributes->merge([
    'class' => 'form-check'.$class,
    ])}}>
    {{$slot}}
    <label {{$attributes->merge([
        'class' => 'form-check-label'.$labelClass,
        'for' => $labelId
        ])}}>
        <span>
            {{$caption}}
        </span>
    </label>
</div>
