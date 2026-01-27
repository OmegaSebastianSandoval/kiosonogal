
<?php $valortotal = 0; ?>
<div class=" fondo-carrito">

    <?php if (count($this->carrito) > 0) { ?>
        <?php foreach ($this->carrito as $key => $carrito) { ?>
            <?php

            $producto = $carrito['detalle'];
            $valor = $carrito['cantidad'] * $producto->producto_precio;
            $valortotal = $valortotal + $valor;

            ?>
            <div class="row item-carrito g-0 ">
                <div class="col-3 cajax">
                    <img src="/images/<?php echo $producto->producto_imagen; ?>"
                        alt="<?php echo $producto->producto_nombre; ?>">
                </div>
                <div class="col-5 cajax2">
                    <h4 class="titulo-product-carrito"><?php echo $producto->producto_nombre; ?></h4>
                    <div>Valor unitario: <span>$<?php echo number_format($producto->producto_precio, 0, ',', '.'); ?></span>
                    </div>
                    <div class="precio-product-carrito">Total: <span id="valortotal<?php echo $producto->producto_id; ?>"
                            class="valortotal">$<?php echo number_format($producto->producto_precio * $carrito['cantidad'], 0, ',', '.') ?></span>
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
        <div class="row justify-content-end total-carrito">

            <div class="col-12 text-end d-flex align-items-center justify-content-end gap-2">
                <span class="valor_pagar">
                    TOTAL A PAGAR:
                </span>
                <div class="valor" id="totalpagar">$<?php echo number_format($valortotal, 0, ',', '.') ?></div>
            </div>

            <div class="col-12">
                <div class="pagar">
                    <a href="/page/compra" class="btn btn-sm btn-primary-carrito">
                        <i class="fas fa-credit-card me-2"></i>Ir a pagar
                    </a>
                </div>

                <div class="pagar">
                    <a class="btn btn-sm btn-primary-carrito-seguir pointer" onclick="cerrarCarrito();">
                        <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
                    </a>
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