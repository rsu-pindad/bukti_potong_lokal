@props([
'rootClass' => 'modal fade',
'rootId' => 'exampleModal',
'rootLabel' => 'exampleModalLabel',
'rootTabIndex' => '-1',
'rootAriaHidden' => 'true'
])

<div {{$attributes->merge([
        'class' => $rootClass,
        'id'=> $rootId,
        'aria-labelledby' => $rootLabel,
        'tabindex' => $rootTabIndex,
        'aria-hidden' => $rootAriaHidden
    ])}}>
    {{$slot}}
</div>
