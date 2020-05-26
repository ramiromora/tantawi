<div class="form-group">
	<table>
        @forelse ($companys as $empresa)
        <thead>
            <tr>
                <th>Miembros: {{$empresa->name}}</th>
            </tr>
        </thead>
        @php
            $invitados = $empresa->guests()->get();
            $participantes = $act->guests()->pluck('id')->toarray();
        @endphp
            @forelse ($invitados as $item)
                <tr>
                    <td>
                        <input type="checkbox" name="guests[]" value="{{$item->id}}" id="g{{$item->id}}" {{(in_array($item->id,$participantes))? 'checked':''}}>
                        <label for="g{{$item->id}}"> {{ $item->name}} - [{{$item->description}}]</label><br>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        NO HAY PERSONAL REGISTRADO
                    </td>
                </tr>
            @endforelse
            <tr>
                <td>
                    <button type="button" onclick="opfrm({{$empresa->id}})" class="btn btn-alt-info" data-toggle="modal" data-target="#modal-popout"><i class="fa fa-plus"></i> Agregar participante</button>
                </td>
            </tr>
        @empty
            
        @endforelse
        
    </table>
</div>

