@extends('coordenador.detalhesEvento')

@section('menu')
    {{-- Comissão --}}
    <div id="divCadastrarComissao"
        class="comissao"
        style="display: block">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Adicionar registro</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registros</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Adicione um novo registro para o seu evento</h6>
                        <form method="POST"
                            action="{{ route('coord.memoria.store', $evento) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <p class="card-text">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="titulo"
                                        class="col-form-label">{{ __('Título') }}</label>
                                    <input id="titulo"
                                        type="text"
                                        class="form-control @error('titulo') is-invalid @enderror"
                                        name="titulo"
                                        value="{{ old('titulo') }}"
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
                                        value="{{ old('link') }}"
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
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-primary">
                                    {{ __('Salvar') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>{{-- end card --}}
            </div>
        </div>
    </div>{{-- End cadastrar Comissão --}}
@endsection
