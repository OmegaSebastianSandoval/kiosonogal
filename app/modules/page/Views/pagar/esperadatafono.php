<style>
    body {
        background-color: #ffffff;
        /* Fondo blanco limpio */
        color: #333333;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        /* Evita scroll en kiosko */
        user-select: none;
        /* Evita selección accidental */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    /* Contenedor principal centrado */
    .payment-container {
        text-align: center;
        max-width: 600px;
        padding: 40px;
        border-radius: 20px;
        background-color: #f9f9f9;
        /* Fondo sutilmente gris para destacar */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        /* Sombra suave para profundidad */
    }

    /* Loader animado elegante */
    .loader {
        width: 80px;
        height: 80px;
        border: 6px solid #e0e0e0;
        border-top: 6px solid #007bff;
        /* Azul corporativo */
        border-radius: 50%;
        animation: spin 1.5s linear infinite;
        margin: 0 auto 30px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Ícono de tarjeta (SVG inline simple) */
    .card-icon {
        width: 60px;
        height: 40px;
        margin: 0 auto 20px;
        fill: #007bff;
    }

    /* Mensajes */
    .main-message {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333333;
    }

    .secondary-message {
        font-size: 18px;
        color: #666666;
        margin-bottom: 20px;
    }

    /* Estados adicionales (inicialmente ocultos) */
    .status-message {
        font-size: 20px;
        font-weight: 500;
        margin-top: 20px;
        display: none;
    }

    /* Estado aprobado */
    .approved .status-message {
        color: #28a745;
        display: block;
    }

    /* Estado rechazado */
    .rejected .status-message {
        color: #dc3545;
        display: block;
    }

    /* Estado error */
    .error .status-message {
        color: #dc3545;
        display: block;
    }

    /* Animación de fade-in para transiciones suaves */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Responsive para kioskos táctiles */
    @media (max-width: 768px) {
        .payment-container {
            padding: 20px;
        }

        .main-message {
            font-size: 24px;
        }

        .secondary-message {
            font-size: 16px;
        }
    }
</style>

<div class="payment-container fade-in" id="paymentContainer">
    <!-- Ícono de tarjeta -->
    <svg class="card-icon" viewBox="0 0 24 24">
        <path
            d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
    </svg>

    <!-- Loader -->
    <div class="loader" id="loader"></div>

    <!-- Mensajes -->
    <div class="main-message" id="mainMessage">Procesando pago con datáfono</div>
    <div class="secondary-message" id="secondaryMessage">Por favor, no retire su tarjeta hasta que se complete la
        transacción</div>
    <div class="status-message" id="statusMessage"></div>
</div>


<!--
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pedidoId = '<?php echo $this->pedidoId; ?>';
        const container = document.getElementById('paymentContainer');
        const loader = document.getElementById('loader');
        const mainMessage = document.getElementById('mainMessage');
        const secondaryMessage = document.getElementById('secondaryMessage');
        const statusMessage = document.getElementById('statusMessage');

        // Función para cambiar estado
        function setPaymentState(state, message) {
            container.className = 'payment-container fade-in ' + state;
            statusMessage.textContent = message;
            if (state !== 'processing') {
                loader.style.display = 'none';
                if (state === 'approved') {
                    mainMessage.textContent = 'Pago aprobado';
                    secondaryMessage.textContent = 'Redirigiendo al resumen...';
                } else if (state === 'rejected') {
                    mainMessage.textContent = 'Pago rechazado';
                    secondaryMessage.textContent = 'Intente nuevamente';
                } else if (state === 'error') {
                    mainMessage.textContent = 'Error en el pago';
                    secondaryMessage.textContent = 'Por favor contacte al personal';
                }
            }
        }

        // Estado inicial
        setPaymentState('processing', 'Comunicando con datáfono...');

        // Llamar al controlador para procesar el pago
        fetch('/page/pagar/procesardatafono?pedido=' + pedidoId, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del datáfono:', data);
            
            // Verificar la estructura de respuesta basada en tu controlador
            if (data.estado === 'OK' || data.status === 'approved') {
                setPaymentState('approved', 'Pago exitoso. Redirigiendo...');
                setTimeout(() => {
                    window.location.href = '/page/resumen?pedido=' + pedidoId;
                }, 2000);
            } else if (data.estado === 'ERROR' || data.status === 'rejected') {
                setPaymentState('rejected', 'Error en el pago: ' + (data.msg || 'Desconocido'));
                
                // Opcional: Redirigir después de un tiempo si es rechazado
                setTimeout(() => {
                    window.location.href = '/page/productos';
                }, 5000);
            } else {
                // Respuesta no reconocida
                setPaymentState('error', 'Respuesta inesperada del sistema');
                console.error('Respuesta no reconocida:', data);
            }
        })
        .catch(error => {
            console.error('Error en la comunicación:', error);
            setPaymentState('error', 'Error de conexión. Intente nuevamente.');
            
            // Opcional: Intentar nuevamente después de un tiempo
            setTimeout(() => {
                secondaryMessage.textContent = 'Reintentando en 5 segundos...';
                setTimeout(() => {
                    location.reload();
                }, 5000);
            }, 2000);
        });

        // Timeout de seguridad (si no hay respuesta en 1800 segundos)
        setTimeout(() => {
            if (container.classList.contains('processing')) {
                setPaymentState('error', 'Tiempo de espera agotado');
                secondaryMessage.textContent = 'Contacte al personal para asistencia';
            }
        }, 1800000);
    });
</script>
    -->