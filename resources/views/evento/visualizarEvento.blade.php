@extends('layouts.app')
@section('content')



@foreach ($atividades as $atv)
<div class="modal fade bd-example modal-show-atividade" id="modalAtividadeShow{{ $atv->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabelAtividadeShow{{ $atv->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #114048ff; color: white;">
                <h5 class="modal-title" id="modalLabelAtividadeShow{{ $atv->id }}">{{ $atv->titulo }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 for="tipo">{{__("Tipo")}}</h4>
                            <p>
                                {{ $atv->tipoAtividade->descricao }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="descricao">{{ __("Descrição") }}</label>
                            <p>
                                {!! $atv->descricao !!}
                            </p>
                        </div>

                    </div>
                    @if (count($atv->convidados) > 0)
                    <hr>
                    <h4>{{__("Convidados")}}</h4>
                    <div class="convidadosDeUmaAtividade">
                        <div class="row">
                            @foreach ($atv->convidados as $convidado)
                            <div class="col-sm-3 imagemConvidado">
                                <img src="{{ asset('img/icons/user.png') }}" alt="Foto de {{ $convidado->nome }}" width="50px" height="auto">
                                <h5 class="convidadoNome">{{ $convidado->nome }}</h5>
                                <small class="convidadoFuncao">{{ $convidado->funcao }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 for="local">{{__("Local")}}</h4>
                            <p class="local">
                                {{ $atv->local }}
                            </p>
                        </div>
                    </div>
                    @if ($atv->vagas != null || $atv->valor != null)
                    <hr>
                    <div class="row">
                        @if ($atv->vagas != null)
                        <div class="col-sm-6">
                            <label for="vagas">{{__("Vagas")}}:</label>
                            <h4 class="vagas">{{ $atv->vagas }}</h4>
                        </div>
                        @endif
                        @if ($atv->valor != null)
                        <div class="col-sm-6">
                            <label for="valor">{{__("Valor")}}:</label>
                            <h4 class="valor">R$ {{ $atv->valor }}</h4>
                        </div>
                        @endif
                    </div>
                    @endif
                    @if ($atv->carga_horaria != null)
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="carga_horaria">{{__("Carga horária para estudantes")}}:</label>
                            <h4 class="carga_horaria">{{ $atv->carga_horaria }}</h4>
                        </div>
                    </div>
                    @endif
                    @if($atv->valor != null)
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="comprovante" class="">Comprovante de pagamento da taxa de inscrição</label><br>
                            <input type="file" id="comprovante" class="form-control-file" name="comprovante">
                            <br>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                @if ($isInscrito)
                @if(!$atv->atividadeInscricoesEncerradas())
                @if(($atv->vagas > 0 || $atv->vagas == null) && Auth::user()->atividades()->find($atv->id) == null)
                <form method="POST" action="{{route('atividades.inscricao', ['id'=>$atv->id])}}">
                    @csrf
                    <button type="submit" class="button-prevent-multiple-submits btn btn-primary">
                        {{__("Inscrever-se")}}</button>
                </form>
                @elseif(Auth::user()->atividades()->find($atv->id) != null)
                @if (!$atv->terminou())
                <form method="POST" action="{{route('atividades.cancelarInscricao', ['id'=>$atv->id, 'user'=> Auth::id()])}}">
                    @csrf
                    <button type="submit" class="btn btn-primary button-prevent-multiple-submits">
                        {{__("Cancelar inscrição")}}</button>
                </form>
                @else
                <button type="button" class="btn btn-primary" disabled>{{__("Inscrito")}}</button>
                @endif
                @else
                <button type="button" class="btn btn-danger" style="pointer-events: none">{{__("Sem Vagas")}}</button>
                @endif
                @else
                @if(Auth::user()->atividades()->find($atv->id) != null)
                <button type="button" class="btn btn-primary" disabled>{{__("Inscrito")}}</button>
                @else
                <button type="button" class="btn btn-danger" disabled>{{__("Inscrições encerradas")}}</button>
                @endif
                @endif
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Fechar")}}</button>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="modal fade" id="modalTrabalho" tabindex="-1" role="dialog" aria-labelledby="modalTrabalho" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{__("Submeter nova versão")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('trabalho.novaVersao') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                            @if ($hasFile)
                            <input type="hidden" name="trabalhoId" value="" id="trabalhoNovaVersaoId">
                            @endif
                            <input type="hidden" name="eventoId" value="{{ $evento->id }}">
                            {{-- Arquivo --}}
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Arquivo') }}</label>
                            <div class="custom-file">
                                <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivo">
                            </div>
                            <small>{{__("O arquivo Selecionado deve ser no formato PDF de até 2mb")}}.</small>
                            @error('arquivo')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Fechar")}}</button>
                    <button type="submit" class="btn btn-primary">{{__("Salvar")}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@php
    $bannerPath = $evento->is_multilingual && Session::get('idiomaAtual') === 'en' && $evento->fotoEvento_en ? $evento->fotoEvento_en : $evento->fotoEvento;
@endphp
<div class="banner-evento">
    <div class="row">
        @if (isset($evento->fotoEvento))
            <div class="banner-evento">
                <img style="background-size: cover" src="{{ asset('storage/' . $bannerPath) }}" alt="">
            </div>
        @else
            <div class="banner-evento">
                <img style="background-size: cover" src="{{ asset('img/colorscheme.png') }}" alt="">
            </div>
            {{-- <img class="front-image-evento" src="{{asset('img/colorscheme.png')}}" alt=""> --}}
        @endif
    </div>
</div>

<br>

<div class="modal fade" id="modalInscrever" tabindex="-1" role="dialog" aria-labelledby="#label" aria-hidden="true">
    <div class="modal-dialog @if($evento->possuiFormularioDeInscricao()) modal-lg @endif" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #114048ff; color: white;">
                @if(auth()->check())
                <h5 class="modal-title" id="#label">{{__("Confirmação")}}</h5>
                @else
                <h5 class="modal-title" id="#label">{{__("Atenção")}}!</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('inscricao.inscrever', ['evento_id' => $evento->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if(!auth()->check())
                    @include('componentes.mensagens')
                    <p class="text-justify">{!! __("Para continuar com sua inscrição, é necessário que possua cadastro na plataforma e realize o seu acesso (login). <strong>Caso já possua uma conta</strong>, basta acessar com o seu login (e-mail) e senha.") !!} <br><br>
                                            {!! __("<strong>Se você ainda não tem</strong>, será necessário efetuar o cadastro, validar sua conta pelo link enviado para o e-mail e retornar a página do evento para realizar sua inscrição.") !!} <br><br>
                                            {!! __("Após realizar seu login ou cadastro, retorne a esta página, atualize-a (pressionando a tecla F5) e prossiga com sua inscrição no evento.") !!}
                    </p>
                    <div class="modal-footer text-center">
                        <a href="{{ route('register', app()->getLocale()) }}" target="_blank">
                            <button type="button" class="btn btn-secondary">{{ __('Cadastrar-se') }}</button>
                        </a>

                        <a href="{{ route('login') }}" target="_blank">
                            <button type="button" class="btn btn-primary button-prevent-multiple-submits">{{ __('Entrar') }}</button>
                        </a>
                    </div>
                    @elseif ($evento->categoriasParticipantes()->where('permite_inscricao', true)->exists())
                    <div id="formulario" x-data="{ categoria: '' }" class="carousel-categorias container">
                        <div>
                            <div x-show="categoria == ''">
                                <div class="carousel slide" id="carouselCategorias" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <input type="hidden" name="categoria" x-model="categoria" required>
                                        <div class="row justify-content-center mb-2 mt-2">
                                            <a class="btn btn-outline-primary mx-1" id="categoriaAnterior" href="#carouselCategorias" title="Previous" role="button" data-slide="prev">
                                                <i class="fa fa-lg fa-chevron-left"></i>
                                            </a>
                                            <a class="btn btn-outline-primary mx-1" id="proximaCategoria" href="#carouselCategorias" title="Next" role="button" data-slide="next">
                                                <i class="fa fa-lg fa-chevron-right"></i>
                                            </a>
                                        </div>
                                        <div class="card-group">
                                            @foreach ($evento->categoriasQuePermitemInscricao as $categoria)

                                            <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="my-0 font-weight-normal">{{ $categoria->nome }}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <label for="">{{__("Descrição")}}: </label>
                                                            <p> {!! $categoria->descricao !!}</p>

                                                            @if($links)
                                                            @foreach($links->where('categoria_id', $categoria->id) as $link)
                                                                <label for="">Valor: </label>
                                                                <p>R${{$link->valor}}</p>
                                                                <label for="">Link para pagamento: </label>
                                                                <a href="{{$link->link}}">{{$link->link}}</a>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="btn btn-md btn-block btn-outline-primary" x-on:click="categoria = {{ $categoria->id }}">
                                                                {{ __('Selecionar') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-show="categoria != ''">
                            @foreach($evento->categoriasParticipantes as $categoria)
                            <div x-data="{id: {{$categoria->id}}}">
                                <template x-if="categoria == id">
                                    <div class="campos-extras" id="campos-extras-{{$categoria->id}}">
                                        <div>
                                            <div class="form-group">
                                                <label>{{__("Categoria selecionada")}}</label>
                                                <input type="text" readonly class="form-control" value="{{ $categoria->nome }}">
                                                <button type="button" x-on:click="categoria = ''" class="btn btn-md btn-block btn-primary mt-2 col-sm-12 col-md-6 col-lg-4">
                                                    {{__("Alterar categoria")}}</button>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label for="">Link</label>
                                                <input type="text" readonly class="form-control" value="teste">
                                            </div> -->

                                            @foreach ($categoria->camposNecessarios()->distinct()->orderBy('tipo')->get() as $campo)
                                            @if($campo->tipo == "endereco")
                                            <div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label for="endereco-cep-{{$campo->id}}">{{__("CEP")}}</label>
                                                        <input id="endereco-cep-{{$campo->id}}" name="endereco-cep-{{$campo->id}}" onblur="pesquisacep(this.value, '{{$campo->id}}');" type="text" class="form-control cep @error('endereco-cep-'.$campo->id) is-invalid @enderror" placeholder="00000-000" @if($campo->obrigatorio) required @endif value="@if(old('endereco-cep-'.$campo->id) != null){{old('endereco-cep-'.$campo->id)}}@endif">
                                                        @error('endereco-cep-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label for="endereco-bairro-{{$campo->id}}">{{__("Bairro")}}</label>
                                                        <input type="text" class="form-control @error('endereco-bairro-'.$campo->id) is-invalid @enderror" id="endereco-bairro-{{$campo->id}}" name="endereco-bairro-{{$campo->id}}" placeholder="" @if($campo->obrigatorio) required @endif value="@if(old('endereco-bairro-'.$campo->id) != null){{old('endereco-bairro-'.$campo->id)}}@endif">
                                                        @error('endereco-bairro-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-9">
                                                        <label for="endereco-rua-{{$campo->id}}">{{__("Rua")}}</label>
                                                        <input type="text" class="form-control @error('endereco-rua-'.$campo->id) is-invalid @enderror" id="endereco-rua-{{$campo->id}}" name="endereco-rua-{{$campo->id}}" placeholder="" @if($campo->obrigatorio) required @endif value="@if(old('endereco-rua-'.$campo->id) != null){{old('endereco-rua-'.$campo->id)}}@endif">
                                                        @error('endereco-rua-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="endereco-complemento-{{$campo->id}}">{{__("Complemento")}}</label>
                                                        <input type="text" class="form-control @error('endereco-complemento-'.$campo->id) is-invalid @enderror" id="endereco-complemento-{{$campo->id}}" name="endereco-complemento-{{$campo->id}}" placeholder="" @if($campo->obrigatorio) required @endif value="@if(old('endereco-complemento-'.$campo->id) != null){{old('endereco-complemento-'.$campo->id)}}@endif">
                                                        @error('endereco-complemento-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label for="endereco-cidade-{{$campo->id}}">{{__("Cidade")}}</label>
                                                        <input type="text" class="form-control @error('endereco-cidade-'.$campo->id) is-invalid @enderror" id="endereco-cidade-{{$campo->id}}" name="endereco-cidade-{{$campo->id}}" placeholder="" @if($campo->obrigatorio) required @endif value="@if(old('endereco-cidade-'.$campo->id) != null){{old('endereco-cidade-'.$campo->id)}}@endif">
                                                        @error('endereco-cidade-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="endereco-uf-{{$campo->id}}">UF</label>
                                                        <select class="form-control @error('endereco-uf-'.$campo->id) is-invalid @enderror" id="endereco-uf-{{$campo->id}}" name="endereco-uf-{{$campo->id}}" @if($campo->obrigatorio) required @endif>
                                                            <option value="" disabled selected hidden>-- UF --</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "AC") selected @endif value="AC">AC</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "AL") selected @endif value="AL">AL</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "AP") selected @endif value="AP">AP</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "AM") selected @endif value="AM">AM</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "BA") selected @endif value="BA">BA</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "CE") selected @endif value="CE">CE</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "DF") selected @endif value="DF">DF</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "ES") selected @endif value="ES">ES</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "GO") selected @endif value="GO">GO</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "MA") selected @endif value="MA">MA</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "MT") selected @endif value="MT">MT</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "MS") selected @endif value="MS">MS</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "MG") selected @endif value="MG">MG</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "PA") selected @endif value="PA">PA</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "PB") selected @endif value="PB">PB</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "PR") selected @endif value="PR">PR</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "PE") selected @endif value="PE">PE</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "PI") selected @endif value="PI">PI</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "RJ") selected @endif value="RJ">RJ</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "RN") selected @endif value="RN">RN</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "RS") selected @endif value="RS">RS</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "RO") selected @endif value="RO">RO</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "RR") selected @endif value="RR">RR</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "SC") selected @endif value="SC">SC</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "SP") selected @endif value="SP">SP</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "SE") selected @endif value="SE">SE</option>
                                                            <option @if(old('endereco-uf-'.$campo->id) == "TO") selected @endif value="TO">TO</option>
                                                        </select>
                                                        @error('endereco-uf-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="endereco-numero-{{$campo->id}}">{{__("Número")}}</label>
                                                        <input type="number" class="form-control numero @error('endereco-numero-'.$campo->id) is-invalid @enderror" id="endereco-numero-{{$campo->id}}" name="endereco-numero-{{$campo->id}}" placeholder="10" @if($campo->obrigatorio) required @endif value="@if(old('endereco-numero-'.$campo->id) != null){{old('endereco-numero-'.$campo->id)}}@endif" maxlength="10">
                                                        @error('endereco-numero-'.$campo->id)
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @elseif($campo->tipo == "date")
                                            <div class="form-group">
                                                <label for="date-{{$campo->id}}">{{$campo->titulo}}@if($campo->obrigatorio)*@endif</label>
                                                <input class="form-control @error('date-'.$campo->id) is-invalid @enderror" type="date" name="date-{{$campo->id}}" id="date-{{$campo->id}}" @if($campo->obrigatorio) required @endif value="@if(old('date-'.$campo->id) != null){{old('date-'.$campo->id)}}@endif">
                                                @error('date-'.$campo->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            @elseif($campo->tipo == "select")
                                            <div class="form-group">
                                                <label for="select{{ $campo->id }}">{{ $campo->titulo }}</label>
                                                <select class="form-control" id="select{{ $campo->id }}" @if ($campo->obrigatorio) required @endif name="select-{{$campo->id}}">
                                                    <option @if ($campo->obrigatorio) disabled @endif selected>
                                                        {{__("Selecione uma opção")}}
                                                    </option>
                                                    @foreach ($campo->opcoes as $opcao)
                                                    <option value="{{ $opcao->nome }}">{{ $opcao->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @elseif($campo->tipo == "email")
                                            <div class="form-group">
                                                <label for="email-{{$campo->id}}">{{$campo->titulo}}@if($campo->obrigatorio)*@endif</label>
                                                <input class="form-control @error('email-'.$campo->id) is-invalid @enderror" type="email" name="email-{{$campo->id}}" id="email-{{$campo->id}}" @if($campo->obrigatorio) required @endif value="@if(old('email-'.$campo->id) != null){{old('email-'.$campo->id)}}@endif">
                                                @error('email-'.$campo->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            @elseif($campo->tipo == "text")
                                            <div class="form-group">
                                                <label for="text-{{$campo->id}}">{{$campo->titulo}}@if($campo->obrigatorio)*@endif</label>
                                                <input class="form-control @error('text-'.$campo->id) is-invalid @enderror" type="text" name="text-{{$campo->id}}" id="text-{{$campo->id}}" @if($campo->obrigatorio) required @endif value="@if(old('text-'.$campo->id) != null){{old('text-'.$campo->id)}}@endif">
                                                @error('text-'.$campo->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            @elseif($campo->tipo == "cpf")
                                            <div class="form-group">
                                                <label for="cpf-{{$campo->id}}">{{$campo->titulo}}@if($campo->obrigatorio)*@endif</label>
                                                <input id="cpf-{{$campo->id}}" type="text" class="form-control cpf @error('cpf-'.$campo->id) is-invalid @enderror" name="cpf-{{$campo->id}}" autocomplete="cpf" autofocus @if($campo->obrigatorio) required @endif value="@if(old('cpf-'.$campo->id) != null){{old('cpf-'.$campo->id)}}@endif">
                                                @error('cpf-'.$campo->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            @elseif($campo->tipo == "contato")
                                            <div class="form-group">
                                                <label for="contato-{{$campo->id}}">{{$campo->titulo}}@if($campo->obrigatorio)*@endif</label>
                                                <input id="contato-{{$campo->id}}" type="text" class="form-control celular @error('contato-'.$campo->id) is-invalid @enderror" name="contato-{{$campo->id}}" autocomplete="contato" autofocus @if($campo->obrigatorio) required @endif value="@if(old('contato-'.$campo->id) != null){{old('contato-'.$campo->id)}}@endif">
                                                @error('contato-'.$campo->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            @elseif($campo->tipo == "file")
                                            <div class="form-group">
                                                <label for="file-{{$campo->id}}" class="">{{$campo->titulo}}@if($campo->obrigatorio)*@endif</label><br>
                                                <input type="file" id="file-{{$campo->id}}" class="form-control-file  @error('file-'.$campo->id) is-invalid @enderror" name="file-{{$campo->id}}" @if($campo->obrigatorio) required @endif>
                                                <br>
                                                @error('file-'.$campo->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </template>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                @include('componentes.mensagens')
                <p>{{__("Tem certeza que deseja se inscrever nesse evento?")}}</p>
                @endif


                @if(auth()->check())
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary button-prevent-multiple-submits">Confirmar</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
</div>
<div class="div-informacoes-evento container mb-5" style="@if (isset($evento->fotoEvento))margin-top: -25px;@else margin-top: -200px; @endif">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-xl-8">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-12">
                            <div class="card sombra-card w-100">
                                <div class="card-body">
                                    <div class="container">
                                        {{-- @if (!Auth::check())
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong> A submissão de um trabalho é possível apenas quando cadastrado no sistema. </strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif --}}
                                        @if (session('message'))
                                        <div class="alert alert-success">
                                            {{ session('message') }}
                                        </div>
                                        @endif
                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif
                                        <div class="row">

                                            @if($evento->is_multilingual && Session::get('idiomaAtual') === 'en')
                                            <div class="col-sm-12">
                                                <h2 style="font-weight: bold; border-bottom: solid 3px #114048ff;">{{ $evento->nome_en }}</h2>
                                            </div>
                                            @else
                                            <div class="col-sm-12">
                                                <h2 style="font-weight: bold; border-bottom: solid 3px #114048ff;">{{ $evento->nome }}</h2>
                                            </div>
                                            @endif


                                        </div>
                                        <br>
                                        <div class="row">
                                            @if($evento->is_multilingual && Session::get('idiomaAtual') === 'en')
                                            <div class="col-sm-12" style="text-align: justify;">
                                                {!! $evento->descricao_en !!}
                                            </div>
                                            @else
                                            <div class="col-sm-12" style="text-align: justify;">
                                                {!! $evento->descricao !!}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($etiquetas->modprogramacao == true && $evento->exibir_calendario_programacao)

                    <div id="mensagem-aviso" class="alert alert-info alert-dismissible fade show" role="alert">
                        {{__("Para participar das atividades do evento, é preciso primeiro se inscrever no evento e, em seguida, realizar a inscrição na atividade desejada, disponível na seção de Programação.")}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-12">
                            <div class="card sombra-card" style="width: 100%;">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-sm-12 form-group">
                                            <h4 style="font-weight: bold; border-bottom: solid 3px #114048ff;">
                                                {{$etiquetas->etiquetamoduloprogramacao}}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-12 form-group">
                                            <div id="wrap">
                                                <div id='calendar-wrap' style="width: 100%;">
                                                    <div id='calendar'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-xl-4">
                    @if ($etiquetas->modinscricao == true)
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-12">
                            <div class="card sombra-card" style="width: 100%;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 style="font-weight: bold; border-bottom: solid 3px #114048ff;">{{__("Inscrições")}}</h4>
                                        </div>
                                    </div>
                                    <div class="row mx-1">
                                        <button id="btn-inscrevase" class="btn btn-primary" data-toggle="modal" data-target="#modalInscrever" @if ($isInscrito || $encerrada) disabled @endif>@if ($isInscrito)
                                            {{__("Já inscrito")}} @elseif($encerrada) {{__("Encerradas")}} @else
                                            {{__("Inscreva-se")}} @endif</button>
                                        @isset($inscricao)
                                        @isset($inscricao->pagamento)
                                        <a href="{{route('checkout.statusPagamento', $evento->id)}}" class="text-center mt-2 w-100">{{__("Visualizar status do pagamento")}}</a>
                                        @endisset
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-12">
                            <div class="card sombra-card" style="width: 100%;">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-sm-12 form-group">
                                            <h4 style="font-weight: bold; border-bottom: solid 3px #114048ff;">
                                                {{__("Informações")}}
                                            </h4>
                                        </div>
                                    </div>


                                    @if ($evento->exibir_pdf && $etiquetas->modprogramacao == true && $evento->pdf_programacao != null)
                                    <div class="form-row justify-content-center @if($evento->exibir_pdf && $etiquetas->modprogramacao && $evento->pdf_programacao) mb-3 @endif">
                                        <div class="col-sm-3 form-group " style="position: relative; text-align: center;">
                                            <div class="div-icon-programacao">
                                                <img class="icon-programacao" src="{{ asset('img/icons/Icon awesome-file-pdf.svg') }}" alt="PDF com a programação">
                                            </div>
                                        </div>
                                        <div class="col-sm-8 form-inline">
                                            <span class="titulo">
                                                <a href="{{ asset('storage/' . $evento->pdf_programacao) }}" target="_black">{{ $etiquetas->etiquetamoduloprogramacao }}</a>
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($evento->pdf_arquivo != null && $evento->modarquivo)
                                    <div class="form-row justify-content-center">
                                        <div class="col-sm-3 form-group " style="position: relative; text-align: center;">
                                            <div class="div-icon-programacao">
                                                <img class="icon-programacao" src="{{ asset('img/icons/Icon awesome-file-pdf.svg') }}" alt="PDF com a programação">
                                            </div>
                                        </div>
                                        <div class="col-sm-8 form-inline">
                                            <span class="titulo">
                                                <a href="{{ asset('storage/' . $evento->pdf_arquivo) }}" target="_black">{{ $etiquetas->etiquetaarquivo }}</a>
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    @foreach ($evento->arquivoInfos as $arquivo)
                                    <div class="form-row justify-content-center @if(!$loop->last) mb-3 @endif">
                                        <div class="col-sm-3 form-group  d-flex align-items-center" style="position: relative; text-align: center;">
                                            <div class="div-icon-programacao">
                                                <img class="icon-programacao" src="{{ asset('img/icons/Icon awesome-file-pdf.svg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-sm-8 form-inline">
                                            <span class="titulo">
                                                <a href="{{ asset('storage/'.$arquivo->path) }}" target="_black">{{ $arquivo->nome }}</a>
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if ($etiquetas->modsubmissao == true)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            {{-- <h5>{{$etiquetas->etiquetasubmissoes}}</h5> --}}
                                            <div class="accordion" id="accordion_modalidades" style="font-size: 10px;">
                                                @foreach ($modalidades as $modalidade)
                                                @if (Carbon\Carbon::parse($modalidade->ultima_data) >= $mytime)
                                                <div class="accordion-group">
                                                    <div class="accordion-heading">
                                                        <a class="accordion-button accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion_modalidades" href="{{ '#collapse_' . $modalidade->id }}">
                                                            <div class="row">
                                                                <div class="col-sm-10">
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <img class="enviar-trabalho" src="{{ asset('img/icons/Icon awesome-arrow-up.svg') }}" alt="Enviar trabalho">
                                                                        </div>
                                                                        <div class="col-sm-9" style="position: relative; left: 8px; margin-top: 8px; ">
                                                                            <span style="font-size: 14px;">{{__("Envio de trabalhos")}}</span><br>
                                                                            <span style="font-size: 12px;">({{__("modalidade")}} <strong>{{ $modalidade->nome }}</strong>)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2" style="margin-top: 15px;">
                                                                    <img src="{{ asset('img/icons/Icon ionic-ios-arrow-down.svg') }}" alt="Seta que abre o accordion" width="15px;">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div id="{{ 'collapse_' . $modalidade->id }}" class="accordion-body in collapse" style="height: auto;">
                                                        {{-- <div class="accordion-inner"> --}}
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table>
                                                                    <tr>
                                                                        <td><img class="" src="{{ asset('img/icons/calendar-pink.png') }}" alt="" style="width:20px;"></td>
                                                                        <td>Envio:</td>
                                                                        <td>{{ date('d/m/Y H:i', strtotime($modalidade->inicioSubmissao)) }}</td>
                                                                        <td>- {{ date('d/m/Y H:i', strtotime($modalidade->fimSubmissao)) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img class="" src="{{ asset('img/icons/calendar-yellow.png') }}" alt="" style="width:20px;"></td>
                                                                        <td>Avaliação:</td>
                                                                        <td>{{ date('d/m/Y H:i', strtotime($modalidade->inicioRevisao)) }}</td>
                                                                        <td>- {{ date('d/m/Y H:i', strtotime($modalidade->fimRevisao)) }}</td>
                                                                    </tr>
                                                                    @if ($modalidade->inicioCorrecao && $modalidade->fimCorrecao)
                                                                    <tr>
                                                                        <td><img class="" src="{{ asset('img/icons/calendar-yellow.png') }}" alt="" style="width:20px;"></td>
                                                                        <td>Correção:</td>
                                                                        <td>{{ date('d/m/Y H:i', strtotime($modalidade->inicioCorrecao)) }}</td>
                                                                        <td>- {{ date('d/m/Y H:i', strtotime($modalidade->fimCorrecao)) }}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @if ($modalidade->inicioValidacao && $modalidade->fimValidacao)
                                                                    <tr>
                                                                        <td><img class="" src="{{ asset('img/icons/calendar-yellow.png') }}" alt="" style="width:20px;"></td>
                                                                        <td>Validação:</td>
                                                                        <td>{{ date('d/m/Y H:i', strtotime($modalidade->inicioValidacao)) }}</td>
                                                                        <td>- {{ date('d/m/Y H:i', strtotime($modalidade->fimValidacao)) }}</td>
                                                                    </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <td><img class="" src="{{ asset('img/icons/calendar-green.png') }}" alt="" style="width:20px;"></td>
                                                                        <td>Resultado:</td>
                                                                        <td>{{ date('d/m/Y  H:i', strtotime($modalidade->inicioResultado)) }}</td>
                                                                    </tr>
                                                                    @foreach ($modalidade->datasExtras as $data)
                                                                    <tr>
                                                                        <td><img class="" src="{{ asset('img/icons/calendar-yellow.png') }}" alt="" style="width:20px;"></td>
                                                                        <td>{{$data->nome}}:</td>
                                                                        <td>{{ date('d/m/Y H:i', strtotime($data->inicio)) }}</td>
                                                                        <td>- {{ date('d/m/Y H:i', strtotime($data->fim)) }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                @if ($modalidade->arquivo)
                                                                @if (isset($modalidade->regra))
                                                                <div style="margin-top: 20px; margin-bottom: 10px;">
                                                                    <a href="{{ route('modalidade.regras.download', ['id' => $modalidade->id]) }}" target="_new" style="font-size: 14px; color: #114048ff; text-decoration: none;">
                                                                        <img class="" src="{{ asset('img/icons/file-download-solid.svg') }}" style="width:20px;">&nbsp;{{ $evento->formEvento->etiquetabaixarregra }}
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @if (isset($modalidade->modelo_apresentacao))
                                                                <div style="margin-top: 20px; margin-bottom: 10px;">
                                                                    <a href="{{ route('modalidade.modelos.download', ['id' => $modalidade->id]) }}" target="_new" style="font-size: 14px; color: #114048ff; text-decoration: none;">
                                                                        <img class="" src="{{ asset('img/icons/file-download-solid.svg') }}" style="width:20px;">&nbsp;{{$evento->formEvento->etiquetabaixarapresentacao}}
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @if (isset($modalidade->template))
                                                                <div style="margin-top: 20px; margin-bottom: 10px;">
                                                                    <a href="{{ route('modalidade.template.download', ['id' => $modalidade->id]) }}" target="_new" style="font-size: 14px; color: #114048ff; text-decoration: none;">
                                                                        <img class="" src="{{ asset('img/icons/file-download-solid.svg') }}" style="width:20px;">&nbsp;{{ $evento->formEvento->etiquetabaixartemplate }}
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @else
                                                                @if (isset($modalidade->modelo_apresentacao))
                                                                <div style="margin-top: 20px; margin-bottom: 10px;">
                                                                    <a href="{{ route('modalidade.modelos.download', ['id' => $modalidade->id]) }}" target="_new" style="font-size: 14px; color: #114048ff; text-decoration: none;">
                                                                        <img class="" src="{{ asset('img/icons/file-download-solid.svg') }}" style="width:20px;">&nbsp;{{$evento->formEvento->etiquetabaixarapresentacao}}
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @if (isset($modalidade->regra))
                                                                <div style="margin-top: 20px; margin-bottom: 10px;">
                                                                    <a href="{{ route('modalidade.regras.download', ['id' => $modalidade->id]) }}" target="_new" style="font-size: 14px; color: #114048ff; text-decoration: none;">
                                                                        <img class="" src="{{ asset('img/icons/file-download-solid.svg') }}" style="width:20px;">&nbsp;{{ $evento->formEvento->etiquetabaixarregra }}
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @endif
                                                                @auth
                                                                @if ($modalidade->estaEmPeriodoDeSubmissao() && $inscricao?->podeSubmeterTrabalho())
                                                                <a class="btn btn-primary" href="{{ route('trabalho.index', ['id' => $evento->id, 'idModalidade' => $modalidade->id]) }}" style="width: 100%; font-weight: bold;">{{__("SUBMETER TRABALHO")}}</a>
                                                                @else
                                                                @can('isCoordenadorOrCoordenadorDasComissoes', $evento)
                                                                <a class="btn btn-primary" href="{{ route('trabalho.index', ['id' => $evento->id, 'idModalidade' => $modalidade->id]) }}" style="width: 100%; font-weight: bold;">{{__("SUBMETER TRABALHO")}}</a>
                                                                @endcan
                                                                @endif
                                                                @endauth
                                                            </div>
                                                        </div>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-row" style="margin-top: 15px; justify-content: center;">
                                        <div class="col-sm-3" style="text-align: center;">
                                            <div class="div-icon-programacao">
                                                <img src="{{ asset('img/icons/Icon material-email.svg') }}" alt="PDF com a programação" style="margin-top: 5px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <a href="mailto:@if($evento->email != null){{$evento->email}}@else{{$evento->coordenador->email}}@endif">
                                                <div style="margin-top: 18px;">
                                                    <h6 style="margin-bottom: 0px; font-size: 16px; font-weight: bold;">
                                                        {{__("Contato")}}
                                                    </h6>
                                                    {{-- {{$evento->coordenador->email}} --}}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($evento->memorias->count())
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-12">
                            <div class="card sombra-card" style="width: 100%;">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-sm-12 form-group">
                                            <h4 style="font-weight: bold; border-bottom: solid 3px #114048ff;">{{__("Memória")}}</h4>
                                        </div>
                                    </div>

                                    @foreach ($evento->memorias as $memoria)
                                    <div class="form-row justify-content-center">
                                        <div class="col-sm-3 form-group ">
                                            <div class="div-icon-programacao d-flex justify-content-center">
                                                @if($memoria->arquivo)
                                                <img class="icon-programacao" src="{{ asset('img/icons/Icon awesome-file-pdf.svg') }}" alt="">
                                                @elseif($memoria->link)
                                                <img class="icon-programacao" src="{{ asset('img/icons/link-solid.svg') }}" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-8 form-inline">
                                            <span class="titulo">
                                                @if($memoria->arquivo)
                                                <a href="/storage/{{ $memoria->arquivo }}" target="_blank">{{ $memoria->titulo }}</a>
                                                @elseif($memoria->link)
                                                <a href="{{ $memoria->link }}" target="_blank">{{ $memoria->titulo }}</a>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            @if ($subeventos->count() > 0)
            <div class="row">
                <div class="col-sm-12">
                    <div class="card sombra-card" style="width: 100%;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 style="font-weight: bold; border-bottom: solid 3px #114048ff;">
                                        {{__("Subeventos")}}
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($subeventos as $subevento)
                                <div class="col-sm-12 col-md-6 col-xl-4 d-flex align-items-stretch justify-content-center">
                                    <div class="card" style="width: 15rem;">
                                        @if (isset($subevento->fotoEvento))

                                        <img class="img-card" src="{{ asset('storage/' . $subevento->fotoEvento) }}" class="card-img-top" alt="...">
                                        @else
                                        <img class="img-card" src="{{ asset('img/colorscheme.png') }}" class="card-img-top" alt="...">
                                        @endif
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5 class="card-title">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <a href="{{ route('evento.visualizar', ['id' => $subevento->id]) }}" style="text-decoration: inherit;">
                                                                    @if($subevento->is_multilingual && Session::get('idiomaAtual') === 'en')
                                                                    {{ $subevento->nome_en }}
                                                                    @else
                                                                    {{ $subevento->nome }}
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="card-text">
                                                    <img src="{{ asset('/img/icons/calendar.png') }}" alt="" width="20px;" style="position: relative; top: -2px;"> {{ date('d/m/Y', strtotime($subevento->dataInicio)) }} - {{ date('d/m/Y', strtotime($subevento->dataFim)) }}<br>
                                                </p>
                                                <p>
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-12">
                                                        <img src="{{ asset('/img/icons/location_pointer.png') }}" alt="" width="18px" height="auto">
                                                        {{ $subevento->endereco->rua }}, {{ $subevento->endereco->numero }} - {{ $subevento->endereco->cidade }} / {{ $subevento->endereco->uf }}.
                                                    </div>
                                                </div>
                                                </p>
                                                <div>
                                                    <div>
                                                        <a href="{{ route('evento.visualizar', ['id' => $subevento->id]) }}">
                                                            <i class="far fa-eye" style="color: black"></i>&nbsp;&nbsp;{{__("Visualizar evento")}}
                                                        </a>
                                                    </div>
                                                    @can('isCoordenadorOrCoordenadorDasComissoes', $subevento)
                                                    <div>
                                                        <a href="{{ route('coord.detalhesEvento', ['eventoId' => $subevento->id]) }}">
                                                            <i class="fas fa-cog" style="color: black"></i>&nbsp;&nbsp;{{__("Configurar evento")}}
                                                        </a>
                                                    </div>
                                                    @can('isCoordenador', $subevento)
                                                    <div>
                                                        <a href="#" data-toggle="modal" data-target="#modalExcluirEvento{{ $subevento->id }}">
                                                            <i class="far fa-trash-alt" style="color: black"></i>&nbsp;&nbsp;{{__("Deletar")}}
                                                        </a>
                                                    </div>
                                                    @endcan
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal de exclusão do evento -->
                                <x-modal-excluir-evento :evento="$evento"/>
                                <!-- fim do modal -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script>
    $('#carouselCategorias').carousel({
        interval: 10000
    })

    $('.carousel-categorias .carousel .carousel-item').each(function() {
        var minPerSlide = 3;
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < minPerSlide; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
    });
</script>
@if(session('abrirmodalinscricao'))
<script>
    $('#modalInscrever').modal('show')
</script>
@endif
<script>
    $(document).ready(function() {
        $(".accordion-button").click(function() {
            var img = this.children[0].children[1].children[0];
            if (this.classList.contains("collapsed")) {
                img.src = "{{ asset('img/icons/Icon ionic-ios-arrow-up.svg') }}";
            } else {
                img.src = "{{ asset('img/icons/Icon ionic-ios-arrow-down.svg') }}";
            }
        });
    });
    var botoes = document.getElementsByClassName('cor-aleatoria');
    for (var i = 0; i < botoes.length; i++) {
        botoes[i].style.backgroundColor = '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    function changeTrabalho(x) {
        document.getElementById('trabalhoNovaVersaoId').value = x;
    }
</script>
@if ($dataInicial != '' && $evento->exibir_calendario_programacao)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        /* initialize the external events
        -----------------------------------------------------------------*/
        // var containerEl = document.getElementById('external-events-list');
        // new FullCalendar.Draggable(containerEl, {
        //   itemSelector: '.fc-event',
        //   eventData: function(eventEl) {
        //     return {
        //       title: eventEl.innerText.trim()
        //     }
        //   }
        // });
        //// the individual way to do it
        // var containerEl = document.getElementById('external-events-list');
        // var eventEls = Array.prototype.slice.call(
        //   containerEl.querySelectorAll('.fc-event')
        // );
        // eventEls.forEach(function(eventEl) {
        //   new FullCalendar.Draggable(eventEl, {
        //     eventData: {
        //       title: eventEl.innerText.trim(),
        //     }
        //   });
        // });
        /* initialize the calendar
        -----------------------------------------------------------------*/
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialDate: "{{ $dataInicial->data }}",
            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay,listYear',
                center: 'title',
                right: 'prev,next today'
            },
            initialView: 'listYear',
            locale: 'pt-br',
            editable: false,
            eventClick: function(info) {
                var idModal = "#modalAtividadeShow" + info.event.id;
                $(idModal).modal('show');
            },
            events: "{{ route('atividades.json', ['id' => $evento->id]) }}",
        });
        calendar.render();
    });
</script>
@endif
<script>
    // Fecha a caixa de aviso quando o botão de fechar é clicado
    $(document).ready(function() {
        $('.alert-dismissible').on('closed.bs.alert', function() {
            // Envia uma requisição para o servidor para marcar a mensagem como lida, se necessário
            // Exemplo: usar AJAX para enviar um POST request para marcar a mensagem como lida no banco de dados
        });
    });
</script>
@endsection
