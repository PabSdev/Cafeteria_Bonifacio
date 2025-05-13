<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Registro - Cafeteria Loli</title>
</head>

<body class="font-sans">
<!-- Register Section -->
<main class="min-h-screen bg-[#2c3e50] py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-500 text-white rounded-lg shadow animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden animate__animated animate__fadeInUp">
            <!-- Header decorativo -->
            <div class="bg-[#f39c12] py-8 px-6 relative">
                <div class="text-center">
                    <i class="fas fa-user-plus text-5xl text-white mb-3"></i>
                    <h2 class="text-2xl font-bold text-white">Crear una cuenta</h2>
                    <p class="text-white/80 mt-2">Únete a la comunidad de Cafetería Bonifacio</p>
                </div>

                <!-- Decorative wave -->
                <div class="absolute -bottom-1 left-0 right-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" class="w-full h-10"
                         preserveAspectRatio="none">
                        <path fill="#ffffff" fill-opacity="1"
                              d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
                    </svg>
                </div>
            </div>

            <!-- Form container -->
            <div class="p-8">
                <form method="POST" action="" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#2c3e50] mb-1">Nombre completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-[#f39c12]"></i>
                            </div>
                            <input type="text" id="name"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] focus:border-[#f39c12] text-[#2c3e50] transition-all duration-300"
                                   name="name" value="{{ old('name') }}" placeholder="Juan Pérez" required autofocus>
                        </div>
                        @if ($errors->has('name'))
                            <p class="mt-1 text-red-500 text-sm">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#2c3e50] mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-[#f39c12]"></i>
                            </div>
                            <input type="email" id="email"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] focus:border-[#f39c12] text-[#2c3e50] transition-all duration-300"
                                   name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required>
                        </div>
                        @if ($errors->has('email'))
                            <p class="mt-1 text-red-500 text-sm">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-[#2c3e50] mb-1">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-[#f39c12]"></i>
                            </div>
                            <input type="password" id="password"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] focus:border-[#f39c12] text-[#2c3e50] transition-all duration-300"
                                   name="password" placeholder="••••••••" required>
                        </div>
                        @if ($errors->has('password'))
                            <p class="mt-1 text-red-500 text-sm">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[#2c3e50] mb-1">Confirmar
                            contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-[#f39c12]"></i>
                            </div>
                            <input type="password" id="password_confirmation"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#f39c12] focus:border-[#f39c12] text-[#2c3e50] transition-all duration-300"
                                   name="password_confirmation" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms"
                               class="h-4 w-4 text-[#f39c12] border-gray-300 rounded focus:ring-[#f39c12]" required>
                        <label for="terms" class="ml-2 block text-sm text-[#2c3e50]">
                            Acepto los <a href="#" class="text-[#f39c12] hover:text-[#e67e22]">términos y
                                condiciones</a>
                        </label>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full py-3 px-4 bg-[#f39c12] text-white font-bold rounded-md hover:bg-[#e67e22] transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i>Crear cuenta
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <span class="text-sm text-[#2c3e50]">¿Ya tienes una cuenta? </span>
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#f39c12] hover:text-[#e67e22]">Iniciar
                            sesión</a>
                    </div>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">O regístrate con</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <a href="#"
                           class="py-2 px-4 border border-gray-300 rounded-md flex items-center justify-center text-[#2c3e50] hover:bg-gray-50 transition-all duration-300">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            Google
                        </a>
                        <a href="#"
                           class="py-2 px-4 border border-gray-300 rounded-md flex items-center justify-center text-[#2c3e50] hover:bg-gray-50 transition-all duration-300">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            Facebook
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/" class="text-[#f39c12] hover:text-[#e67e22] flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i> Volver a la página principal
            </a>
        </div>
    </div>
</main>

<!-- Footer simplificado -->
<footer class="bg-[#2c3e50] text-white py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="flex items-center justify-center gap-2 mb-4">
            <i class="fas fa-coffee text-2xl text-[#f39c12]"></i>
            <h3 class="text-xl font-bold text-[#f39c12]">Cafeteria Bonifacio</h3>
        </div>
        <p class="text-[#bdc3c7] mb-4">Tu lugar favorito para disfrutar del mejor café</p>
        <div class="flex gap-4 justify-center">
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
        <div class="mt-4 text-sm text-[#bdc3c7]">
            &copy; 2024 Cafetería Bonifacio. Todos los derechos reservados.
        </div>
    </div>
</footer>
</body>
</html>
