document.addEventListener('DOMContentLoaded', function () {
  // Inicializar Stripe
  const stripe = Stripe(
    'pk_test_51REPUHFzQ3LnatYualxstg868hE42rQHYhbZ9VuJ5vvYXrwogUWvs1ZfmnGdtFXTf9ZoUfF8J7aZK1nEH3FSmd3x00LpwzkraU'
  ); // Reemplaza con tu clave pública
  const elementsStripe = stripe.elements();
  const cardElement = elementsStripe.create('card');
  cardElement.mount('#card-element');

  // Función para procesar el pago con Stripe
  async function processStripePayment(amount) {
    try {
      // Crear un PaymentIntent desde el servidor
      const response = await fetch('/create-payment-intent', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ amount }),
      });

      if (!response.ok) {
        throw new Error('Error al crear el PaymentIntent');
      }

      const { clientSecret } = await response.json();

      // Confirmar el pago con Stripe
      const { error, paymentIntent } = await stripe.confirmCardPayment(
        clientSecret,
        {
          payment_method: {
            card: cardElement,
            billing_details: {
              name: 'Nombre del cliente', // Puedes personalizar esto
            },
          },
        }
      );

      if (error) {
        console.error('Error en el pago:', error.message);
        alert('Hubo un problema con el pago.');
      } else if (paymentIntent && paymentIntent.status === 'succeeded') {
        alert('¡Pago completado con éxito!');
        // Aquí puedes realizar acciones adicionales, como limpiar el carrito
      }
    } catch (err) {
      console.error('Error en el proceso de pago:', err.message);
      alert('Hubo un problema al procesar el pago.');
    }
  }

  // Event listener para el botón de pago
  const payButton = document.querySelector('#checkout-button');
  if (payButton) {
    payButton.addEventListener('click', () => {
      const totalElement = document.querySelector('.cart-total');
      if (!totalElement) {
        alert('No se pudo obtener el total del carrito.');
        return;
      }

      const amount = parseFloat(totalElement.textContent) * 100; // Convertir a centavos
      if (isNaN(amount) || amount <= 0) {
        alert('El monto total no es válido.');
        return;
      }

      processStripePayment(amount);
    });
  }
});
