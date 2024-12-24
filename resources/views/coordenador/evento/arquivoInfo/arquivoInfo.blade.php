@extends('coordenador.detalhesEvento')

@section('menu')
    <div id="divListarAreas"
        style="display: block">
        <div class="row">
            <div class="col-md-12">
                <h1 class="titulo-detalhes">Arquivos adicionais</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h5 class="card-title">Arquivos</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Arquivo adicionados</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-sm-start justify-content-md-end align-items-center">
                                @component('coordenador.evento.arquivoInfo.modal-arquivoInfo', ['evento' => $evento])@endcomponent
                            </div>
                        </div>
                        <p class="card-text">
                        <table class="table table-hover table-responsive-md table-md">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col"
                                        style="text-align:center">Editar</th>
                                    <th scope="col"
                                        style="text-align:center">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evento->arquivoInfos as $arquivo)
                                    <tr>
                                        <td>{{ $arquivo->nome }}</td>
                                        <td style="text-align:center">
                                            <a href="#"
                                                data-toggle="modal"
                                                data-target="#modalEditarArea{{ $arquivo->id }}"><img
                                                    src="{{ asset('img/icons/edit-regular.svg') }}"
                                                    style="width:20px"></a>
                                        </td>
                                        <td style="text-align:center">
                                            <form id="formExcluirArea{{ $arquivo->id }}"
                                                method="POST"
                                                action="{{ route('coord.arquivos-adicionais.delete', $arquivo) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#"
                                                    data-toggle="modal"
                                                    data-target="#modalExcluirArea{{ $arquivo->id }}">
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

    @foreach ($evento->arquivoInfos as $arquivo)
        @component('coordenador.evento.arquivoInfo.modal-editar-arquivoInfo', ['arquivo' => $arquivo])@endcomponent
        @component('coordenador.evento.arquivoInfo.modal-excluir-arquivoInfo', ['arquivo' => $arquivo])@endcomponent
    @endforeach

@endsection
