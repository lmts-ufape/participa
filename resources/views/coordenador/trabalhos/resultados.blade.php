@extends('coordenador.detalhesEvento')

@section('menu')
<div id="divListarResultados" style="display: block">

    <div class="row titulo-detalhes justify-content-between">
        <div class="col-sm-4">
            <h1 class="">Resultados</h1>
        </div>
        <div class="col-sm-4">
            <a href="{{route('coord.mensagem.parecer.create', $evento)}}" class="btn btn-primary" style="width:100%">
                {{ __('Mensagens de parecer') }}
            </a>
        </div>
    </div>
        @foreach($trabalhos as $trabalho)
            <!-- Modal que exibe os resultados -->
            <div class="modal fade bd-example-modal-lg" id="modalResultados{{$trabalho->id}}" tabindex="-1" role="dialog" aria-labelledby="labelmodalResultados{{$trabalho->id}}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #114048ff; color: white;">
                            <h5 class="modal-title" id="labelmodalResultados{{$trabalho->id}}">Resultado de {{$trabalho->titulo}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if ($trabalho->pareceres != null && count($trabalho->pareceres) > 0)
                                @for ($i = 0; $i < count($trabalho->pareceres); $i++)
                                    <div id="accordion">
                                        @if ($i == 0)
                                            <div class="card">
                                                <button class="btn" data-toggle="collapse" data-target="#collapse{{$trabalho->pareceres[$i]->id}}" aria-expanded="true" aria-controls="collapse{{$trabalho->pareceres[$i]->id}}">
                                                    <div class="card-header" id="heading{{$trabalho->pareceres[$i]->id}}">
                                                        <h5 class="mb-0">
                                                            @if ($trabalho->pareceres[$i]->revisor)
                                                                Parecer de {{$trabalho->pareceres[$i]->revisor->user->name}}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </button>
                                                <div id="collapse{{$trabalho->pareceres[$i]->id}}" class="collapse show" aria-labelledby="heading{{$trabalho->pareceres[$i]->id}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            @if ($trabalho->pareceres[$i]->revisor)
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h4>Dados do avaliador</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label for="especialidade">Area:</label>
                                                                        <p id="especialidade">
                                                                            {{$trabalho->pareceres[$i]->revisor->area->nome}}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <label for="especialidade">Modalidade:</label>
                                                                        <p id="especialidade">
                                                                            {{$trabalho->pareceres[$i]->revisor->modalidade->nome}}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <label for="email">E-mail:</label>
                                                                        <p id="email">
                                                                            {{$trabalho->pareceres[$i]->revisor->user->email}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <h4>Avaliação</h4>
                                                                </div>
                                                            </div>
                                                            @if ($trabalho->pareceres[$i]->revisor)
                                                                <div class="row">
                                                                    @foreach ($trabalho->avaliacoes()->where('revisor_id', $trabalho->pareceres[$i]->revisor->id)->get() as $avaliacao)
                                                                        <div class="col-sm-6">
                                                                            <label for="criterio_{{$avaliacao->opcaoCriterio->criterio->id}}">{{$avaliacao->opcaoCriterio->criterio->nome}}:</label>
                                                                            <p id="criterio_{{$avaliacao->opcaoCriterio->criterio->id}}">
                                                                                {{$avaliacao->opcaoCriterio->nome_opcao}}
                                                                            </p>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label for="parecer_final">Parecer final:</label>
                                                                    <p id="parecer_final">
                                                                        {{$trabalho->pareceres[$i]->resultado}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label for="parecer">Parecer:</label>
                                                                    <p id="parecer">
                                                                        {{$trabalho->pareceres[$i]->justificativa}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="card">
                                                <button class="btn" data-toggle="collapse" data-target="#collapse{{$trabalho->pareceres[$i]->id}}" aria-expanded="true" aria-controls="collapse{{$trabalho->pareceres[$i]->id}}">
                                                    <div class="card-header" id="heading{{$trabalho->pareceres[$i]->id}}">
                                                        <h5 class="mb-0">
                                                            @if ($trabalho->pareceres[$i]->revisor)
                                                                Parecer de {{$trabalho->pareceres[$i]->revisor->user->name}}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </button>
                                                <div id="collapse{{$trabalho->pareceres[$i]->id}}" class="collapse" aria-labelledby="heading{{$trabalho->pareceres[$i]->id}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            @if ($trabalho->pareceres[$i]->revisor)
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <label for="especialidade">Especialidade:</label>
                                                                        <p id="especialidade">
                                                                            {{$trabalho->pareceres[$i]->revisor->user->especProfissional}}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label for="email">E-mail:</label>
                                                                        <p id="email">
                                                                            {{$trabalho->pareceres[$i]->revisor->user->email}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label for="Parecer">Parecer:</label>
                                                                    <p id="Parecer">
                                                                        {{$trabalho->pareceres[$i]->resultado}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            @else
                                <h4>Nenhum resultado</h4>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{--<div id="cards_com_trabalhos" class="row">
            @foreach ($trabalhos as $trabalho)
                <div class="card bg-light mb-3" style="width: 20rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$trabalho->titulo}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$trabalho->autor->name}}</h6>
                        <label for="area">Área:</label>
                        <p id="area">{{$trabalho->area->nome}}</p>
                        <label for="modalidade">Modalidade:</label>
                        <p id="modalidade">{{$trabalho->modalidade->nome}}</p>
                        <a href="#" class="card-link" data-toggle="modal" data-target="#modalResultados{{$trabalho->id}}">Resultado</a>
                        @if (!(empty($trabalho->arquivo->nome)))
                            <a href="{{route('downloadTrabalho', ['id' => $trabalho->id])}}" class="card-link">Baixar</a>
                        @endif
                    </div>
                </div>
            @endforeach
            --}}
        @foreach ($trabalhosPorModalidade as $trabalhos)
            <div class="row justify-content-center" style="width: 100%;">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            @if(!is_null($trabalhos->first()))
                                <h5 class="card-title">Modalidade: <span class="card-subtitle mb-2 text-muted" >{{$trabalhos[0]->modalidade->nome}}</span></h5>
                            @endif
                            <div class="row table-trabalhos">
                            <div class="col-sm-12">
                                <form action="{{route('atribuicao.check')}}" method="post">
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

                                    <input type="hidden" name="eventoId" value="{{$evento->id}}">
                                    <br>
                                    <table class="table table-hover table-responsive-lg table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    Título
                                                    <a href="{{route('coord.resultados',[ 'id' => $evento->id, 'titulo', 'asc'])}}">
                                                        <i class="fas fa-arrow-alt-circle-up"></i>
                                                    </a>
                                                    <a href="{{route('coord.resultados',[ 'id' => $evento->id, 'titulo', 'desc'])}}">
                                                        <i class="fas fa-arrow-alt-circle-down"></i>
                                                    </a>
                                                </th>
                                                <th scope="col">
                                                    Área
                                                    <a href="{{route('coord.resultados',[ 'id' => $evento->id, 'areaId', 'asc'])}}">
                                                        <i class="fas fa-arrow-alt-circle-up"></i>
                                                    </a>
                                                    <a href="{{route('coord.resultados',[ 'id' => $evento->id, 'areaId', 'desc'])}}">
                                                        <i class="fas fa-arrow-alt-circle-down"></i>
                                                    </a>
                                                </th>
                                                <th scope="col">
                                                    Autor
                                                    <a href="{{route('coord.resultados',[ 'id' => $evento->id, 'autor', 'asc'])}}">
                                                        <i class="fas fa-arrow-alt-circle-up"></i>
                                                    </a>
                                                    <a href="{{route('coord.resultados',[ 'id' => $evento->id, 'autor', 'desc'])}}">
                                                        <i class="fas fa-arrow-alt-circle-down"></i>
                                                    </a>
                                                </th>
                                                <th scope="col" style="text-align:center">
                                                    Resultado
                                                </th>
                                                <th scope="col" style="text-align:center">
                                                    Parecer final
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 0; @endphp
                                            @foreach($trabalhos as $trabalho)
                                                <tr>
                                                    <td>
                                                        @if ($trabalho->arquivo && count($trabalho->arquivo) > 0)
                                                            <a href="{{route('downloadTrabalho', ['id' => $trabalho->id])}}">
                                                                <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$trabalho->titulo}}" style="max-width: 150px;">
                                                                    {{$trabalho->titulo}}
                                                                </span>
                                                            </a>
                                                        @else
                                                            <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$trabalho->titulo}}" style="max-width: 150px;">
                                                                {{$trabalho->titulo}}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$trabalho->area->nome}}" style="max-width: 150px;">
                                                        {{$trabalho->area->nome}}
                                                        </span>
                                                    </td>
                                                    <td>{{$trabalho->autor->name}}</td>
                                                    <td style="text-align:center">
                                                        <a style="cursor: pointer" data-toggle="modal" data-target="#modalResultados{{$trabalho->id}}">
                                                            <img src="{{asset('img/icons/eye-regular.svg')}}" style="width:20px">
                                                        </a>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <a onclick="mostrarParecerFinal({{$trabalho->id}})" style="cursor: pointer" data-toggle="modal" data-target="#modalParecerFinal">
                                                            <img @if($trabalho->parecer_final == true) src="{{asset('img/icons/resultado-aprovado.svg')}}" @elseif(is_null($trabalho->parecer_final)) src="{{asset('img/icons/resultado-nulo.svg')}}" @else src="{{asset('img/icons/resultado-reprovado.svg')}}"  @endif  style="width:35px">
                                                        </a>
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
        <div class="modal fade bd-example-modal-lg" id="modalParecerFinal" tabindex="-1" role="dialog" aria-labelledby="labelmodalResultados" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #114048ff; color: white;">
                        <h5 class="modal-title" id="trabalho-nome-parecer"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-avaliar-trabalho" method="POST" action="{{route('coord.parecer.final')}}">
                            @csrf
                            <input type="hidden" name="trabalho_id" id="trabalho-id" value="">
                            <input type="hidden" name="aprovar" id="parecer-final-input" value="">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <div class="alert alert-success" role="alert" id="resultadoAprovado" style="display: none">
                                        <p>O trabalho foi aprovado.</p>
                                    </div>
                                    <div class="alert alert-danger" role="alert" id="resultadoReprovado" style="display: none">
                                        <p>O trabalho foi reprovado.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-md-6 form-group">
                                    <button type="button" class="btn btn-danger" style="width:100%;" onclick="atualizarInputAprovar(false)">Reprovar</button>
                                </div>
                                <div class="col-md-6 form-group" style="padding-right: 20px">
                                    <button type="button" class="btn btn-success" style="width:100%" onclick="atualizarInputAprovar(true)">Aprovar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
@parent
    <script>
        function mostrarParecerFinal(id) {
            const aprovado = $("#resultadoAprovado");
            const reprovado = $("#resultadoReprovado");
            document.querySelector("#trabalho-nome-parecer").innerHTML = "";
            aprovado.hide();
            reprovado.hide();
            $.ajax({
                url:"{{route('coord.parecer.final.info.ajax')}}",
                type:"get",
                data: {"trabalho_id": id},
                dataType:'json',
                success: function(trabalho) {
                    document.getElementById("trabalho-id").value = trabalho.id;
                    document.getElementById("trabalho-nome-parecer").innerHTML = "Parecer do trabalho '"+trabalho.titulo+"'";
                    if(trabalho.parecer == true){
                        aprovado.show();
                    }else if(trabalho.parecer == false){
                        reprovado.show();

                    }
                }
            });
        }

        function atualizarInputAprovar(resultado){
            document.getElementById('parecer-final-input').value = resultado;
            var form = document.getElementById('form-avaliar-trabalho');
            form.submit();
        }
    </script>
@endsection
@endsection
