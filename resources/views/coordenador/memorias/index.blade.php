@extends('coordenador.detalhesEvento') @section('menu')
    <div id="divListarRegistros"
        style="display: block">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Listar Registros</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">Registros</h5>
                            </div>
                            <div class="col-md-3 justify-content-end">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('coord.memoria.create', $evento) }}"
                                        class="btn btn-primary">
                                        Adicionar registro
                                    </a>
                                </div>
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Registros adicionados no seu evento</h6>
                        <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Arquivo</th>
                                    <th scope="col"
                                        style="text-align:center">Editar</th>
                                    <th scope="col"
                                        style="text-align:center">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registros as $registro)
                                    <tr>
                                        <td>{{ $registro->titulo }}</td>
                                        <td>
                                            @if ($registro->link)
                                                <a href="{{ $registro->link }}">link</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($registro->arquivo)
                                                <a href="/storage/{{ $registro->arquivo }}">arquivo</a>
                                            @endif
                                        </td>
                                        <td style="text-align:center">
                                            <a href="#"
                                                data-toggle="modal"
                                                data-target="#modalEditarRegistro{{ $registro->id }}">
                                                <img src="{{ asset('img/icons/edit-regular.svg') }}"
                                                    style="width:20px"></a>
                                        </td>
                                        <td style="text-align:center">
                                            <form id="formExcluirRegistro{{ $registro->id }}"
                                                method="POST"
                                                action="{{ route('coord.memoria.destroy', $registro->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden"
                                                    name="evento"
                                                    value="{{ $evento->id }}">
                                                <input type="hidden"
                                                    name="memoria"
                                                    value="{{ $registro->id }}">
                                                <a href="#"
                                                    data-toggle="modal"
                                                    data-target="#modalExcluirRegistro{{ $registro->id }}">
                                                    <img src="{{ asset('img/icons/trash-alt-regular.svg') }}"
                                                        class="icon-card"
                                                        alt="">
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
    @foreach ($registros as $registro)
        <!-- Modal de editar área -->
        <div class="modal fade"
            id="modalEditarRegistro{{ $registro->id }}"
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
                            id="#label">Editar registro {{ $registro->nome }}</h5>
                        <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"
                            id="formEditarRegistro{{ $registro->id }}"
                            action="{{ route('coord.memoria.update', ['evento' => $evento, 'memoria' => $registro]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <p class="card-text">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="titulo"
                                        class="col-form-label">{{ __('Título') }}</label>
                                    <input id="titulo"
                                        type="text"
                                        class="form-control @error('titulo') is-invalid @enderror"
                                        name="titulo"
                                        value="{{ old('titulo', $registro->titulo) }}"
                                        required
                                        autocomplete="titulo"
                                        autofocus>
                                    @error('titulo')
                                        <span class="invalid-feedback"
                                            role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-12">
                                    <label for="link"
                                        class="col-form-label">{{ __('Link') }}</label>
                                    <input id="link"
                                        type="text"
                                        class="form-control @error('link') is-invalid @enderror"
                                        name="link"
                                        value="{{ old('link', $registro->link) }}"
                                        autocomplete="link"
                                        autofocus>
                                    @error('link')
                                        <span class="invalid-feedback"
                                            role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-12">
                                    <label for="arquivo"
                                        class="col-form-label">{{ __('Arquivo') }}</label>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="filestyle @error('arquivo') is-invalid @enderror"
                                            data-placeholder="Nenhum arquivo"
                                            data-text="Selecionar"
                                            data-btnClass="btn-primary-lmts"
                                            name="arquivo">
                                        @if ($registro->arquivo != null)
                                            <a href="/storage/{{ $registro->arquivo }}">arquivo</a>
                                        @endif
                                    </div>
                                    <small>O arquivo deve ter no máximo 2MB</small>
                                    @error('arquivo')
                                        <span class="invalid-feedback"
                                            role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Cancelar</button>
                        <button type="submit"
                            class="btn btn-primary"
                            form="formEditarRegistro{{ $registro->id }}">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de exclusão da área -->
        <div class="modal fade"
            id="modalExcluirRegistro{{ $registro->id }}"
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
                    <div class="modal-body"> Tem certeza que deseja excluir esse registro? </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Não</button>
                        <button type="submit"
                            class="btn btn-primary"
                            form="formExcluirRegistro{{ $registro->id }}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
