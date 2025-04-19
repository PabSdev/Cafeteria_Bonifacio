import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

// Inicializar Pusher globalmente
window.Pusher = Pusher

document.addEventListener('DOMContentLoaded', function () {
    // Funcionalidad de las pestañas
    const tabButtons = document.querySelectorAll('.tab-button')
    tabButtons.forEach((button) => {
        button.addEventListener('click', function (e) {
            e.preventDefault()

            // Quitar clase activa de todos los botones
            tabButtons.forEach((btn) => {
                btn.classList.remove('active', 'border-amber-500')
                btn.classList.add('border-transparent')
            })

            // Añadir clase activa al botón clickeado
            this.classList.add('active', 'border-amber-500')
            this.classList.remove('border-transparent')

            // Ocultar todos los contenidos
            const tabContents = document.querySelectorAll('.tab-content')
            tabContents.forEach((content) => {
                content.classList.add('hidden')
            })

            // Mostrar el contenido correspondiente
            const targetId = this.getAttribute('data-target')
            document.getElementById(targetId).classList.remove('hidden')
        })
    })

    // Añadir clase de carga a los formularios cuando se envían
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', function () {
            this.classList.add('loading')
        })
    })

    // Obtener datos de Reverb desde los meta tags
    const REVERB_APP_KEY = document
        .querySelector('meta[name="reverb-key"]')
        .getAttribute('content')
    const REVERB_HOST = document
        .querySelector('meta[name="reverb-host"]')
        .getAttribute('content')
    const REVERB_PORT = document
        .querySelector('meta[name="reverb-port"]')
        .getAttribute('content')
    const REVERB_SCHEME = document
        .querySelector('meta[name="reverb-scheme"]')
        .getAttribute('content')
    const CSRF_TOKEN = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')

    // Configuración de Echo con Reverb
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: REVERB_APP_KEY,
        wsHost: REVERB_HOST,
        wsPort: parseInt(REVERB_PORT),
        wssPort: parseInt(REVERB_PORT),
        forceTLS: REVERB_SCHEME === 'https',
        enabledTransports: ['ws', 'wss'],
        disableStats: true,
    })

    // Monitoreo de la conexión
    window.Echo.connector.pusher.connection.bind('connected', () => {
        console.log('✅ Conectado a Reverb WebSockets!')
        const statusElement = document.getElementById('connection-status')
        if (statusElement) {
            statusElement.textContent = 'Conectado ✅'
            statusElement.classList.remove('bg-gray-500')
            statusElement.classList.add('bg-green-500')
        }
    })

    window.Echo.connector.pusher.connection.bind('disconnected', () => {
        console.log('❌ Desconectado de Reverb WebSockets')
        const statusElement = document.getElementById('connection-status')
        if (statusElement) {
            statusElement.textContent = 'Desconectado ❌'
            statusElement.classList.remove('bg-green-500')
            statusElement.classList.add('bg-red-500')
        }
    })

    // Para fines de depuración
    window.Echo.connector.pusher.bind_global((event, data) => {
        console.log(`Evento recibido: ${event}`, data)
    })

    // Escuchar el canal 'orders' y el evento 'OrderCreated'
    window.Echo.channel('orders')
        .listen('OrderCreated', (data) => {
            console.log('Nuevo pedido recibido:', data)

            // Crear HTML para la nueva tarjeta
            const orderHTML = `
                <div class="bg-white shadow-md rounded-lg p-4 highlight-new" id="order-${
                    data.order.id
                }">
                    <h2 class="text-lg font-bold text-gray-800">Pedido #${
                        data.order.id
                    }</h2>
                    <p class="text-gray-600">Cliente: ${
                        data.order.customer_name
                    }</p>
                    <p class="text-gray-600">Total: ${parseFloat(
                        data.order.total
                    ).toFixed(2)}€</p>
                    <p class="text-gray-600">Estado: <span class="font-bold">Pendiente</span></p>
                    
                    <form action="/order/update/${
                        data.order.id
                    }" method="POST" class="mt-4">
                        <input type="hidden" name="_token" value="${CSRF_TOKEN}">
                        <input type="hidden" name="_method" value="PUT">
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="pendiente" selected>Pendiente</option>
                            <option value="en preparación">En preparación</option>
                            <option value="completado">Completado</option>
                        </select>
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Actualizar</button>
                    </form>
                </div>
            `

            // Añadir la nueva tarjeta al principio del contenedor de pendientes
            const container = document.getElementById('pending-orders')
            if (container) {
                container.innerHTML = orderHTML + container.innerHTML

                // Reproducir un sonido para notificar
                playNotificationSound()

                // Asegurarnos de que la pestaña de pendientes esté seleccionada
                const pendingTab = document.querySelector(
                    '[data-target="pending-orders"]'
                )
                if (pendingTab) pendingTab.click()
            }
        })
        .listen('OrderStatusUpdated', (data) => {
            console.log('Pedido actualizado:', data)

            // Obtener el pedido actualizado
            const order = data.order
            const orderElement = document.getElementById(`order-${order.id}`)

            if (orderElement) {
                // Eliminar el pedido actual de su lista
                orderElement.remove()

                // Si el estado es completado, añadirlo a la lista de completados sin opciones de actualización
                if (order.status === 'completado') {
                    const completedContainer =
                        document.getElementById('completed-orders')
                    if (completedContainer) {
                        const completedHTML = `
                            <div class="bg-white shadow-md rounded-lg p-4 highlight-new" id="order-${
                                order.id
                            }">
                                <h2 class="text-lg font-bold text-gray-800">Pedido #${
                                    order.id
                                }</h2>
                                <p class="text-gray-600">Cliente: ${
                                    order.customer_name
                                }</p>
                                <p class="text-gray-600">Total: ${parseFloat(
                                    order.total
                                ).toFixed(2)}€</p>
                                <p class="text-gray-600">Estado: <span class="font-bold text-green-600">Completado</span></p>
                                <p class="text-xs text-gray-500 mt-2">Este pedido ha sido completado y no puede modificarse</p>
                            </div>
                        `
                        completedContainer.innerHTML =
                            completedHTML + completedContainer.innerHTML
                    }
                } else {
                    // Si es pendiente o en preparación, añadirlo a la lista correspondiente
                    const targetContainer =
                        order.status === 'pendiente'
                            ? document.getElementById('pending-orders')
                            : document.getElementById('preparation-orders')

                    if (targetContainer) {
                        const updatedHTML = `
                            <div class="bg-white shadow-md rounded-lg p-4 highlight-new" id="order-${
                                order.id
                            }">
                                <h2 class="text-lg font-bold text-gray-800">Pedido #${
                                    order.id
                                }</h2>
                                <p class="text-gray-600">Cliente: ${
                                    order.customer_name
                                }</p>
                                <p class="text-gray-600">Total: ${parseFloat(
                                    order.total
                                ).toFixed(2)}€</p>
                                <p class="text-gray-600">Estado: <span class="font-bold">${
                                    order.status.charAt(0).toUpperCase() +
                                    order.status.slice(1)
                                }</span></p>
                                
                                <form action="/order/update/${
                                    order.id
                                }" method="POST" class="mt-4">
                                    <input type="hidden" name="_token" value="${CSRF_TOKEN}">
                                    <input type="hidden" name="_method" value="PUT">
                                    <select name="status" class="border rounded px-2 py-1">
                                        <option value="pendiente" ${
                                            order.status === 'pendiente'
                                                ? 'selected'
                                                : ''
                                        }>Pendiente</option>
                                        <option value="en preparación" ${
                                            order.status === 'en preparación'
                                                ? 'selected'
                                                : ''
                                        }>En preparación</option>
                                        <option value="completado">Completado</option>
                                    </select>
                                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Actualizar</button>
                                </form>
                            </div>
                        `
                        targetContainer.innerHTML =
                            updatedHTML + targetContainer.innerHTML
                    }
                }
            }
        })
})

// Función para reproducir un sonido de notificación
function playNotificationSound() {
    try {
        const audio = new Audio('/sounds/notification.mp3')
        audio.play()
    } catch (e) {
        console.error('Error al reproducir sonido:', e)
    }
}
