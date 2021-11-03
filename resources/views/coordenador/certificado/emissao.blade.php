@extends('coordenador.detalhesEvento')

@section('menu')
    <div class="row justify-content-center titulo-detalhes">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10">
                    <h1>Emitir certificados</h1>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="row">
            <div class="col-md-12" style="margin-top: 5px;">
                <div class="alert alert-success">
                    <p>{{session('success')}}</p>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="row">
            <div class="col-md-12" style="margin-top: 5px;">
                <div class="alert alert-danger">
                    <p>{{session('error')}}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="container"  style="position: relative;">
        <form id="formEnviarCertificado" action="{{route('coord.enviarCertificado')}}" method="POST" >
            @csrf
            <input type="hidden" name="eventoId" value="{{$evento->id}}">
            <div class="form-row">
                <div class="form-group col-md-12" >
                    <div class="col-sm-12">
                        <br>
                        <h4>Destinatários</h4>
                    </div>
                    <select class="form-control @error('destinatarios') is-invalid @enderror" id="idSelecionarDestinatario" onChange="selecionarDestinatario({{$evento->id}})" name="destinatario">
                        <option value="">-- Selecione os destinatários --</option>
                        @foreach ($destinatarios as $destinatario)
                            @if ($destinatario == "Apresentadores")
                                <option value="1">{{$destinatario}}</option>
                            @elseif($destinatario == "Comissão científica")
                                <option value="2">{{$destinatario}}</option>
                            @elseif($destinatario == "Comissão organizadora")
                                <option value="3">{{$destinatario}}</option>
                            @elseif($destinatario == "Expositor")
                                <option value="6">{{$destinatario}}</option>
                            @elseif($destinatario == "Revisores")
                                <option value="4">{{$destinatario}}</option>
                            @elseif($destinatario == "Participantes")
                                <option value="5">{{$destinatario}}</option>
                            @endif

                        @endforeach
                    </select>

                    @error('destinatario')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <h4>Lista de Distinatários</h4>
                </div>
                <div class="form-row col-md-12">
                    <div style="width:100%; height:250px; display: inline-block; border: 1.5px solid #f2f2f2; border-radius: 2px; overflow:auto;">
                        <table id="tabelaDestinatarios" cellspacing="0" cellpadding="1"width="100%" >
                            <tbody id="dentroTabelaDestinatarios">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 form-group">
                    <br>
                    <div class="col-sm-12">
                        <h4>Certificados</h4>
                    </div>
                    <input type="hidden" class="checkbox_certificado @error('certificado') is-invalid @enderror">
                    <div class="row cards-eventos-index">
                        @foreach ($certificados as $certificado)
                            @can('isCoordenador', $evento)
                                <div class="card" style="height: 10rem; width: 10rem;">
                                    <img class="img-card" src="{{asset('storage/'.$certificado->caminho)}}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5 class="card-title">
                                                    <div class="row">
                                                        <div class="form-check">
                                                            <input class="checkbox_certificado" type="radio" name="certificado" value="{{$certificado->id}}" id="certificado_{{$certificado->id}}">
                                                            {{$certificado->nome}}
                                                        </div>
                                                    </div>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        @endforeach
                    </div>
                    @error('certificados')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary  button-prevent-multiple-submits" style="width:100%">
                        <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> {{ __('Enviar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
<script src="{{ asset('js/checkbox_marcar_todos.js') }}" defer></script>

<script>
    window.selecionarDestinatario = function($eventoId){
        var historySelectList = $('select#idSelecionarDestinatario');
        var $destinatario = $('option:selected', historySelectList).val();
        limparLista();

        $.ajax({
            url:'ajax-listar-destinatarios',
            type:"get",
            data: {"destinatario": $destinatario, "eventoId" : $eventoId},
            dataType:'json',

            complete: function(data) {
                if(data.responseJSON.success){
                    if($destinatario == '1' || $destinatario == '6'){
                        var selectDest = `<hr><div id="destinatarioSelectCard_" class="d-flex justify-content-center">
                                        <div class="form-check">
                                                <input type="checkbox" id="chk_marcar_desmarcar_todos_destinatarios" onclick="marcar_desmarcar_todos_checkbox_por_classe_double(this, 'checkbox_destinatario')">
                                                <label for="btn_marcar_desmarcar_todos_destinatarios"><b>Selecionar todos</b></label>
                                            </div>
                                        </div><hr>`;
                        $('#tabelaDestinatarios tbody').append(selectDest);
                    }else{
                        var selectDest = `<hr><div id="destinatarioSelectCard_" class="d-flex justify-content-center">
                                        <div class="form-check">
                                                <input type="checkbox" id="chk_marcar_desmarcar_todos_destinatarios" onclick="marcar_desmarcar_todos_checkbox_por_classe(this, 'checkbox_destinatario')">
                                                <label for="btn_marcar_desmarcar_todos_destinatarios"><b>Selecionar todos</b></label>
                                            </div>
                                        </div><hr>`;
                        $('#tabelaDestinatarios tbody').append(selectDest);
                    }
                    for(var i = 0; i < data.responseJSON.destinatarios.length; i++){
                        var naLista = document.getElementById('listaDestinatarios');
                        if($destinatario == '1' || $destinatario == '6'){
                            var html = `<hr><div id="destinatarioCard_`+$destinatario+`_`+i+`" class="d-flex justify-content-left">
                                            <div id="destinatarioForm_`+i+`" class="form-check">
                                                <input class="checkbox_destinatario" type="checkbox" name="destinatarios[]" value="`+data.responseJSON.destinatarios[i].id+`" id="destinatario_{{`+i+`}}" onChange="selecionarTrabalho(`+i+`)">
                                                <input style="display: none;" type="checkbox" name="trabalhos[]" value="`+data.responseJSON.trabalhos[i].id+`" id="trabalho_{{`+i+`}}">
                                                <label id="`+data.responseJSON.destinatarios[i].id+`"><strong>`+data.responseJSON.trabalhos[i].titulo+' - '+data.responseJSON.destinatarios[i].name+`</strong> (`+data.responseJSON.destinatarios[i].email+`)</label>
                                            </div>
                                    </div><hr>`;
                            $('#tabelaDestinatarios tbody').append(html);
                        }else{
                            var html = `<hr><div id="destinatarioCard_`+$destinatario+`_`+data.responseJSON.destinatarios[i].id+`" class="d-flex justify-content-left">
                                            <div class="form-check">
                                                <input class="checkbox_destinatario" type="checkbox" name="destinatarios[]" value="`+data.responseJSON.destinatarios[i].id+`" id="destinatario_{{`+data.responseJSON.destinatarios[i].id+`}}">
                                                <label id="`+data.responseJSON.destinatarios[i].id+`"><strong>`+data.responseJSON.destinatarios[i].name+`</strong> (`+data.responseJSON.destinatarios[i].email+`)</label>
                                            </div>
                                    </div><hr>`;
                            if(document.getElementById('destinatarioCard_'+$destinatario+'_'+data.responseJSON.destinatarios[i].id) == null){
                                $('#tabelaDestinatarios tbody').append(html);
                            }
                        }

                    }
                }
            }
        });
    }

    function limparLista() {
        var destinatarios = document.getElementById('tabelaDestinatarios').children[0];
        destinatarios.innerHTML = "";
    }

    function marcar_desmarcar_todos_checkbox_por_classe_double(checkbox_marcar_desmarcar, nome_classe)  {
        let valor_da_marcacao = checkbox_marcar_desmarcar.checked;
        let checkboxes_areas = document.getElementsByClassName(nome_classe);

        for(let checkbox of checkboxes_areas) {
            checkbox.checked = valor_da_marcacao;
            checkbox.parentElement.children[1].checked = valor_da_marcacao;
        }

    }

    function selecionarTrabalho(ele) {
        document.getElementById('destinatarioForm_'+ele).children[1].checked = document.getElementById('destinatarioForm_'+ele).children[0].checked;
    }

</script>
