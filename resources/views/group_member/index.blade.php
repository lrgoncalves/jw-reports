@extends('adminlte::page')

@section('title', 'group_member List')

@section('content_header')
    <h1>Membros de Grupos</h1>
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
                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="window.location='{{ url('group_member/new') }}'">
                        Novo Membro de Grupo
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="group_memberDataTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px">ID</th>
                                    <th>Grupo</th>
                                    <th>Membro</th>
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

        $('#group_memberDataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "ordering":  false,
            "lengthChange": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('group_member.ajaxData') }}",
            "columns": [
                { "data": "id", "name" : "id" },
                { "data": "group_name", "name" : "group_name" },
                { "data": "publisher_name", "name": "publisher_name"},
                { "data": "action" }
            ]
        })
    })

    function remover(id) {
        $('#confirmWarning').show()
        idPartner = id
    }

    function confirmRemover() {
        var url = "{{ route('group_member.delete', 0) }}";
        window.location = url.substring(0, url.length-1) + idPartner;
    }
</script>
@endpush
