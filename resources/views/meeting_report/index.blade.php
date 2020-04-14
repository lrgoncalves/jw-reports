@extends('adminlte::page')

@section('title', 'group List')

@section('content_header')
    <h1>Relatório de Assistência às Reuniões (S-88)</h1>
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
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="publisherFieldServiceReportDatatable">
                            <thead>
                                <tr>
                                    <th>Ano de serviço</th>
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
            "ajax": "{{ route('meeting_report.ajaxData') }}",
            "columns": [
                { "data": "year", "name": "year"},
                { "data": "action" }
            ]
        })
    })
</script>
@endpush
