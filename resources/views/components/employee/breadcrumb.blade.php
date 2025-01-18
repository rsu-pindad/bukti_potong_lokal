@props([
    'top_page' => '',
    'current_page' => ''
    ])
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{Str::upper($top_page)}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            {{$slot}}
            <li class="breadcrumb-item active" aria-current="page">
                {{$current_page}}
            </li>
        </ol>
    </nav>
</div>