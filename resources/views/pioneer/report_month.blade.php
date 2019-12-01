@extends('adminlte::page')

@section('title', 'publisher List')

@section('content_header')
    <h1>Pioneiros auxiliares no mês</h1>
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
                            <div class="form-group">
                                <a href="{{ route('pioneer.auxilizar.reportMonthPrint') }}" target="_blank" rel="noopener noreferrer" class="form-control btn-primary" style="text-align:center;">
                                    Exportar Relatório
                                </a>
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
                                    <th>Requisito</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pioneers as $i)
                                <tr>
                                    <td>{{ $i->publisher->name }}</td>
                                    <td>{{ $i->serviceType->name }}</td>
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
