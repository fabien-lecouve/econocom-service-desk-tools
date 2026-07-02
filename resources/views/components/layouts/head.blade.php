@props(['title'])

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/36558d4fea.js" crossorigin="anonymous"></script>

    <title>{{ isset($title) ? 'Artesan | ' . $title : 'Artesan' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

