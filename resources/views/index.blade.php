<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <title>Cafeteria Bonifacio</title>
</head>

<body class="font-sans">
<!-- Navbar -->
<header id="navbar" class="fixed w-full top-0 left-0 z-50 bg-[#2c3e50]/95 shadow-md transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="#" class="flex items-center gap-2">
                <i class="fas fa-coffee text-2xl text-[#f39c12]"></i>
                <h2 class="text-xl font-bold text-[#f39c12]">Cafeteria Bonifacio</h2>
            </a>

            <!-- Menú principal (escritorio) -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#Inicio" class="nav-link text-[#f39c12] hover:text-[#e67e22]">Inicio</a>
                <a href="#Mision" class="nav-link text-[#f39c12] hover:text-[#e67e22]">Mision</a>
                <a href="#Menu" class="nav-link text-[#f39c12] hover:text-[#e67e22]">Menú</a>
                <a href="#SobreNosotros" class="nav-link text-[#f39c12] hover:text-[#e67e22]">Sobre Nosotros</a>
                <a href="#Contacto" class="nav-link text-[#f39c12] hover:text-[#e67e22]">Contacto</a>
                <a href="/login"
                   class="bg-[#f39c12] text-white px-4 py-2 rounded-md hover:bg-[#e67e22] transition-colors duration-300">
                    <i class="fas fa-user mr-2"></i>Login
                </a>
            </nav>

            <!-- Botón hamburguesa (visible en móviles) -->
            <button id="menu-toggle" class="md:hidden text-[#f39c12] focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Menú móvil -->
    <div id="mobile-menu" class="md:hidden hidden bg-[#2c3e50] border-t border-[#34495e]">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#Inicio" class="block py-3 px-4 text-[#f39c12] hover:bg-[#34495e] rounded-md">Inicio</a>
            <a href="#Menu" class="block py-3 px-4 text-[#f39c12] hover:bg-[#34495e] rounded-md">Menú</a>
            <a href="#SobreNosotros" class="block py-3 px-4 text-[#f39c12] hover:bg-[#34495e] rounded-md">Sobre
                Nosotros</a>
            <a href="#Contacto" class="block py-3 px-4 text-[#f39c12] hover:bg-[#34495e] rounded-md">Contacto</a>
            <div class="pt-4 pb-2">
                <a href="/login"
                   class="block w-full bg-[#f39c12] text-white py-3 px-4 rounded-md text-center font-medium hover:bg-[#e67e22]">
                    <i class="fas fa-user mr-2"></i>Login / Register
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Espaciador para compensar la navbar fija -->
<div class="h-16"></div>

<!-- Inicio -->
<section id="Inicio"
         class="flex justify-center items-center min-h-screen bg-[#2c3e50] text-[#ecf0f1] px-4 sm:px-8 md:px-12 py-20">
    <div class="flex justify-center items-center max-w-7xl w-full flex-col-reverse md:flex-row gap-12">
        <div class="w-full md:w-1/2 text-center md:text-left mb-5 md:mb-0 scroll-reveal">
            <span
                class="inline-block px-4 py-1 bg-[#f39c12]/20 text-[#f39c12] rounded-full text-sm font-medium mb-4 animate-pulse">
                Desde 1995
            </span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5 text-[#f39c12] animate__animated animate__fadeInUp">
                El mejor café de la ciudad
            </h2>
            <h3 class="text-xl sm:text-2xl mb-5 text-[#e67e22] animate__animated animate__fadeInUp animate__delay-1s">
                La mejor cafetería de Madrid
            </h3>
            <p class="text-base sm:text-lg leading-relaxed mb-8 animate__animated animate__fadeInUp animate__delay-2s">
                Disfruta de nuestros granos selectos, tostados con pasión y preparados con arte.
                Cada taza cuenta una historia de tradición, calidad y sabor inigualable.
            </p>
            <div
                class="flex flex-wrap gap-4 justify-center md:justify-start animate__animated animate__fadeInUp animate__delay-3s">
                <a href="/shopping" class="px-6 py-3 text-lg font-bold bg-[#f39c12] text-white rounded-lg hover:bg-[#e67e22]
                    hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-coffee mr-2"></i>Pedir Ahora
                </button>
                <a href="/menu" class="px-6 py-3 text-lg font-bold border-2 border-[#f39c12] text-[#f39c12] rounded-lg
                hover:bg-[#f39c12] hover:text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-book-open mr-2"></i>Ver Menú
                </a>
            </div>
        </div>
        <div class="w-full md:w-1/2 flex justify-center items-center scroll-reveal">
            <img
                src="https://www.somoselcafe.com.ar/img/novedades/87.jpg"
                class="w-full max-w-md rounded-xl shadow-2xl animate__animated animate__zoomIn"
                alt="Café">
        </div>
    </div>
</section>

<!-- Misión -->
<section id="Mision" class="py-20 bg-[#f5f5f5] text-[#2c3e50] px-4 sm:px-8 md:px-12">
    <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center gap-12">
        <div class="md:w-1/2 scroll-reveal">
            <div class="bg-white p-8 rounded-xl shadow-lg relative">
                <blockquote class="text-lg italic text-gray-600 mb-6">
                    "Un buen café no solo despierta el cuerpo, sino también el alma. En Cafetería Bonifacio, 
                    cada taza cuenta una historia y cada cliente forma parte de nuestra familia."
                </blockquote>
                <div class="grid grid-cols-2 gap-6 mt-8">
                    <div class="flex items-center">
                        <i class="fas fa-home text-3xl text-[#f39c12] mr-4"></i>
                        <span class="font-medium">Ambiente hogareño</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-heart text-3xl text-[#f39c12] mr-4"></i>
                        <span class="font-medium">Atención cercana</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-users text-3xl text-[#f39c12] mr-4"></i>
                        <span class="font-medium">Comunidad local</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-mug-hot text-3xl text-[#f39c12] mr-4"></i>
                        <span class="font-medium">Café de calidad</span>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 bg-[#f39c12] text-white w-16 h-16 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-xl"></i>
                </div>
            </div>
        </div>

        <div class="md:w-1/2 text-center md:text-left scroll-reveal mb-10 md:mb-0">
            <span class="inline-block px-4 py-1 bg-[#f39c12] text-white rounded-full text-sm font-medium mb-4">
                NUESTRA MISIÓN
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-5 text-[#f39c12]">Un hogar para cada madrileño</h2>
            <p class="text-base sm:text-lg mb-6 leading-relaxed">
                En Cafetería Bonifacio, nuestra misión va más allá de servir café. 
                Nos dedicamos a crear un espacio acogedor donde cualquier madrileño pueda sentirse 
                como en casa, un rincón de la ciudad donde escapar del bullicio diario.
            </p>
            <p class="text-base sm:text-lg mb-8 leading-relaxed">
                Creemos en el poder de una buena taza de café para unir personas, inspirar conversaciones 
                y crear momentos que perduran. Cada detalle de nuestro local, desde la música hasta la 
                iluminación, está pensado para que nuestros clientes encuentren aquí su segundo hogar.
            </p>

            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <a href="#SobreNosotros" class="px-6 py-3 text-lg font-bold bg-[#f39c12] text-white rounded-lg hover:bg-[#e67e22]
                    hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-users mr-2"></i>Conoce nuestro equipo
                </a>
                <a href="#Contacto" class="px-6 py-3 text-lg font-bold border-2 border-[#f39c12] text-[#f39c12] rounded-lg
                    hover:bg-[#f39c12] hover:text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-map-marker-alt mr-2"></i>Visítanos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Menú -->
<section id="Menu" class="py-20 bg-[#ecf0f1] text-[#2c3e50] px-4 sm:px-8 md:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 scroll-reveal">
            <span class="inline-block px-4 py-1 bg-[#f39c12] text-white rounded-full text-sm font-medium mb-4">
                NUESTRAS ESPECIALIDADES
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-5 text-[#e74c3c]">¡Descubre nuestro menú selecto!</h2>
            <p class="text-base sm:text-lg max-w-2xl mx-auto">
                Preparamos cada bebida y alimento con ingredientes de primera calidad,
                siguiendo recetas tradicionales con un toque de innovación.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Tarjeta de menú 1 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300
                transform hover:-translate-y-2 scroll-reveal">
                <div class="h-48 bg-gray-300 relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center bg-[#2c3e50] text-white">
                        <i class="fas fa-mug-hot text-6xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Café Especial</h3>
                        <span class="text-[#f39c12] font-bold">4.50€</span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Nuestro café de especialidad, seleccionado entre los mejores granos del mundo.
                    </p>
                    <button
                        class="w-full py-2 bg-[#f39c12] text-white rounded hover:bg-[#e67e22] transition-colors duration-300">
                        Añadir
                    </button>
                </div>
            </div>

            <!-- Tarjeta de menú 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300
                transform hover:-translate-y-2 scroll-reveal">
                <div class="h-48 bg-gray-300 relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center bg-[#2c3e50] text-white">
                        <i class="fas fa-cookie text-6xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Pasteles Caseros</h3>
                        <span class="text-[#f39c12] font-bold">3.75€</span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Deliciosos pasteles elaborados cada día en nuestra cocina con ingredientes naturales.
                    </p>
                    <button
                        class="w-full py-2 bg-[#f39c12] text-white rounded hover:bg-[#e67e22] transition-colors duration-300">
                        Añadir
                    </button>
                </div>
            </div>

            <!-- Tarjeta de menú 3 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300
                transform hover:-translate-y-2 scroll-reveal">
                <div class="h-48 bg-gray-300 relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center bg-[#2c3e50] text-white">
                        <i class="fas fa-blender text-6xl"></i>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Smoothies</h3>
                        <span class="text-[#f39c12] font-bold">5.25€</span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Refrescantes bebidas de frutas naturales, perfectas para cualquier momento del día.
                    </p>
                    <button
                        class="w-full py-2 bg-[#f39c12] text-white rounded hover:bg-[#e67e22] transition-colors duration-300">
                        Añadir
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="/menu">
                <button class="px-8 py-3 text-lg font-bold bg-[#f39c12] text-white rounded-lg hover:bg-[#e67e22]
                hover:shadow-lg transition-all duration-300">
                    Ver menú completo
                </button>
            </a>
        </div>
    </div>
</section>

<!-- Sobre Nosotros -->
<section id="SobreNosotros" class="py-20 bg-[#34495e] text-white px-4 sm:px-8 md:px-12">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
        <div class="md:w-1/2 scroll-reveal">
            <div class="bg-[#2c3e50] p-6 rounded-xl relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-300 h-48 rounded overflow-hidden flex items-center justify-center">
                        <i class="fas fa-store text-6xl text-[#2c3e50]"></i>
                    </div>
                    <div class="bg-gray-300 h-48 rounded overflow-hidden flex items-center justify-center">
                        <i class="fas fa-users text-6xl text-[#2c3e50]"></i>
                    </div>
                    <div class="bg-gray-300 h-48 rounded overflow-hidden flex items-center justify-center">
                        <i class="fas fa-coffee text-6xl text-[#2c3e50]"></i>
                    </div>
                    <div class="bg-gray-300 h-48 rounded overflow-hidden flex items-center justify-center">
                        <i class="fas fa-bread-slice text-6xl text-[#2c3e50]"></i>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 bg-[#f39c12] text-white text-xl font-bold w-16 h-16 rounded-full
                    flex items-center justify-center animate-pulse">
                    25+
                </div>
            </div>
        </div>

        <div class="md:w-1/2 text-center md:text-left scroll-reveal">
            <span class="inline-block px-4 py-1 bg-[#f39c12] text-white rounded-full text-sm font-medium mb-4">
                NUESTRA HISTORIA
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-5 text-[#f39c12]">Tradición cafetera desde 1995</h2>
            <p class="text-base sm:text-lg mb-6 text-[#bdc3c7]">
                Comenzamos como un pequeño local familiar con una pasión: ofrecer el mejor café de la ciudad.
                A lo largo de los años, hemos crecido manteniendo nuestra esencia y calidad.
            </p>
            <p class="text-base sm:text-lg mb-8 text-[#bdc3c7]">
                Hoy, Cafetería Bonifacio es un referente en Madrid, un lugar donde cada cliente es parte
                de nuestra familia y cada taza cuenta una historia.
            </p>

            <div class="flex flex-wrap gap-8 justify-center md:justify-start">
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#f39c12] mb-2">25+</div>
                    <div class="text-sm text-[#bdc3c7]">Años de experiencia</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#f39c12] mb-2">15k+</div>
                    <div class="text-sm text-[#bdc3c7]">Clientes satisfechos</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-[#f39c12] mb-2">50+</div>
                    <div class="text-sm text-[#bdc3c7]">Recetas únicas</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contacto -->
<section id="Contacto" class="py-20 bg-[#ecf0f1] text-[#2c3e50] px-4 sm:px-8 md:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 scroll-reveal">
            <span class="inline-block px-4 py-1 bg-[#f39c12] text-white rounded-full text-sm font-medium mb-4">
                CONTÁCTANOS
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-5 text-[#f39c12]">¿Tienes alguna pregunta?</h2>
            <p class="text-base sm:text-lg max-w-2xl mx-auto">
                Estamos aquí para ayudarte. Rellena el formulario y nos pondremos en contacto contigo lo antes posible.
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <div class="lg:w-1/2 scroll-reveal">
                <form class="bg-white rounded-xl shadow-lg p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="nombre">Nombre</label>
                            <input type="text" id="nombre"
                                   class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] w-full"
                                   placeholder="Tu nombre" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" for="email">Email</label>
                            <input type="email" id="email"
                                   class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] w-full"
                                   placeholder="Tu correo electrónico" required>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2" for="asunto">Asunto</label>
                        <input type="text" id="asunto"
                               class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] w-full"
                               placeholder="Asunto de tu mensaje" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2" for="mensaje">Mensaje</label>
                        <textarea id="mensaje"
                                  class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] w-full h-40 resize-y"
                                  placeholder="Tu mensaje" required></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-[#f39c12] text-white font-bold rounded-md hover:bg-[#e67e22]
                        transition-colors duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Enviar mensaje
                    </button>
                </form>
            </div>

            <div class="lg:w-1/2 scroll-reveal">
                <div class="bg-[#2c3e50] text-white p-8 rounded-xl h-full">
                    <h3 class="text-2xl font-bold mb-6 text-[#f39c12]">Información de contacto</h3>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-[#f39c12] text-white p-3 rounded-full">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-medium mb-1">Dirección</h4>
                                <p class="text-[#bdc3c7]">Calle Mayor 123, 28001 Madrid, España</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-[#f39c12] text-white p-3 rounded-full">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-medium mb-1">Teléfono</h4>
                                <p class="text-[#bdc3c7]">+34 912 345 678</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-[#f39c12] text-white p-3 rounded-full">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-medium mb-1">Email</h4>
                                <p class="text-[#bdc3c7]">info@cafeteriabonifacio.es</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-[#f39c12] text-white p-3 rounded-full">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-medium mb-1">Horario</h4>
                                <p class="text-[#bdc3c7]">Lunes - Viernes: 8:00 - 20:00</p>
                                <p class="text-[#bdc3c7]">Sábados y Domingos: 9:00 - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-medium mb-4">Síguenos en redes sociales</h4>
                        <div class="flex gap-4">
                            <a href="#"
                               class="bg-[#3b5998] text-white p-3 rounded-full hover:opacity-80 transition-opacity duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                               class="bg-[#1da1f2] text-white p-3 rounded-full hover:opacity-80 transition-opacity duration-300">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#"
                               class="bg-[#c32aa3] text-white p-3 rounded-full hover:opacity-80 transition-opacity duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#"
                               class="bg-[#25d366] text-white p-3 rounded-full hover:opacity-80 transition-opacity duration-300">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-[#2c3e50] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-coffee text-2xl text-[#f39c12]"></i>
                    <h3 class="text-xl font-bold text-[#f39c12]">Cafeteria Bonifacio</h3>
                </div>
                <p class="text-[#bdc3c7] mb-6">Tu lugar favorito para disfrutar del mejor café en un ambiente acogedor y
                    familiar.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4">Enlaces rápidos</h4>
                <ul class="space-y-2">
                    <li><a href="#Inicio" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">Inicio</a>
                    </li>
                    <li><a href="/menu"
                           class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">Menú</a></li>
                    <li><a href="#SobreNosotros"
                           class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">Sobre Nosotros</a>
                    </li>
                    <li><a href="#Contacto" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">Contacto</a>
                    </li>
                    <li><a href="#" class="text-[#bdc3c7] hover:text-[#f39c12] transition-colors duration-300">Política
                            de privacidad</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4">Horario</h4>
                <ul class="space-y-2">
                    <li class="text-[#bdc3c7]"><span class="font-medium">Lunes - Viernes:</span> 8:00 - 20:00</li>
                    <li class="text-[#bdc3c7]"><span class="font-medium">Sábados:</span> 9:00 - 18:00</li>
                    <li class="text-[#bdc3c7]"><span class="font-medium">Domingos:</span> 9:00 - 18:00</li>
                    <li class="text-[#bdc3c7]"><span class="font-medium">Festivos:</span> 10:00 - 16:00</li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4">Boletín informativo</h4>
                <p class="text-[#bdc3c7] mb-4">Suscríbete para recibir ofertas especiales y novedades.</p>
                <form class="space-y-4">
                    <input type="email" class="p-3 bg-[#34495e] border border-[#4a6278] rounded-md w-full
                        focus:outline-none focus:border-[#f39c12] text-white" placeholder="Tu correo electrónico">
                    <button class="w-full py-3 bg-[#f39c12] text-white font-bold rounded-md hover:bg-[#e67e22]
                        transition-colors duration-300">Suscribirse
                    </button>
                </form>
            </div>
        </div>
    </div>
</footer>

@vite('resources/js/navbar.js')

</body>
</html>
