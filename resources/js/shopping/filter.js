document.addEventListener('DOMContentLoaded', function () {
  // Estado de la aplicación
  const state = {
    activeCategory: 'all', // Categoría activa (por defecto: "Todos")
  };

  // Elementos del DOM
  const elements = {
    categoryButtons: document.querySelectorAll('.category-button'), // Botones de categorías
    productItems: document.querySelectorAll('.product-item'), // Productos
  };

  // Función para filtrar productos por categoría
  function filterProductsByCategory(category) {
    state.activeCategory = category;

    // Actualizar los botones de categoría (añadir/quitar clase "active")
    elements.categoryButtons.forEach((button) => {
      if (button.dataset.category === category) {
        button.classList.add('active');
      } else {
        button.classList.remove('active');
      }
    });

    // Mostrar/ocultar productos según la categoría seleccionada
    elements.productItems.forEach((product) => {
      const productCategory = product.dataset.category;

      if (category === 'all' || productCategory === category) {
        product.style.display = 'flex'; // Mostrar el producto
        setTimeout(() => {
          product.style.opacity = '1';
          product.style.transform = 'scale(1)';
        }, 10); // Animación de entrada
      } else {
        product.style.opacity = '0';
        product.style.transform = 'scale(0.95)';
        setTimeout(() => {
          product.style.display = 'none'; // Ocultar el producto
        }, 200); // Animación de salida
      }
    });
  }

  // Inicializar la funcionalidad de filtrado
  function init() {
    // Añadir eventos de clic a los botones de categoría
    elements.categoryButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const category = button.dataset.category;
        filterProductsByCategory(category);
      });
    });
  }

  // Iniciar la funcionalidad
  init();
});
