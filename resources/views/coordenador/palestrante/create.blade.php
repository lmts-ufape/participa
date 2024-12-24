@extends('coordenador.detalhesEvento')

@section('menu')
    <div id="divCadastrarPalestra" class="comissao" style="display: block">
        <div id="divCadastrarAssinatura" class="comissao">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="titulo-detalhes">Cadastrar Palestras</h1>
                    <h6 class="card-subtitle mb-2 text-muted">Cadastre uma nova palestra para certificação</h6>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <form id="formNovaPalestra"
                    method="POST"
                    action="{{ route('coord.palestrantes.store') }}">
                    @csrf
                    <div class="container">
                        <div class="row form-group">
                            <input type="hidden"
                                name="eventoId"
                                value="{{ $evento->id }}">
                            <div class="col-sm-6">
                                <label for="titulo">Título*:</label>
                                <input class="form-control @error('título') is-invalid @enderror"
                                    type="text"
                                    name="titulo"
                                    id="titulo"
                                    value="{{ old('titulo') }}"
                                    placeholder="Nova palestra"
                                    required>

                                @error('título')
                                    <span class="invalid-feedback"
                                        role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <button id="buttonFecharDadosAdicionais"
                            type="button"
                            class="btn btn-primary"
                            style="background-color: white; color: rgb(41, 109, 211); border-color: rgb(50, 132, 255); @if (old('vagas') != null || old('valor') != null || old('carga_horaria') != null || old('palavrasChaves') != null || old('nomePalestrante') != null || old('emailPalestrante') != null) display: block; @else display: none; @endif"
                            onclick="fecharDadosAdicionais(0)">-Fechar dados opcionais</button>
                        <div id="palestrantesDeUmaPalestra">
                            <div class="row form-group">
                                <div class="container">
                                    <h5>Palestrante</h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="nome">Nome:</label>
                                            <input
                                                class="form-control apenasLetras @error('nomeDoPalestrante[]') is-invalid @enderror"
                                                type="text"
                                                name="nomeDoPalestrante[]"
                                                id="nome"
                                                value="{{ old('nomeDoPalestrante[]') }}"
                                                placeholder="Nome do palestrante">

                                            @error('nomeDoPalestrante[]')
                                                <span class="invalid-feedback"
                                                    role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email">E-mail:</label>
                                            <input
                                                class="form-control @error('emailDoPalestrante[]') is-invalid @enderror"
                                                type="email"
                                                name="emailDoPalestrante[]"
                                                id="email"
                                                value="{{ old('emailDoPalestrante[]') }}"
                                                placeholder="E-mail do palestrante">

                                            @error('emailDoPalestrante[]')
                                                <span class="invalid-feedback"
                                                    role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="buttonNovoPalestrante"
                            class="btn btn-primary"
                            type="button"
                            onclick="adicionarPalestrante(0)">+Adicionar palestrante</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Fechar</button>
                        <button id="submitNovaPalestra"
                            type="submit"
                            class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script>
        var contadorPalestrantes = 1;

        function adicionarPalestrante(id) {
            contadorPalestrantes++;
            if (id == 0) {
                $('#palestrantesDeUmaPalestra').append(
                    "<div id='novoPalestrantePalestra" + contadorPalestrantes + "' class='row form-group'>" +
                    "<div class='container'>" +
                    "<h5>Palestrante</h5>" +
                    "<div class='row'>" +
                    "<div class='col-sm-6'>" +
                    "<label for='nome'>Nome:</label>" +
                    "<input class='form-control apenasLetras' type='text' name='nomeDoPalestrante[]' id='nome'  value='{{ old('nomePalestrante') }}' placeholder='Nome do palestrante'>" +
                    "</div>" +
                    "<div class='col-sm-5'>" +
                    "<label for='email'>E-mail:</label>" +
                    "<input class='form-control' type='email' name='emailDoPalestrante[]' id='email' value='{{ old('emailPalestrante') }}' placeholder='E-mail do palestrante'>" +
                    "</div>" +
                    "<div class='d-flex justify-content-end col-sm-1'>" +
                    "<button type='button' onclick='removerPalestranteNovaPalestra(" + contadorPalestrantes +
                    ")' style='border:none; background-color: rgba(0,0,0,0);'><img src='{{ asset('/img/icons/user-times-solid.svg') }}' width='30px' height='auto'  alt='remover convidade' style='padding-top: 28px;'></button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                )
            } else if (id > 0) {
                $('#palestrantesDeUmaPalestra' + id).append(
                    "<div id='novoPalestrantePalestra" + contadorPalestrantes + "' class='row form-group'>" +
                    "<div class='container'>" +
                    "<h5>Palestrante</h5>" +
                    "<div class='row'>" +
                    "<input type='hidden' name='idPalestrante[]' value='0'>" +
                    "<div class='col-sm-6'>" +
                    "<label for='nome'>Nome:</label>" +
                    "<input class='form-control apenasLetras' type='text' name='nomeDoPalestrante[]' id='nome'  value='{{ old('nomePalestrante') }}' placeholder='Nome do palestrante'>" +
                    "</div>" +
                    "<div class='col-sm-5'>" +
                    "<label for='email'>E-mail:</label>" +
                    "<input class='form-control' type='email' name='emailDoPalestrante[]' id='email' value='{{ old('emailPalestrante') }}' placeholder='E-mail do palestrante'>" +
                    "</div>" +
                    "<div class='d-flex justify-content-end col-sm-1'>" +
                    "<button type='button' onclick='removerPalestranteNovaPalestra(" + contadorPalestrantes +
                    ")' style='border:none; background-color: rgba(0,0,0,0);'><img src='{{ asset('/img/icons/user-times-solid.svg') }}' width='30px' height='auto'  alt='remover convidade' style='padding-top: 28px;'></button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                )
            }
        }

        //Função que remove o palestrante
        function removerPalestranteNovaPalestra(id) {
            contadorPalestrantes--;
            $("#novoPalestrantePalestra" + id).remove();
        }

        //Remover palestrante existente de editar palestra
        function removerPalestrantePalestra(id) {
            $("#palestrantePalestra" + id).remove();
        }
    </script>
@endsection
