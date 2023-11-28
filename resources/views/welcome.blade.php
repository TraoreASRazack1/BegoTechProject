<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomePage</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #fff; /* Couleur de fond pour le contraste */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombre pour la séparation */
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .logo {
            font-size: 3rem;
            font-weight: 600;
            color: #1a202c;
        }
        text-center img{
            width: 100px; /* Ajustez la largeur selon vos besoins */
            height: auto; /* Ajustez la hauteur automatiquement */
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex-container">
        <div>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Commencer</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class>
            <h3 class="font-semibold text-gray-800 dark:text-white mt-4">BegoTechTaskUse</h3>
        </div>
    </div>
    <div class="flex-center">
        <div class="logo">
        <h3 class="font-semibold text-gray-800 dark:text-white mt-4">BegoTechTaskUse</h3>
        </div>
    </div>
</body>
</html>
