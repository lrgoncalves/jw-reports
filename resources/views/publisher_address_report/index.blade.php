@extends('adminlte::page')

@section('title', 'group List')

@section('content_header')
    <h1>Endereço dos Publicadores</h1>
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
                    <a class="btn btn-block btn-primary btn-lg" href="{{ route('publisher_address_report.report') }}" target="_blank">
                        Exportar PDF
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="publisherFieldServiceReportDatatable">
                            <thead>
                                <tr>
                                    <th>Publicador</th>
                                    <th>Grupo</th>
                                    <th style="width: 110px">Ações</th>
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

        $('#publisherFieldServiceReportDatatable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "ordering":  false,
            "lengthChange": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('publisher_address_report.ajaxData') }}",
            "columns": [
                { "data": "name", "name": "name"},
                { "data": "group", "name": "group"},
                { "data": "action" }
            ]
        })
        
    })

    function endereco(id) {
        var url = "{{ route('publisher_address.new', ['pbid' =>0]) }}";
        window.location = url.substring(0, url.length-1) + id;
    }
</script>
@endpush
