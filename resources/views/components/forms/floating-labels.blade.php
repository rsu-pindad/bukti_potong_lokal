@props([
'class' => 'input-group has-validation',
'name' => '',
'label'=> ''
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="form-floating @error($name) is-invalid @enderror">
        {{$slot}}
        <label for="{{$name}}">{{$label}}</label>
    </div>
    @error($name)
        <div class="invalid-feedback">
        {{$message}}
        </div>
    @enderror
</div>
