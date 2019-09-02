@if($type == 'error' || $type == 'all')
<div class="alert alert-danger alert-dismissible" style="display: {{ $display }}">
    {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
    <h4><i class="icon fa fa-ban"></i> Erro! </h4>
    {{ isset($message) ? $message : '' }}
    <span id="msgError"></span>
</div>
@endif

@if($type == 'warning' || $type == 'all')
<div class="alert alert-warning alert-dismissible" style="display: {{ $display }}">
    {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
    <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
    {{ isset($message) ? $message : '' }}
    <span id="msgWarning"></span>
</div>
@endif

@if($type == 'info' || $type == 'all')
<div class="alert alert-info alert-dismissible" style="display: {{ $display }}">
    {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
    <h4><i class="icon fa fa-info"></i> Informação!</h4>
    {{ isset($message) ? $message : '' }}
    <span id="msgInfo"></span>
</div>
@endif

@if($type == 'success' || $type == 'all')
<div class="alert alert-success alert-dismissible" style="display: {{ $display }}">
    {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
    <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
    {{ isset($message) ? $message : '' }}
    <span id="msgSuccess"></span>
</div>
@endif
