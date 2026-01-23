<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
		data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->categoria_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->categoria_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-2 form-group d-grid">
					<label class="control-label">Estado</label>
					<input type="checkbox" name="categoria_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'categoria_estado') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">

				<div class="col-4 form-group">
					<label for="categoria_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->categoria_nombre; ?>" name="categoria_nombre"
							id="categoria_nombre" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<?php if ($this->padre) { ?>

					<div class="col-4 form-group">
						<label class="control-label">Padre</label>
						<label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono  "><i class="far fa-list-alt"></i></span>
							</div>
							<select class="form-control" name="categoria_padre" >
								<option value="">Seleccione...</option>
								<?php foreach ($this->list_categoria_padre as $key => $value) { ?>
									<option <?php if ($this->getObjectVariable($this->content, "categoria_padre") == $key) {
										echo "selected";
									} ?> 
									
									<?php if ($key == $this->padre) {
										echo "selected";
									} ?>
									value="<?php echo $key; ?>" /> <?= $value; ?></option>
								<?php } ?>
							</select>
						</label>
						<div class="help-block with-errors"></div>
					</div>
				<?php } ?>
				<div class="col-4 form-group">
					<label for="categoria_imagen">Imagen</label>
					<input type="file" name="categoria_imagen" id="categoria_imagen" class="form-control  file-image"
						data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png">
					<div class="help-block with-errors"></div>
					<?php if ($this->content->categoria_imagen) { ?>
						<div id="imagen_categoria_imagen">
							<img src="/images/<?= $this->content->categoria_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button"
									onclick="eliminarImagen('categoria_imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i
										class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>
				<div class="col-12 form-group">
					<label for="categoria_descripcion" class="form-label">Descripci&oacute;n</label>
					<textarea name="categoria_descripcion" id="categoria_descripcion" class="form-control tinyeditor"
						rows="10"><?= $this->content->categoria_descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>


			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?padre=<?= $this->padre ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>