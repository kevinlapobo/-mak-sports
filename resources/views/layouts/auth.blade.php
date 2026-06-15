<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }} — Makerere Sports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .mak-green { background-color: #28A745; }
        .mak-gold { color: #FFD700; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="{{ route('home') }}" class="flex justify-center">
                <div class="mak-green text-white px-6 py-3 rounded-xl font-extrabold text-2xl">
                    MAK<span class="mak-gold">SPORTS</span>
                </div>
            </a>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $heading ?? 'Sign in to your account' }}
            </h2>
            @if(isset($subheading))
                <p class="mt-2 text-center text-sm text-gray-600">{{ $subheading }}</p>
            @endif
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
