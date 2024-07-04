@props([
'rootClass' => 'modal fade',
'rootId' => 'exampleModal',
'rootLabel' => 'exampleModalLabel',
'rootTabIndex' => '-1',
'rootAriaHidden' => 'true'
])
<x-modal.default
    :rootId="$rootId"
    :rootLabel="$rootLabel"
>
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{$rootId}}">{{$rootLabel}}</h1>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
            <div class="modal-footer">
                <x-inputs.button class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </x-inputs.button>
                {{$footer ?? ''}}
            </div>
        </div>
    </div>
</x-modal.default>