
<div class="alert alert-warning alert-dismissible" id="confirmNonIrregular" style="display: {{ $display }}">
    <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
    
    <p>
        <strong>O campo horas está vazio. O publicador deu testemunho?</strong>
    </p>


    <span id="msgWarning">
        Caso o publicador não tenha dado testemunho clique no botão "Irregular" no final do formulário
    </span>

    <hr>
    <div class="col-12" style="display: inline-flex;">
        <button class="btn btn-default  " onclick="$('#confirmNonIrregular').hide()">Cancelar</button>
        <button class="btn btn-primary btn-confirmNonIrregular-confirm" style="margin-left: 10px;">{{ isset($txtButton) ? $txtButton : 'Sim' }}</button>
    </div>
</div>
