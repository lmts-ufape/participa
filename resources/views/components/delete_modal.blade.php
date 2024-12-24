
<div class="modal fade" id="deleteModal{{$entity_id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Deletar</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route($route, [$param => $entity_id])}}" method="post">
                @csrf
                @method('delete')

                @isset($element)
                    <input type="hidden" name="{{$param_element}}" id="{{$param_element}}" value="{{$element}}">
                @endisset

                <p>Tem certeza que deseja excluir este item?</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </div>
            </form>
        </div>

        </div>
    </div>
</div>
