@extends('layouts.app')

@section('content')

    <div class="container  position-relative">
        <div class="row justify-content-center titulo-detalhes">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="">Certificados</h1>
                    </div>
                </div>
            </div>
        </div>
        <div id="divListarTrabalhos"
            style="display: block">
            @foreach ($certificadosPorTipo as $certificados)
                <div class="row justify-content-center"
                    style="width: 100%;">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tipo do certificado: <span
                                        class="card-subtitle mb-2 text-muted">{{ $tiposView[$certificados[0]->tipo-1] }}</span>
                                    <div class="row table-trabalhos">
                                        <div class="col-sm-12">
                                            <form action="#"
                                                method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <br>
                                                <table class="table table-hover table-responsive-lg table-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                Evento
                                                            </th>
                                                            <th>
                                                                @if (in_array($certificados[0]->tipo, [1, 6, 8]))
                                                                    @switch($certificados[0]->tipo)
                                                                        @case(1)
                                                                            Trabalho
                                                                        @break

                                                                        @case(6)
                                                                            Palestra
                                                                        @break

                                                                        @case(8)
                                                                            Comissão
                                                                        @break

                                                                        @default
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            </th>
                                                            <th scope="col">
                                                                Data
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($certificados as $certificado)
                                                            <tr>
                                                                <td>
                                                                    {{ $certificado->evento->nome }}
                                                                </td>
                                                                <td>
                                                                    @switch($certificado->tipo)
                                                                        @case(1)
                                                                            {{ $trabalhos->find($certificado->pivot->trabalho_id)->titulo }}
                                                                        @break

                                                                        @case(6)
                                                                            {{ $palestras->find($certificado->pivot->palestra_id)->nome }}
                                                                        @break

                                                                        @case(8)
                                                                            {{ $comissoes->find($certificado->pivot->comissao_id)->nome }}
                                                                        @break

                                                                        @default
                                                                    @endswitch
                                                                </td>
                                                                <td>
                                                                    {{ date('d/m/Y H:i', strtotime($certificado->pivot->created_at)) }}

                                                                </td>
                                                                <td>
                                                                    @switch($certificado->tipo)
                                                                        @case(1)
                                                                            <a class="text-reset d-flex justify-content-center"
                                                                                href="{{ route('coord.verCertificado', [$certificado->id, $usuario->id, $certificado->pivot->trabalho_id]) }}"
                                                                                target="_blank"
                                                                                rel="noopener noreferrer">
                                                                                <i class="far fa-eye"></i>
                                                                            </a>
                                                                        @break

                                                                        @case(6)
                                                                            <a class="text-reset d-flex justify-content-center"
                                                                                href="{{ route('coord.verCertificado', [$certificado->id, $usuario->id, $certificado->pivot->palestra_id]) }}"
                                                                                target="_blank"
                                                                                rel="noopener noreferrer">
                                                                                <i class="far fa-eye"></i>
                                                                            </a>
                                                                        @break

                                                                        @case(8)
                                                                            <a class="text-reset d-flex justify-content-center"
                                                                                href="{{ route('coord.verCertificado', [$certificado->id, $usuario->id, $certificado->pivot->comissao_id]) }}"
                                                                                target="_blank"
                                                                                rel="noopener noreferrer">
                                                                                <i class="far fa-eye"></i>
                                                                            </a>
                                                                        @break

                                                                        @default
                                                                            <a class="text-reset d-flex justify-content-center"
                                                                                href="{{ route('coord.verCertificado', [$certificado->id, $usuario->id, 0]) }}"
                                                                                target="_blank"
                                                                                rel="noopener noreferrer">
                                                                                <i class="far fa-eye"></i>
                                                                            </a>
                                                                    @endswitch
                                                                    @error('certificado')
                                                                        {{$message}}
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    @endsection
