@extends('adminlte::page')

@section('title', 'field_service List')

@section('content_header')
    <h1>Serviço de Campo</h1>
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
    <div class="col-md-12">
        <div class="form-group">
            <form action="#">
            <label>Publicador</label>
            <select class="form-control select_publisher" id="select_publisher" name="publisher_id">
                <option value="">Selecione o publicador</option>
                @foreach ($publishers as $item) 
                    <option value="{{ $item->id }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="javascript: novo();">
                        Novo Lançamento
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="field_serviceDataTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px">ID</th>
                                    <th>Nome</th>
                                    <th>Ano</th>
                                    <th>Mês</th>
                                    <th>Colocações</th>
                                    <th>Vídeos</th>
                                    <th>Horas</th>
                                    <th>Revisitas</th>
                                    <th>Estudos</th>
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
    var idPublisher = 0;
    $( function() {

        $('.select_publisher').select2();

        $('.select_publisher').on('select2:select', function (e) {
            var data = e.params.data;


            var route = `{{ route('field_service.ajaxData') }}?pbid=${data.id}`;

            idPublisher = data.id;

            console.log(data.id, route);

            $.ajax({
                type: 'GET',
                url: route,
                async: false,
                success: (data) => {
                    data = JSON.parse(data);
                    dtTable.clear().draw();
                    data.forEach(item => {
                        console.log(item);

                        var html = "";
                        html += '<a class="btn btn-social-icon" data-toggle="tooltip" title="Editar" onclick="javascript: window.location=\'edit/'+item.id+'\'"><i class="fa fa-pencil text-blue"></i></a>';
                        html += '<a class="btn btn-social-icon" data-toggle="tooltip" title="Remover" onclick="javascript: remover('+item.id+')"><i class="fa fa-remove text-red"></i></a>';
                        
                        dtTable.row.add([
                            item.id,
                            item.name,
                            item.year,
                            item.month,
                            item.placements,
                            item.videos,
                            item.hours,
                            item.return_visits,
                            item.studies,
                            html,
                        ]).draw(false);
                    });

                }
            })


        });

        var idPartner = 0
        $('[data-toggle="tooltip"]').tooltip()

        const dtTable = $('#field_serviceDataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "searching": false,
            "ordering": false,
            "paging": false,
            "pageLength": 10,
            "lengthChange": false,
        });

    })

    function remover(id) {
        $('#confirmWarning').show()
        idPartner = id
    }

    function confirmRemover() {
        var url = "{{ route('field_service.delete', 0) }}";
        window.location = url.substring(0, url.length-1) + idPartner;
    }

    function novo() {
        var route = `{{ route('field_service.new') }}`;
        window.location = route;
    }
</script>
@endpush
