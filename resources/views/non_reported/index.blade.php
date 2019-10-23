@extends('adminlte::page')

@section('title', 'publisher List')

@section('content_header')
    <h1>Publicadores</h1>
@stop

@section('content')

@if (session('status'))
@include('components.alerts', ['type'=>'success', 'display'=>'block', 'message'=>session('status')])
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h4><i class="ion ion-funnel"></i> &nbsp;Relatório</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" action="{{ url('non_reported/generate') }}">
                            {{csrf_field()}}
                            <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Grupo</label>
                                    <select class="form-control" id="selectgroups" name="group_id">
                                        <option value="">Selecione</option>
                                        @foreach ($groups as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <input type="submit" class="form-control btn-primary" value="Exportar">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h4><i class="ion ion-funnel"></i> &nbsp;Compilar mês</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" action="{{ url('non_reported/close-month') }}">
                            {{csrf_field()}}
                            <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        Ao clicar em "Executar" os publicadores com relatórios pendentes serão considerados irregulares no mês atual.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <input type="submit" class="form-control btn-primary" value="Executar">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 table-overflow-x">
                        <table class="table table-bordered table-striped dataTable" id="publisherDataTable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Grupo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($irregulars as $i)
                                <tr>
                                    <td>{{ $i->publisher_name }}</td>
                                    <td>{{ $i->group_name }}</td>
                                    <td>
                                        <a class="btn btn-social-icon" data-toggle="tooltip" title="Lançar relatório" onclick="javascript: lancar( {{ $i->id }} );">
                                            <i class="fa fa-clock-o text-black"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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

    })

    function lancar(id) {
        var url = "{{ route('field_service.new', ['pbid' =>0]) }}";
        window.location = url.substring(0, url.length-1) + id;
    }
</script>
@endpush
