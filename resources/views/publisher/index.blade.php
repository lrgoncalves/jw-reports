@extends('adminlte::page')

@section('title', 'publisher List')

@section('content_header')
    <h1>Publicadores</h1>
@stop

@section('content')

@if (session('status'))
@include('components.alerts', ['type'=>'success', 'display'=>'block', 'message'=>session('status')])
@endif

@include('components.confirmwarning', [
    'display'=>'none',
    'message'=>'Tem certeza que deseja remover o publicador? Esse item não será mais listado.'
])

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="window.location='{{ url('publisher/new') }}'">
                        Novo Publicador
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="publisherDataTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px">ID</th>
                                    <th>Nome</th>
                                    <th>Data de batismo</th>
                                    <th style="width: 150px">Ações</th>
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

        $('#publisherDataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "ordering":  false,
            "lengthChange": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('publisher.ajaxData') }}",
            "columns": [
                { "data": "id", "name" : "id" },
                { "data": "name", "name" : "name" },
                { "data": "baptize_date", "name": "baptize_date"},
                { "data": "action" }
            ]
        })
    })

    function remover(id) {
        $('#confirmWarning').show()
        idPartner = id
    }

    function confirmRemover() {
        var url = "{{ route('publisher.delete', 0) }}";
        window.location = url.substring(0, url.length-1) + idPartner;
    }

    function lancar(id) {
        var url = "{{ route('field_service.new', ['pbid' =>0]) }}";
        window.location = url.substring(0, url.length-1) + id;
    }

    function printCard($id) {
        var url = "{{ route('publisher_field_service_report.report') }}";
        url = `${url}/${$id}`;
        window.open(url);
    }

    function endereco(id) {
        var url = "{{ route('publisher_address.new', ['pbid' =>0]) }}";
        window.location = url.substring(0, url.length-1) + id;
    }
</script>
@endpush
