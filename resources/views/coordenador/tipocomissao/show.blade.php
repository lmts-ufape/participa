@extends('coordenador.detalhesEvento')
@section('menu')
    <div id="divListarComissoes"
        style="display: block">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Listagem dos membros da comissão {{ $comissao->nome }}</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-sm-3">
                                <h5 class="card-title">Membros</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Membros cadastrados na comissão</h6>
                            </div>
                            <div class="col-sm-9">
                                <div class="row justify-content-end">
                                    <div class="col-sm-4"
                                        style="text-align: right;">
                                        <button class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#modalCadastrarMembro">Cadastrar membro</button>
                                    </div>
                                    <div class="col-sm-4"
                                        style="text-align: right;">
                                        <button class="btn btn-secondary"
                                            data-toggle="modal"
                                            data-target="#modalEditarComissao">Editar comissão</button>
                                    </div>
                                    @can('isCoordenadorOrCoordenadorDasComissoes', $evento)
                                        <div class="col-sm-4"
                                            style="text-align: right;">
                                            <button class="btn btn-danger"
                                                data-toggle="modal"
                                                data-target="#modalExcluirComissao">Deletar comissão</button>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Direção</th>
                                    <th scope="col"
                                        style="text-align:center">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comissao->membros as $membro)
                                    <tr>
                                        <td data-toggle="modal"
                                            data-target="#modalEditarMembro{{ $membro->id }}">{{ $membro->name }}</td>
                                        <td data-toggle="modal"
                                            data-target="#modalEditarMembro{{ $membro->id }}">{{ $membro->email }}</td>
                                        <td data-toggle="modal"
                                        data-target="#modalEditarMembro{{ $membro->id }}">@if($membro->pivot->isCoordenador) Coordenador @endif</td>
                                        <td style="text-align:center">
                                            <form id="removerMembro{{ $membro->id }}"
                                                action="{{ route('coord.tipocomissao.removermembro', ['evento' => $evento, 'comissao' => $comissao]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="email" value="{{$membro->email}}">
                                                <a href="#"
                                                    data-toggle="modal"
                                                    data-target="#modalRemoverMembro{{ $membro->id }}">
                                                    <img src="{{ asset('img/icons/user-times-solid.svg') }}"
                                                        class="icon-card"
                                                        style="width:25px">
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($comissao->membros as $membro)
        <!-- Modal de exclusão do membro -->
        <div class="modal fade"
            id="modalRemoverMembro{{ $membro->id }}"
            tabindex="-1"
            role="dialog"
            aria-labelledby="#label"
            aria-hidden="true">
            <div class="modal-dialog"
                role="document">
                <div class="modal-content">
                    <div class="modal-header"
                        style="background-color: #114048ff; color: white;">
                        <h5 class="modal-title"
                            id="#label">Confirmação</h5>
                        <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja remover o membro com email {{$membro->email}} da comissão?
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Não</button>
                        <button type="submit"
                            class="btn btn-primary"
                            form="removerMembro{{ $membro->id }}">Sim</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de edição do membro --}}
        <div class="modal fade"
            id="modalEditarMembro{{$membro->id}}"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modalEditarMembroLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md"
                role="document">
                <div class="modal-content">
                    <div class="modal-header"
                        style="background-color: #114048ff; color: white;">
                        <h5 class="modal-title"
                            id="modalEditarMembroLabel">Editar um membro da comissao</h5>
                        <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editarMembroForm{{$membro->id}}"
                            method="POST"
                            action="{{ route('coord.tipocomissao.editmembro', ['evento' => $evento->id, 'comissao' => $comissao->id, 'membro' => $membro->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="email"
                                    class="col-form-label">{{ __('Email') }}</label>
                                <input id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email', $membro->email) }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="Email do novo membro">
                                @error('email')
                                    <span class="invalid-feedback"
                                        role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input id="isCoordenador{{$membro->id}}"
                                    type="checkbox"
                                    class="form-check-input @error('isCoordenador') is-invalid @enderror"
                                    name="isCoordenador"
                                    value="true"
                                    @if($membro->pivot->isCoordenador) checked @endif>
                                <label for="isCoordenador{{$membro->id}}"
                                    class="form-check-label">{{ __('Coordenador') }}</label>
                                @error('isCoordenador')
                                    <span class="invalid-feedback"
                                        role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Cancelar</button>
                        <button type="submit"
                            class="btn btn-primary"
                            form="editarMembroForm{{$membro->id}}">{{ __('Finalizar') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- cadastrar membro -->
    <div class="modal fade"
        id="modalCadastrarMembro"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modalCadastrarMembroLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md"
            role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color: #114048ff; color: white;">
                    <h5 class="modal-title"
                        id="modalCadastrarMembroLabel">Cadastrar um novo membro comissao</h5>
                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cadastrarMembroForm"
                        method="POST"
                        action="{{ route('coord.tipocomissao.addmembro', ['evento' => $evento, 'comissao' => $comissao]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="email"
                                class="col-form-label">{{ __('Email') }}</label>
                            <input id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="Email do novo membro">
                            @error('email')
                                <span class="invalid-feedback"
                                    role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input id="isCoordenador"
                                type="checkbox"
                                class="form-check-input @error('isCoordenador') is-invalid @enderror"
                                name="isCoordenador"
                                value="true">
                            <label for="isCoordenador"
                                class="form-check-label">{{ __('Coordenador') }}</label>
                            @error('isCoordenador')
                                <span class="invalid-feedback"
                                    role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Cancelar</button>
                    <button type="submit"
                        class="btn btn-primary"
                        form="cadastrarMembroForm">{{ __('Finalizar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de editar comissao -->
    <div class="modal fade" id="modalEditarComissao" tabindex="-1" role="dialog" aria-labelledby="#label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #114048ff; color: white;">
              <h5 class="modal-title" id="#label">Editar comissão {{$comissao->nome}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formEditarComissao" action="{{route('coord.tipocomissao.update', ['evento' => $evento, 'comissao' => $comissao])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="container">
                  <div class="row form-group">
                    <div class="col-sm-12" style="margin-top: 20px; margin-bottom: 20px;">
                      <label for="nome">Nome*</label>
                      <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{old('nome', $comissao->nome)}}">

                      @error('nome')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" form="formEditarComissao">Atualizar</button>
            </div>
          </div>
        </div>
      </div>
      <form id="formExcluirComissao" method="POST" action="{{route('coord.tipocomissao.destroy',['evento' => $evento, 'comissao' => $comissao])}}">
        @csrf
        @method('DELETE')
      </form>
      <!-- Modal de exclusão da comissao -->
      <div class="modal fade" id="modalExcluirComissao" tabindex="-1" role="dialog" aria-labelledby="#label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #114048ff; color: white;">
              <h5 class="modal-title" id="#label">Confirmação</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja excluir essa comissão?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
              <button type="submit" class="btn btn-primary" form="formExcluirComissao">Sim</button>
            </div>
          </div>
        </div>
      </div>
@endsection
