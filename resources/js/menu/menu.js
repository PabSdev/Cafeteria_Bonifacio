// Esperar a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function () {
  // Crear un observador de intersección para detectar cuando los elementos entran en el viewport
  const observer = new IntersectionObserver(
    (entries) => {
      // Iterar sobre cada elemento observado que ha cambiado su estado de visibilidad
      entries.forEach((entry) => {
        // Verificar si el elemento está actualmente visible en el viewport
        if (entry.isIntersecting) {
          // Añadir la clase 'fade-in' para activar la animación de entrada
          entry.target.classList.add('fade-in');

          // Dejar de observar este elemento ya que la animación solo debe ejecutarse una vez
          observer.unobserve(entry.target);
        }
      });
    },
    {
      // Configuración del observador: activar cuando al menos el 10% del elemento sea visible
      threshold: 0.1,
    }
  );

  // Seleccionar todos los elementos con la clase 'card-item' y comenzar a observarlos
  document.querySelectorAll('.card-item').forEach((item) => {
    observer.observe(item);
  });
});
