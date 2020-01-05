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

                            <input type="hidden" name="id" value="{{ $publisher->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Chefe da família</label>
                                        <select class="form-control selecthouseholders" id="selecthouseholders" name="householder_id">
                                            <option value="">Selecione se o publicador for dependente de outro publicador</option>
                                            @foreach ($householders as $item)
                                                <option value="{{ $item->id }}"
                                                {{ $publisher->householder_id == $item->id ? 'selected' : ''}}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input name="name" type="text" class="form-control" placeholder="" value="{{ $publisher->name }}" required
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input name="gender" type="radio" value="M" required {{ ($disabled) ? 'disabled' : '' }} {{ $publisher->gender == 'M' ? 'checked' : '' }} >
                                                Masculino
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="gender" type="radio" value="F" required {{ ($disabled) ? 'disabled' : '' }} {{ $publisher->gender == 'F' ? 'checked' : '' }} >
                                                Feminino
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input name="anointed" type="radio" value="1" required {{ ($disabled) ? 'disabled' : '' }} {{ $publisher->anointed == '1' ? 'checked' : '' }} >
                                                Ungido
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="anointed" type="radio" value="0" required {{ ($disabled) ? 'disabled' : '' }} {{ $publisher->anointed == '0' ? 'checked' : '' }} >
                                                Outras ovelhas
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data de nascimento</label>
                                        <input name="birthdate" type="text" class="form-control" data-inputmask="'mask': ['99/99/9999']" data-mask=""
                                        placeholder="" value="{{ ($publisher->birthdate) ? date('d/m/Y', strtotime($publisher->birthdate)) : '' }}" {{ ($disabled)
                                            ? 'disabled' : '' }}>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data de batismo</label>
                                        <input name="baptize_date" type="text" class="form-control" data-inputmask="'mask': ['99/99/9999']" data-mask=""
                                        placeholder="" value="{{ ($publisher->baptize_date) ? date('d/m/Y', strtotime($publisher->baptize_date)) : '' }}" {{ ($disabled)
                                            ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Número de pioneiro (caso já tenha servido)</label>
                                        <input name="pioneer_code" type="text" class="form-control" placeholder="" value="{{ $publisher->pioneer_code }}"
                                            {{ ($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Grupo</label>
                                        <select class="form-control groupSelect selectgroups" id="groupSelect" name="group_id" required>
                                            <option value="">Selecione</option>
                                            @foreach ($groups as $item)
                                                <option value="{{ $item->id }}"
                                                {{ (($publisher->group_id == $item->id)) ? 'selected' : ''}}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Privilégio</label>

                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input name="privilege" type="radio" value="OM" {{ ($disabled) ? 'disabled' : '' }} {{ $publisher->privilege == 'OM' ? 'checked' : '' }} >
                                                Ancião
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="privilege" type="radio" value="MS" {{ ($disabled) ? 'disabled' : '' }} {{ $publisher->privilege == 'MS' ? 'checked' : '' }} >
                                                Servo Ministerial
                                            </label>
                                        </div>
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

        $('.selectgroups').select2();

        $('form').on('submit', function() {

            if(/voltar/g.test(this.action)) return true
            if(/editar/g.test(this.action)) return true
            if(/atender/g.test(this.action)) return true

            // var retorno = false
            // $.ajax({
            //     type: 'POST',
            //     url: '',
            //     data: $('form').serialize(),
            //     async: false,
            //     success: function(data) {
            //         console.log(data)
            //         if(data === "OK") {
            //             retorno = data
            //         } else {
            //             showErrors(data)
            //         }
            //     }
            // })
            // return retorno
            return true
        })

        $('#selectResposta').on('change', function(){
            if($('#selectResposta option:selected').val() == '') {
                $('#taResposta').val('')
            } else {
                $('#taResposta').val($('#selectResposta option:selected').val())
            }
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
