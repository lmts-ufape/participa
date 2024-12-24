@extends('coordenador.detalhesEvento')
@section('menu')
    <div id="divCadastrarAssinatura" class="comissao">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Cadastrar Certificado</h1>
                <h6 class="card-subtitle mb-2 text-muted">Cadastre um novo modelo de certificado</h6>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" x-data="{ verso: false}">
        <form id="formCadastrarCertificado" action="{{route('coord.certificado.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="eventoId" value="{{$evento->id}}">
            <div class="form-row">
                <div class="col-sm-12 form-group">
                    <label for="nome"><b>{{ __('Nome') }}</b></label>
                    <input id="nome" class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" value="{{old('nome')}}" required autofocus autocomplete="nome">

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
                        <input id="local" class="form-control @error('local') is-invalid @enderror" type="text" name="local" value="{{old('local')}}" required autofocus autocomplete="local">
                        @error('local')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="data" ><b>{{ __('Data') }}</b></label>
                    <input id="data" type="date" class="form-control @error('data') is-invalid @enderror" name="data" value="{{ old('data') }}" autocomplete="data" autofocus>
                    @error('data')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-4 form-check form-check pl-4 ml-0">
                    <input x-model="verso" id="verso" type="checkbox" class="form-check-input @error('verso') is-invalid @enderror" name="verso" value="1" {{ old('verso', 'true') ? 'checked="checked"' : '' }} autocomplete="verso" autofocus>
                    <label class="form-check-label" for="verso" ><b>{{ __('Folha de verso') }}</b></label>
                    @error('verso')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-row" >

            </div>
            <div class="form-row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="tipo"><b>{{__('Tipo')}}</b></label>
                            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required onchange="mostrarTags()">
                                <option value="">-- Selecione o tipo do certificado --</option>
                                <option value="{{$tipos['inscrito']}}">Inscrito no evento</option>
                                <option value="{{$tipos['apresentador']}}">Apresentador</option>
                                <option value="{{$tipos['comissao_cientifica']}}">Membro da comissão Científica</option>
                                <option value="{{$tipos['coordenador_comissao_cientifica']}}">Coordenador da Comissão Científica</option>
                                <option value="{{$tipos['comissao_organizadora']}}">Membro da comissão Organizadora</option>
                                <option value="{{$tipos['expositor']}}">Palestrante</option>
                                <option value="{{$tipos['participante']}}">Participante</option>
                                <option value="{{$tipos['revisor']}}">Avaliador</option>
                                <option value="{{$tipos['outras_comissoes']}}">Membro de outra comissão</option>
                                <option value="{{$tipos['inscrito_atividade']}}">Inscrito em uma atividade</option>
                            </select>
                            @error('tipo')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group" id="outrasComissoesDivSelect" style="display: none;">
                            <label for="tipo_comissao_id"><b>{{__('Comissão')}}</b></label>
                            <select name="tipo_comissao_id" id="tipo_comissao_id" class="form-control @error('tipo_comissao_id') is-invalid @enderror">
                                <option value="">-- Selecione a comissão --</option>
                                @foreach ($evento->outrasComissoes as $comissao)
                                    <option value=" {{$comissao->id}} "> {{$comissao->nome}} </option>
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
                                <option value="">-- Selecione uma atividade --</option>
                                <option value="0">Todas as atividades</option>
                                @foreach ($evento->atividade as $atividade)
                                    <option value="{{$atividade->id}}"> {{$atividade->titulo}} </option>
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

                <div class="col-sm-6">
                    <div class="form-group">
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
            </div>
            <div class="form-row">
                <div class="col-sm-12 form-group">
                    <label for="texto"><b>{{ __('Texto') }}</b></label>
                    <textarea id="texto" class="form-control @error('texto') is-invalid @enderror" rows="7" type="text" name="texto" required autofocus autocomplete="texto">{{old('texto')}}</textarea>
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
                        <img id="logo-preview" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="" style="max-width: 80%;">
                    </div>
                    <div style="display: none;">
                        <input type="file" id="logo-input" accept="image/*" class="form-control @error('fotoCertificado') is-invalid @enderror" name="fotoCertificado" onchange="logoPreview(this, 'logo-preview')">
                    </div>
                    <small style="position: relative; top: 5px;">Tamanho recomendado: 1268 x 792;<br>Formato: JPEG, JPG, PNG</small>
                    <br>
                    @error('fotoCertificado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div x-show="verso">
                <div class="form-row" x-data="{ has_imagem_verso: {{old('has_imagem_verso', 'false')}} }">
                    <div class="col-sm-12 form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="has_imagem_verso" name="has_imagem_verso" x-model="has_imagem_verso">
                            <label class="form-check-label" for="has_imagem_verso"><b>Enviar outra imagem para o verso?</b></label>
                        </div>
                        <div x-show="has_imagem_verso">
                            <label class="imagem-loader">
                                <img id="verso-preview" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="" style="max-width: 80%;">
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
            <div class="form-row" x-data="{ imagemassinada: {{old('imagem_assinada', 'false')}} }">
                <div class="col-sm-12 form-group">
                    <div>
                        <label>
                            <input type="checkbox" name="imagem_assinada" x-model="imagemassinada">
                            <b>A imagem do certificado já possui assinaturas?</b>
                        </label>
                    </div>
                    <input type="hidden" class="checkbox_assinatura @error('assinaturas') is-invalid @enderror">
                    <div x-show="!imagemassinada">
                        <div class="row cards-eventos-index">
                            @foreach ($assinaturas as $assinatura)
                                <div class="card" style="width: 16rem;">
                                    <img src="{{asset('storage/'.$assinatura->caminho)}}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-title">
                                                    <div class="row">
                                                        <div class="form-check">
                                                            <input class="checkbox_assinatura" type="checkbox" name="assinaturas[]" value="{{$assinatura->id}}" id="assinatura_{{$assinatura->id}}">
                                                            <label for="assinatura_{{$assinatura->id}}">{{$assinatura->nome}}</label>
                                                        </div>
                                                    </div>
                                                </div>
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
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        {{ __('Cadastrar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
@parent
    <script type="text/javascript">
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
    </script>
@endsection
