@extends('coordenador.detalhesEvento')

@section('menu')
    {{-- Comissão --}}
    <div id="divCadastrarComissao" class="comissao" style="display: block">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Cadastrar comissão</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Nova comissão</h5>
                      <form action="{{route('coord.tipocomissao.store', $evento)}}" method="POST">
                        @csrf
                        <p class="card-text">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="nome" class="control-label">Nome</label>
                                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" id="nome" placeholder="Nome da comissão" required>
                                    @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    {{ __('Finalizar') }}
                                </button>
                            </div>
                        </div>

                        </form>
                    </div>
                  </div>{{-- end card--}}
            </div>
        </div>
    </div>{{-- End cadastrar Comissão --}}
@endsection
