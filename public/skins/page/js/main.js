var videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 1,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      controls: 0,
      disablekb: 1,
      enablejsapi: 0,
      iv_load_policy: 3,
    };
    const video = {
      videoId: datavideo,
      suggestedQuality: "hd1080",
    };
    videos[videos.length] = new YT.Player(idvideo, {
      videoId: datavideo,
      playerVars: playerDefaults,
      events: {
        onReady: onAutoPlay,
        onStateChange: onFinish,
      },
    });
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    event.target.mute();
  }

  function onFinish(event) {
    if (event.data === 0) {
      event.target.playVideo();
    }
  }
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]',
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl),
  );

  // Manejar el envío del formulario del modal
  $("#formCarnet").on("submit", function (e) {
    e.preventDefault();
    const numeroCarnet = $("#numeroCarnet").val().trim();
    if (!numeroCarnet) {
      Swal.fire({
        icon: "error",
        title: "Campo requerido",
        text: "Por favor, ingresa tu número de carnet.",
        confirmButtonText: "Cerrar",
        confirmButtonColor: "#d33",
      });
      return;
    }
    const formData = new FormData(this);

    fetch("/page/validar", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (!data.success) {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message,
            confirmButtonText: "Cerrar",
            confirmButtonColor: "#d33",
          });
        } else {
          window.location.href = data.redirect || "/page/productos";
        }
      })
      .catch((error) => {
        console.log(error.message);

        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ha ocurrido un error inesperado.",
          confirmButtonText: "Cerrar",
          confirmButtonColor: "#d33",
        });
      });
  });

  // Funcionalidad del carrito

  // Agregar item al carrito
  $(document).on("click", ".btn-agregar-carrito", function (e) {
    e.preventDefault(); // Prevenir que se abra el modal
    const productoId = $(this).data("producto");
    const cantidad = $(this).data("cantidad") || 1;

    agregarAlCarrito(productoId, cantidad);
  });

  // Función para agregar al carrito
  function agregarAlCarrito(productoId, cantidad) {
    const formData = new FormData();
    formData.append("producto", productoId);
    formData.append("cantidad", cantidad);

    fetch("/page/carrito/additem", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        mostrarNotificacion("Producto agregado al carrito", "success");
        // traercarrito();
        actualizarContadorCarrito();
      })
      .catch((error) => {
        console.error("Error al agregar al carrito:", error);
        mostrarNotificacion("Error al agregar el producto", "error");
      });
  }

  // Función para traer el carrito
  function traercarrito(ver) {
    $.get("/page/carrito", function (res) {
      $("#micarrito").html(res);
      calcularvalorcarrito();

      if (parseInt(ver) == 1) {
        abrirCarrito();
      }
    });
  }

  function abrirCarrito() {
    $(".caja-carrito").addClass("show");
  }
  window.cerrarCarrito = function () {
    $(".caja-carrito").removeClass("show");
  };
  // Función para calcular el valor del carrito
  function calcularvalorcarrito() {
    // Recalcular sumando elementos con clase 'valortotal' o con id que empiece por 'valortotal'
    let total = 0;
    $(".valortotal, [id^='valortotal']").each(function () {
      const text = $(this).text();
      const valor =
        parseFloat(
          text.replace("$", "").replace(/\./g, "").replace(",", "."),
        ) || 0;
      total += valor;
    });
    total = Math.max(0, total);
    $("#totalpagar").text("$" + total.toLocaleString("es-CO"));
  }

  // Mostrar el carrito (ahora usa traercarrito)
  function mostrarCarrito() {
    traercarrito(1);
  }

  // Actualizar el carrito (recargar contenido)
  function actualizarCarrito() {
    traercarrito(0);
  }

  // Actualizar contador del carrito
  function actualizarContadorCarrito() {
    // Para obtener el count, podemos parsear el HTML del carrito o hacer una llamada adicional
    // Asumiendo que hay un endpoint /page/carrito/count que devuelve JSON {count: N}
    // Si no, podemos contar de la vista actualizada
    $.get("/page/carrito", function (html) {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, "text/html");
      const items = doc.querySelectorAll(".item-carrito");
      let totalItems = 0;
      items.forEach((item) => {
        const cantidad =
          parseInt(item.querySelector(".cantidad_item").value) || 0;
        totalItems += cantidad;
      });
      let totalPrice = "$0";
      const totalElement = doc.querySelector("#totalpagar");
      if (totalElement) {
        totalPrice = totalElement.textContent.trim();
      }
      $(".badge-cantidad").text(totalItems);
      if (totalItems > 0) {
        $(".badge-cantidad").show();
      } else {
        $(".badge-cantidad").hide();
      }
      $(".order-count").text(totalItems + " Productos seleccionados");
      $(".view-order-button span:last-child").text(totalPrice);

      // Actualizar thumbnails
      $.getJSON("/page/carrito/getCarritoJson", function (productos) {
        actualizarThumbnails(productos);
      }).fail(function () {
        actualizarThumbnails([]);
      });
    }).fail(function () {
      console.error("Error al actualizar contador");
      $(".order-count").text("0 Productos seleccionados");
      $(".view-order-button span:last-child").text("$0");
      $(".badge-cantidad").hide();
      actualizarThumbnails([]);
    });
  }

  // Función para actualizar thumbnails
  function actualizarThumbnails(productos) {
    const thumbnailsContainer = $(".order-thumbnails");
    if (productos.length === 0) {
      thumbnailsContainer.hide();
      return;
    }
    thumbnailsContainer.show();
    const firstProduct = productos[0];
    $(".thumbnail").css(
      "background-image",
      `url('/images/${firstProduct.imagen}')`,
    );
    if (productos.length === 1) {
      $(".thumbnail-count").hide();
    } else {
      $(".thumbnail-count")
        .text(`+${productos.length - 1}`)
        .show();
    }
  }

  // Mostrar notificación
  function mostrarNotificacion(mensaje, tipo) {
    // Usar Swal o un div de notificación
    Swal.fire({
      icon: tipo,
      title: tipo === "success" ? "¡Listo!" : "Error",
      text: mensaje,
      timer: 2000,
      showConfirmButton: false,
    });
  }

  // Abrir carrito con botón flotante
  $(document).on("click", ".btn-carrito-flotante", function () {
    mostrarCarrito();
  });

  // Abrir carrito con icono del header
  $(document).on("click", ".btn-carrito-header", function () {
    mostrarCarrito();
  });

  // Abrir carrito con View Order button
  $(document).on("click", ".view-order-button", function () {
    $.get("/page/carrito", function (data) {
      $("#carrito-modal .modal-body").html(data);
      $("#carrito-modal").modal("show");
    });
  });

  // Cerrar carrito
  $(document).on("click", ".btn-cerrar-carrito", function () {
    $(".caja-carrito").removeClass("show");
  });

  // Cerrar carrito al hacer clic en overlay
  $(document).on("click", ".carrito-overlay", function () {
    $(".caja-carrito").removeClass("show");
  });

  // Eliminar item del carrito
  $(document).on("click", ".btn-eliminar-carrito", function () {
    const productoId = $(this).data("id");
    eliminarDelCarrito(productoId);
  });

  // Cambiar cantidad
  $(document).on("click", ".btn-plus", function () {
    const productoId = $(this).data("id");
    const input = $(`#cantidad${productoId}`);
    let cantidad = parseInt(input.val()) || 0;
    cantidad++;
    input.val(cantidad);
    cambiarCantidad(productoId, cantidad);
  });

  $(document).on("click", ".btn-minus", function () {
    const productoId = $(this).data("id");
    const input = $(`#cantidad${productoId}`);
    let cantidad = parseInt(input.val()) || 0;
    if (cantidad > 1) {
      cantidad--;
      input.val(cantidad);
      cambiarCantidad(productoId, cantidad);
    } else if (cantidad === 1) {
      eliminarDelCarrito(productoId);
    }
  });

  // Función para eliminar del carrito
  function eliminarDelCarrito(productoId) {
    const formData = new FormData();
    formData.append("producto", productoId);

    fetch("/page/carrito/deleteitem", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        traercarrito(0);
        actualizarContadorCarrito();
        // Actualizar modal si está abierto
        if ($("#carrito-modal").hasClass("show")) {
          $.get("/page/carrito", function (data) {
            $("#carrito-modal .modal-body").html(data);
          });
        }
        mostrarNotificacion("Producto eliminado del carrito", "success");
      })
      .catch((error) => {
        console.error("Error al eliminar del carrito:", error);
        mostrarNotificacion("Error al eliminar el producto", "error");
      });
  }

  // Función para cambiar cantidad
  function cambiarCantidad(productoId, cantidad) {
    const formData = new FormData();
    formData.append("producto", productoId);
    formData.append("cantidad", cantidad);

    fetch("/page/carrito/changecantidad", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        traercarrito(0);
        actualizarContadorCarrito();
        // Actualizar modal si está abierto
        if ($("#carrito-modal").hasClass("show")) {
          $.get("/page/carrito", function (data) {
            $("#carrito-modal .modal-body").html(data);
          });
        }
      })
      .catch((error) => {
        console.error("Error al cambiar cantidad:", error);
      });
  }

  // Inicializar contador al cargar
  actualizarContadorCarrito();
});
