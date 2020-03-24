<div class="form-group">
	@csrf
	<label for="content"><h5>Contenido del Acta <small id="smsg" style="display:none">GUARDANDO CAMBIOS...</small></h5></label>
	<textarea name="content" id="editor1" class="form-control" rows="17" cols="80">
		{{$act->content}}
	</textarea>
	<hr>
	<label for="agreements"> <h5>Acuerdos</h5></label>
	<textarea name="agreements" id="editor2" class="form-control" rows="17" cols="80">
		{{$act->agreements}}
	</textarea>
</div>
