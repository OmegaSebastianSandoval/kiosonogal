<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>"
		data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->kiosko_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->kiosko_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-12 col-md-2 form-group d-grid">
					<label class="control-label">Estado</label>
					<input type="checkbox" name="kiosko_estado" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'kiosko_estado') == 1) {
						echo "checked";
					} ?>></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">

				<div class="col-12 col-md-3 form-group">
					<label for="kiosko_codigo" class="control-label">Codigo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->kiosko_codigo; ?>" name="kiosko_codigo" id="kiosko_codigo"
							class="form-control" required
							data-remote="/administracion/kioskos/validation?csrf=1&codigo=<?= $this->content->kiosko_codigo; ?><?php if ($this->content->kiosko_id) { ?>&id=<?= $this->content->kiosko_id; ?><?php } ?>">
					</label>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-12 col-md-3 form-group">
					<label for="kiosko_localizacion" class="control-label">Localización</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->kiosko_localizacion; ?>" name="kiosko_localizacion"
							id="kiosko_localizacion" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-2 form-group">
					<label for="kiosko_fecha_activacion" class="control-label">Fecha activación</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->kiosko_fecha_activacion; ?>" name="kiosko_fecha_activacion"
							id="kiosko_fecha_activacion" class="form-control" readonly>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-2 form-group">
					<label for="kiosko_pin" class="control-label">Pin</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-key"></i></span>
						</div>
						<input type="password" value="" name="kiosko_pin" id="kiosko_pin" class="form-control" maxlength="6"
							pattern="[0-9]{6}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" <?php if (!$this->content->kiosko_id) { ?>required <?php } ?> data-remote="/administracion/kioskos/validarpin">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 col-md-2 form-group">
					<label for="kiosko_pinr" class="control-label">Repita Pin</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono "><i class="fas fa-key"></i></span>
						</div>
						<input type="password" value="" name="kiosko_pinr" id="kiosko_pinr" data-match="#kiosko_pin"
							data-match-error="Los dos PIN no son iguales" class="form-control" maxlength="6" pattern="[0-9]{6}"
							oninput="this.value = this.value.replace(/[^0-9]/g, '')" <?php if (!$this->content->kiosko_id) { ?>required <?php } ?>>
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