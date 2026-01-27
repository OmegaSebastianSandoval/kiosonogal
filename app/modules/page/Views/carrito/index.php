<div class="d-flex align-items-center justify-content-center">
    <i class="fas fa-shopping-cart icono-cart"></i>
    <h2 class="titulo-carrito">Carrito de compras</h2>
</div>
<?php $valortotal = 0; ?>
<div class="container fondo-carrito">

    <?php if (count($this->carrito) > 0) { ?>
        <?php foreach ($this->carrito as $key => $carrito) { ?>
            <?php

            $producto = $carrito['detalle'];
            $valor = $carrito['cantidad'] * $producto->producto_precio;
            $valortotal = $valortotal + $valor;

            ?>
            <div class="row item-carrito">
                <div class="col-3 cajax">
                    <img src="/images/<?php echo $producto->producto_imagen; ?>"
                        alt="<?php echo $producto->producto_nombre; ?>">
                </div>
                <div class="col-5 cajax2">
                    <h4 class="titulo-product-carrito"><?php echo $producto->producto_nombre; ?></h4>
                    <div>Unid. <span
                            style=" font-size: 14px;font-weight: 600;">$<?php echo number_format($producto->producto_precio, 0, ',', '.'); ?></span>
                    </div>
                    <div class="precio-product-carrito">Total: <span id="valortotal<?php echo $producto->producto_id; ?>"
                            class="valortotal"
                            style="font-size: 16px;font-weight: 700;">$<?php echo number_format($producto->producto_precio * $carrito['cantidad'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <?php
                $max = 20;
                if ($producto->producto_cantidad < $max) {
                    $max = $producto->producto_cantidad;
                }
                if ($producto->producto_limite_pedido != "" and $producto->producto_limite_pedido < $max) {
                    $max = $producto->producto_limite_pedido;
                }
                ?>
                <div class="col-3 cajax text-center">
                    <div class="inptt" align="left">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">


                            <button class="btn btn-outline-secondary btn-minus" data-id="<?php echo $producto->producto_id; ?>"
                                type="button" id="button-addon2"><i class="fas fa-minus"></i></button>

                            <input type="text" class="border-0 form-control cantidad_item"
                                id="cantidad<?php echo $producto->producto_id; ?>" placeholder=""
                                value="<?php echo $carrito['cantidad']; ?>" min="0" max="<?php echo $max; ?>" disabled>

                            <button class="btn btn-outline-secondary btn-plus" data-id="<?php echo $producto->producto_id; ?>"
                                type="button" id="button-addon1"><i class="fas fa-plus"></i></button>

                        </div>
                    </div>
                </div>

                <div class="col-1 text-end d-flex justify-content-end div_eliminar p-0 m-0">
                    <a class="btn-eliminar-carrito mt-auto mb-auto" data-id="<?php echo $producto->producto_id; ?>"
                        title="Eliminar producto">
                        <i class="fas fa-trash-alt eliminar"></i>
                    </a>
                </div>

                <input type="hidden" id="valorunitario<?php echo $producto->producto_id; ?>"
                    value="<?php echo $producto->producto_precio; ?>">
            </div>
        <?php } ?>
        <div class="row justify-content-between total-carrito">
            <div class="col-6 valor_pagar">

                Valor a pagar:
            </div>
            <div class="col-6 text-end">
                <div class="valor" id="totalpagar">$<?php echo number_format($valortotal, 0, ',', '.') ?></div>
            </div>

            <div class="col-12 mt-3">
                <div class="pagar">
                    <a href="#" class="btn btn-sm btn-primary-carrito-datafono">
                        <i class="fas fa-credit-card me-2"></i>Pagar con datáfono
                    </a>
                </div>
                <?php if ($this->socio && $this->socio->SBE_CODI && $this->socio->SBE_CUPO) { ?>
                    <div class="pagar">
                        <button type="button" class="btn btn-sm btn-primary-carrito" data-bs-toggle="modal"
                            data-bs-target="#modalCargo">
                            <i class="fas fa-money-bill-wave me-2"></i>Pagar con cargo a la acción
                        </button>
                    </div>
                <?php } ?>

                <div class="pagar">
                    <a class="btn btn-sm btn-primary-carrito-seguir pointer" onclick="cerrarCarrito();">
                        <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCargo" tabindex="-1" aria-labelledby="modalCargoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCargoLabel">Confirmar pago con cargo a la acción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/page/pagar/cargo" method="post" id="formCarritoCargo" >
                        <h6>Resumen del pedido:</h6>
                        <ul>
                            <?php foreach ($this->carrito as $carrito) { ?>
                                <li><?php echo $carrito['detalle']->producto_nombre; ?> (Cant:
                                    <?php echo $carrito['cantidad']; ?>)
                                    -
                                    $<?php echo number_format($carrito['cantidad'] * $carrito['detalle']->producto_precio, 0, ',', '.'); ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <p><strong>Total: $<?php echo number_format($valortotal, 0, ',', '.'); ?></strong></p>
                        <div class="mb-3">
                            <label for="cuotas">Selecciona el número de cuotas:</label>
                            <select id="cuotas" name="cuotas" class="form-select" required>
                                <option value="">Selecciona...</option>
                                <option value="1">1 cuota</option>
                                <option value="2">2 cuotas</option>
                                <option value="3">3 cuotas</option>
                                <option value="4">4 cuotas</option>
                                <option value="5">5 cuotas</option>
                                <option value="6">6 cuotas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="lugar">Selecciona el lugar:</label>
                            <input type="number" id="lugar" name="lugar" class="form-control" min="1" max="20" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary-carrito">Aceptar y Pagar</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="logo-alert" align="center">
        <img src="/skins/page/images/logo.webp" alt="Logo Nogal" class="logo-header w-100">
    </div>
    <div class="mensaje-alert alert" align="center">
        <i class="fas fa-shopping-cart" style="font-size: 24px; margin-bottom: 10px;"></i>
        <p>No hay productos en tu carrito</p>
        <p style="font-size: 14px; ">¡Explora nuestro menú y agrega tus favoritos!</p>
    </div>
    <div class="pagar px-3">
        <a class="btn btn-sm btn-primary-carrito-seguir pointer" onclick="cerrarCarrito();">
            <i class="fas fa-shopping-bag me-2"></i>Ver menú
        </a>
    </div>
<?php } ?>