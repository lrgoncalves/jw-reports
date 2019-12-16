@extends('adminlte::page')

@section('title', 'publisher edit')

@section('content_header')
<h1>{{ $title }}</h1>
@stop

@section('content')

@include('components.alerts', [
    'type' => 'all',
    'display' => 'none'
    ]
)

<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" action="{{ $action }}">
                            {{csrf_field()}}
                            <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                            <input type="hidden" name="id" value="{{ $publisherAddress->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Publicador</label>
                                        <select class="form-control selecthouseholders" id="selecthouseholders" name="publisher_id">
                                            <option value="">Selecione o publicador</option>
                                            @foreach ($householders as $item)
                                                <option value="{{ $item->id }}"
                                                {{ ($publisherAddress->publisher_id == $item->id  or ($pbid == $item->id))? 'selected' : ''}}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input name="zipcode" id="zipcode" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->zipcode }}" required data-inputmask="'mask': ['99999-999']" data-mask=""
                                        placeholder="" {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input name="address" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->address }}" required
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                         <label>Número</label>
                                        <input name="number" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->number }}" required
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                         <label>Complemento</label>
                                        <input name="address_2" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->address_2 }}" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input name="neighborhood" id="neighborhood" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->neighborhood }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input name="city" id="city" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->city }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input name="state" id="state" type="text" class="form-control" placeholder="" value="{{ $publisherAddress->state }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <button type="reset" class="btn btn-lg btn-block btn-info"  onclick="javascript: history.go(-1);" id="btnVoltar">{{ ($disabled) ? 'Voltar' : 'Cancelar' }}</button>
                                </div>


                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-lg btn-block btn-success">Salvar</button>
                                </div>


                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script src="https://adminlte.io/themes/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
<script>
    $( function() {

        $('[data-mask]').inputmask()

        $('.selecthouseholders').select2();

        $('form').on('submit', function() {

            if(/voltar/g.test(this.action)) return true
            if(/editar/g.test(this.action)) return true
            if(/atender/g.test(this.action)) return true

            return true
        })

        function showErrors(msg) {
            $('.alert').hide()
            $('.alert-danger').show()
            $('#msgError').text(msg)
        }

        let cep = ""
        $('#zipcode').on('keypress', function(e) {
            cep = this.value.replace("-","")
            getAddress(cep)
        })
        $('#getAddress').click(function(){
            if(cep == "") {
                cep = $('#zipcode').val().replace("-","")
                getAddress(cep)
            }
        })

        function getAddress(cep) {
            $.ajax({
                type: 'get',
                url: '//viacep.com.br/ws/'+cep+'/json/',
                async: true,
                success: function(data) {
                    console.log(data)
                    $('[name=address]').val(data.logradouro)
                    $('[name=neighborhood]').val(data.bairro)
                    $('[name=city]').val(data.localidade)
                    $('[name=state]').val(data.uf)
                    $('[name=country]').val("Brasil")
                }
            })
        }
    })

</script>





@endpush
