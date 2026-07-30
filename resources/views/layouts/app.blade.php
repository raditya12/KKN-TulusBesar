<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>WebGIS - Desa Tulusbesar</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js with Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background text-on-background h-screen overflow-hidden flex flex-col font-body-md antialiased">
    
    <!-- Navbar Component -->
    <x-navbar />

    <!-- Main Workspace -->
    <main class="flex-1 flex overflow-hidden relative">
        @yield('content')
    </main>

    <!-- Footer Component (Optional, can be placed inside content if full height is needed for WebGIS) -->
    <!-- <x-footer /> -->

</body>
</html>
