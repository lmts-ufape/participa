@extends('coordenador.detalhesEvento')

@section('menu')

<style>
    #texto {
        height: 100px;
    }

</style>
    <div id="divCadastrarAssinatura" class="comissao">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Editar Certificado</h1>
                <h6 class="card-subtitle mb-2 text-muted">Edite um modelo de certificado</h6>
            </div>
        </div>
    </div>

    <div class="row justify-content-center" x-data="{verso: {{old('verso', $certificado->verso ? 'true' : 'false')}}}">
        <form id="formCadastrarCertificado" action="{{route('coord.certificado.update', ['id' => $certificado->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="eventoId" value="{{$evento->id}}">
            <div class="form-row">
                <div class="col-sm-12 form-group">
                    <label for="nome"><b>{{ __('Nome') }}</b></label>
                    <input id="nome" class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" value="{{old('nome')!=null ? old('nome') : $certificado->nome}}" required autofocus autocomplete="nome">

                    @error('nome')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="local"><b>{{ __('Local') }}</b></label>
                        <input id="local" class="form-control @error('local') is-invalid @enderror" type="text" name="local" value="{{old('local')!=null ? old('local') : $certificado->local}}" required autofocus autocomplete="local">
                        @error('local')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="data" ><b>{{ __('Data') }}</b></label>
                    <input id="data" type="date" class="form-control @error('data') is-invalid @enderror" name="data" value="@if(old('data')!=null){{old('data')}}@else{{date('Y-m-d',strtotime($certificado->data))}}@endif"  autocomplete="data" autofocus autocomplete="data">
                    @error('data')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-sm-4 form-check form-check pl-4 ml-0">
                    <input id="verso" type="checkbox" class="form-check-input @error('verso') is-invalid @enderror" name="verso" x-model="verso">
                    <label class="form-check-label" for="verso" ><b>{{ __('Folha de verso') }}</b></label>
                    @error('verso')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="tipo"><b>{{__('Tipo')}}</b></label>
                            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required onchange="mostrarTags()">
                                @foreach($tipos as $key => $tipo)
                                    <option @if($certificado->tipo == $key) selected @endif value="{{$key}}">{{$tipo}}</option>
                                @endforeach
                            </select>
                            @error('tipo')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-12 form-group" id="outrasComissoesDivSelect" style="display: none;">
                            <label for="tipo_comissao_id"><b>{{__('Comissão')}}</b></label>
                            <select name="tipo_comissao_id" id="tipo_comissao_id" class="form-control @error('tipo_comissao_id') is-invalid @enderror">
                                @foreach ($evento->outrasComissoes as $comissao)
                                    <option @if ($certificado->tipo_comissao_id == $comissao->id) selected @endif  value="{{$comissao->id}}"> {{$comissao->nome}} </option>
                                @endforeach
                            </select>
                            @error('tipo_comissao_id')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group" id="atividadeDivSelect" style="display: none;">
                            <label for="atividade_id"><b>{{__('Atividade')}}</b></label>
                            <select name="atividade_id" id="atividade_id" class="form-control @error('atividade_id') is-invalid @enderror">
                                <option @if ($certificado->atividade_id == null) selected @endif value="0">Todas as atividades</option>
                                @foreach ($evento->atividade as $atividade)
                                    <option @if ($certificado->atividade_id == $atividade->id) selected @endif value="{{$atividade->id}}"> {{$atividade->titulo}} </option>
                                @endforeach
                            </select>
                            @error('atividade_id')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="tags"><b>{{ __('Tags que podem ser utilizadas para recuperar informações no certificado:') }}</b></label>
                    <p style="display: none;" id="tagNOME_PESSOA">%NOME_PESSOA% para preencher o nome da pessoa que está sendo certificada</p>
                    <p style="display: none;" id="tagAUTOR">%AUTOR% para preencher o nome do autor principal do trabalho</p>
                    <p style="display: none;" id="tagCPF">%CPF% para preencher o CPF da pessoa que está sendo certicidada</p>
                    <p style="display: none;" id="tagTITULO_TRABALHO">%TITULO_TRABALHO% para preencher o título do trabalho do autor ou coautor</p>
                    <p style="display: none;" id="tagNOME_EVENTO">%NOME_EVENTO% para preencher o nome do evento</p>
                    <p style="display: none;" id="tagTITULO_PALESTRA">%TITULO_PALESTRA% para preencher o título da palestra do palestrante</p>
                    <p style="display: none;" id="tagNOME_COMISSAO">%NOME_COMISSAO% para preencher o nome da comissão</p>
                    <p style="display: none;" id="tagNOME_ATIVIDADE">%NOME_ATIVIDADE% para preencher o nome da atividade</p>
                    <p style="display: none;" id="tagCARGA_HORARIA">%CARGA_HORARIA% para preencher a carga horária da atividade</p>
                    <p style="display: none;" id="tagCOAUTORES">%COAUTORES% para preencher o nome dos coautores</p>
                    <p style="display: none;" id="tagMSG_COAUTORES">%MSG_COAUTORES=aqui vai a sua mensagem, se o trabalho tiver coautores% para preencher uma mensagem</p>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 form-group">
                    <label for="texto"><b>{{ __('Texto') }}</b></label>
                    <textarea id="texto" class="form-control @error('texto') is-invalid @enderror" type="text" name="texto" required autofocus autocomplete="texto">{{$certificado->texto}}</textarea>
                    @error('texto')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 form-group">
                    <label for="fotoCertificado"><b>Imagem do Certificado</b></label>
                    <div id="imagem-loader" class="imagem-loader">
                        @if ($certificado->caminho != null)
                            <img id="logo-preview" class="img-fluid" src="{{asset('storage/'.$certificado->caminho)}}" alt="">
                        @else
                            <img id="logo-preview" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="">
                        @endif
                    </div>
                    <div style="display: none;">
                        <input type="file" id="logo-input" accept="image/*" class="form-control @error('fotoCertificado') is-invalid @enderror" name="fotoCertificado" onchange="logoPreview(this, 'logo-preview')">
                    </div>
                    <small style="position: relative; top: 5px;">Tamanho mínimo: 1268 x 792;<br>Formato: JPEG, JPG, PNG</small>
                    <br>
                    @error('fotoCertificado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div x-show="verso">
                <div class="form-row" x-data="{ has_imagem_verso: {{old('has_imagem_verso', $certificado->has_imagem_verso ? 'true' : 'false')}} }">
                    <div class="col-sm-12 form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="has_imagem_verso" name="has_imagem_verso" x-model="has_imagem_verso">
                            <label class="form-check-label" for="has_imagem_verso"><b>Enviar outra imagem para o verso?</b></label>
                        </div>
                        <div x-show="has_imagem_verso">
                            <label class="imagem-loader">
                                @if ($certificado->imagem_verso != null)
                                    <img id="verso-preview" class="img-fluid" src="{{asset('storage/'.$certificado->imagem_verso)}}" alt="">
                                @else
                                    <img id="verso-preview" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="">
                                @endif
                                <input hidden type="file" accept="image/*" class="form-control @error('imagem_verso') is-invalid @enderror" name="imagem_verso" onchange="logoPreview(this, 'verso-preview')">
                            </label>
                            <div>
                                <small style="position: relative; top: 5px;">Tamanho recomendado: 1268 x 792;<br>Formato: JPEG, JPG, PNG</small>
                                <br>
                                @error('imagemVerso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row" x-data="{ imagemassinada: {{$certificado->imagem_assinada ? 'true' : 'false'}} }">
                <div class="col-sm-12 form-group">
                    <div>
                        <label>
                            <input type="checkbox" name="imagem_assinada" x-model="imagemassinada">
                            <b>A imagem do certificado já possui assinaturas?</b>
                        </label>
                    </div>
                    <input type="hidden" class="checkbox_assinatura @error('assinaturas') is-invalid @enderror">
                    <div class="row cards-eventos-index" x-show="!imagemassinada">
                        @foreach ($assinaturas as $assinatura)
                            <div class="card" style="width: 16rem;">
                                <img src="{{asset('storage/'.$assinatura->caminho)}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 class="card-title">
                                                <div class="row">
                                                    <div class="form-check">
                                                        <input class="checkbox_assinatura" type="checkbox" name="assinaturas[]" value="{{$assinatura->id}}" id="assinatura_{{$assinatura->id}}" {{ in_array($assinatura->id, old('assinaturas', $certificado->assinaturas->pluck('id')->all())) ? 'checked' : '' }}>
                                                        <label for="assinatura_{{$assinatura->id}}">{{$assinatura->nome}}</label>
                                                    </div>
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('assinaturas')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        {{ __('Editar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('javascript')
    @parent
    <script type="text/javascript" >
        CKEDITOR.replace('texto');
        function logoPreview(input, id) {
            $('#' + id).attr('src', window.URL.createObjectURL(input.files[0]))
        }
        $('#imagem-loader').click(function() {
            $('#logo-input').click()
        });
        function esconderTags() {
            $("#tagCPF").hide();
            $("#tagTITULO_TRABALHO").hide();
            $("#tagCOAUTORES").hide();
            $("#tagMSG_COAUTORES").hide();
            $("#tagTITULO_PALESTRA").hide();
            $("#tagNOME_COMISSAO").hide();
            $("#outrasComissoesDivSelect").hide();
            $("#tagNOME_ATIVIDADE").hide();
            $("#atividadeDivSelect").hide();
            $("#tagCARGA_HORARIA").hide();
        }
        function mostrarTags() {
            $("#tagNOME_PESSOA").show();
            $("#tagNOME_EVENTO").show();
            switch($("#tipo").val()){
                case '1':
                    esconderTags();
                    $("#tagAUTOR").show();
                    $("#tagCPF").show();
                    $("#tagTITULO_TRABALHO").show();
                    $("#tagCOAUTORES").show();
                    $("#tagMSG_COAUTORES").show();
                    break;
                case '2':
                case '3':
                case '4':
                case '5':
                case '7':
                case '10':
                    esconderTags();
                    $("#tagCPF").show();
                    break;
                case '6':
                    esconderTags();
                    $("#tagTITULO_PALESTRA").show();
                    break;
                case '8':
                    esconderTags();
                    $("#tagCPF").show();
                    $("#tagNOME_COMISSAO").show();
                    $("#outrasComissoesDivSelect").show();
                    break;
                case '9':
                    esconderTags();
                    $("#tagCPF").show();
                    $("#tagNOME_ATIVIDADE").show();
                    $("#atividadeDivSelect").show();
                    $("#tagCARGA_HORARIA").show();
                    break;
            }
        }
        mostrarTags();
    </script>
@endsection
