<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
		data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->producto_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->producto_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-12">
					<div class="alert alert-warning">
						<strong>Nota:</strong> El precio debe ir sin comas, ni puntos, ni s&iacute;mbolos de moneda.
					</div>
				</div>
				<div class="col-2 form-group d-grid">

					<label class="control-label">Activo</label>
					<input type="checkbox" name="producto_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'producto_estado') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 form-group d-grid">
					<label class="control-label">Nuevo</label>
					<input type="checkbox" name="producto_nuevo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'producto_nuevo') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 form-group d-grid">
					<label class="control-label">Destacado</label>
					<input type="checkbox" name="producto_destacado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'producto_destacado') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-6 form-group">
					<label for="producto_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_nombre; ?>" name="producto_nombre"
							id="producto_nombre" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-3 form-group">
					<label for="producto_imagen">Imagen</label>
					<input type="file" name="producto_imagen" id="producto_imagen" class="form-control  file-image"
						data-buttonName="btn-primary" accept="image/gif, image/jpg, image/jpeg, image/png">
					<div class="help-block with-errors"></div>
					<?php if ($this->content->producto_imagen) { ?>
						<div id="imagen_producto_imagen">
							<img src="/images/<?= $this->content->producto_imagen; ?>" class="img-thumbnail thumbnail-administrator" />
							<div><button class="btn btn-danger btn-sm" type="button"
									onclick="eliminarImagen('producto_imagen','<?php echo $this->route . "/deleteimage"; ?>')"><i
										class="glyphicon glyphicon-remove"></i> Eliminar Imagen</button></div>
						</div>
					<?php } ?>
				</div>

				<div class="col-3 form-group">
					<label for="producto_precio" class="control-label">Precio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_precio; ?>" name="producto_precio"
							id="producto_precio" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-3 form-group">
					<label for="producto_cantidad" class="control-label">Cantidad</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_cantidad; ?>" name="producto_cantidad"
							id="producto_cantidad" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label class="control-label">Categoria</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  "><i class="far fa-list-alt"></i></span>
						</div>
						<select id="producto_categoria" class="form-control" name="producto_categoria">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_producto_categoria as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "producto_categoria") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<!-- <div class="col-3 form-group">
					<label class="control-label">Subcategoria</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  "><i class="far fa-list-alt"></i></span>
						</div>
						<select id="producto_subcategoria" class="form-control" name="producto_subcategoria">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_producto_subcategoria as $key => $value) { ?>
								<option <?php if ($this->getObjectVariable($this->content, "producto_subcategoria") == $key) {
									echo "selected";
								} ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div> -->

				<!-- <div class="col-3 form-group">
					<label for="producto_codigo" class="control-label">C&oacute;digo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_codigo; ?>" name="producto_codigo"
							id="producto_codigo" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="producto_cantidad_minima" class="control-label">Cantidad m&iacute;nima</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_cantidad_minima; ?>" name="producto_cantidad_minima"
							id="producto_cantidad_minima" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div> -->
				<div class="col-3 form-group">
					<label for="producto_limite_pedido" class="control-label">L&iacute;mite pedido</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->producto_limite_pedido; ?>" name="producto_limite_pedido"
							id="producto_limite_pedido" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="producto_descripcion" class="form-label">Descripci&oacute;n</label>
					<textarea name="producto_descripcion" id="producto_descripcion" class="form-control tinyeditor"
						rows="10"><?= $this->content->producto_descripcion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
		<script>
			var subcategoriasPorCategoria = <?php echo json_encode($this->subcategorias_por_categoria); ?>;
			document.getElementById('producto_categoria').addEventListener('change', function () {
				var categoriaId = this.value;
				var subSelect = document.getElementById('producto_subcategoria');
				subSelect.innerHTML = '<option value="">Seleccione...</option>';
				if (categoriaId && subcategoriasPorCategoria[categoriaId]) {
					subcategoriasPorCategoria[categoriaId].forEach(function (sub) {
						var option = document.createElement('option');
						option.value = sub.id;
						option.textContent = sub.nombre;
						subSelect.appendChild(option);
					});
				}
			});
			// Inicializar si hay categoría seleccionada
			var initialCategoria = '<?php echo $this->getObjectVariable($this->content, "producto_categoria"); ?>';
			if (initialCategoria) {
				document.getElementById('producto_categoria').value = initialCategoria;
				document.getElementById('producto_categoria').dispatchEvent(new Event('change'));
				var initialSubcategoria = '<?php echo $this->getObjectVariable($this->content, "producto_subcategoria"); ?>';
				if (initialSubcategoria) {
					document.getElementById('producto_subcategoria').value = initialSubcategoria;
				}
			}
		</script>
	</form>
</div>