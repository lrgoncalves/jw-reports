@extends('adminlte::page')

@section('title', 'pioneer List')

@section('content_header')
    <h1>Pioneiros</h1>
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
                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="window.location='{{ url('pioneer/new') }}'">
                        Novo Pioneiro
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="pioneerDataTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px">ID</th>
                                    <th>Pioneiro</th>
                                    <th>Privilégio</th>
                                    <th>Início</th>
                                    <th>Fim</th>
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
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $( function() {
        var idPartner = 0
        $('[data-toggle="tooltip"]').tooltip()

        $('#pioneerDataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                'csv'
            ],
            "ordering":  false,
            "lengthChange": false,
            "processing": true,
            "serverSide": false,
            "ajax": "{{ $ajaxDataRoute }}",
            "columns": [
                { "data": "id", "name" : "id" },
                { "data": "publisher_name", "name" : "publisher_name" },
                { "data": "service_type", "name": "service_type"},
                { "data": "start_at", "name": "start_at"},
                { "data": "finish_at", "name": "finish_at"},
                { "data": "action" }
            ]
        })
    })

    function remover(id) {
        $('#confirmWarning').show()
        idPartner = id
    }

    function confirmRemover() {
        var url = "{{ route('pioneer.delete', 0) }}";
        window.location = url.substring(0, url.length-1) + idPartner;
    }
</script>
@endpush
