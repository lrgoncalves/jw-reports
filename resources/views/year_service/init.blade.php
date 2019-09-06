@extends('adminlte::page')

@section('title', 'year_service List')

@section('content_header')
    <h1>Ano de Serviço</h1>
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
                <div class="row">
                    <div class="col-md-12">
                        <h4>Para iniciar o lançamento de horas você deve cadastrar o Ano de Serviço</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block btn-primary btn-lg" onclick="window.location='{{ url('year_service/new') }}'">
                            Novo Ano de Serviço
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
