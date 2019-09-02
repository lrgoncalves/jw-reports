
<div class="alert alert-warning alert-dismissible" id="confirmWarning" style="display: {{ $display }}">
    {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
    <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
    {{ isset($message) ? $message : '' }}
    <span id="msgWarning"></span>
    <hr>
    <div class="col-12" style="display: inline-flex;">
        <button class="btn btn-primary" onclick="$('#confirmWarning').hide()">Cancelar</button>
        <button class="btn btn-danger" style="margin-left: 10px;" onclick="confirmRemover()">{{ isset($txtButton) ? $txtButton : 'Remover' }}</button>
    </div>
</div>
