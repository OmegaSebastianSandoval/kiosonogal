
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->impuesto_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->impuesto_id; ?>" />
			<?php }?>
			<div class="row">
		<div class="col-2 form-group">
			<label   class="control-label">Estado</label>
				<input type="checkbox" name="impuesto_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'impuesto_estado') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
				<div class="col-5 form-group">
					<label for="impuesto_nombre"  class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->impuesto_nombre; ?>" name="impuesto_nombre" id="impuesto_nombre" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-5 form-group">
					<label for="impuesto_porcentaje"  class="control-label">Porcentaje</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->impuesto_porcentaje; ?>" name="impuesto_porcentaje" id="impuesto_porcentaje" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>