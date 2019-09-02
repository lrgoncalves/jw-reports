@extends('adminlte::page')

@section('title', 'congregation List')

@section('content_header')
    <h1>Congregações</h1>
@stop

@section('content')

@if (session('status'))
@include('components.alerts', ['type'=>'success', 'display'=>'block', 'message'=>session('status')])
@endif

@include('components.confirmwarning', [
    'display'=>'none',
    'message'=>'Tem certeza que deseja remover a congregação? Esse item não será mais listado.'
])

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="window.location='{{ url('congregation/new') }}'">
                        Nova Congregação
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="congregationDataTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px">ID</th>
                                    <th style="width: 50px">Número</th>
                                    <th>Nome</th>
                                    <th style="width: 110px">Total de publicadores</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script>
    $( function() {
        var idPartner = 0
        $('[data-toggle="tooltip"]').tooltip()

        $('#congregationDataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "ordering":  false,
            "lengthChange": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('congregation.ajaxData') }}",
            "columns": [
                { "data": "id", "name" : "id" },
                { "data": "code", "name" : "code" },
                { "data": "name", "name" : "name" },
                { "data": "action" }
            ]
        })
    })

    function remover(id) {
        $('#confirmWarning').show()
        idPartner = id
    }

    function confirmRemover() {
        window.location = 'congregation/remover/' + idPartner
    }
</script>
@endpush
