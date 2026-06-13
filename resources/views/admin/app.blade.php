<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-fixed": "#acefe7",
                        "on-tertiary": "#ffffff",
                        "surface-dim": "#d7dadb",
                        "outline-variant": "#bec8ca",
                        "on-secondary-fixed-variant": "#00504b",
                        "on-secondary-fixed": "#00201e",
                        "inverse-on-surface": "#eef1f2",
                        "background": "#f7fafa",
                        "secondary-container": "#a9ece5",
                        "tertiary-container": "#8e5426",
                        "on-secondary-container": "#286d67",
                        "error-container": "#ffdad6",
                        "primary-fixed": "#9ff0fb",
                        "primary": "#00535b",
                        "surface-container-highest": "#e0e3e3",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "surface": "#f7fafa",
                        "tertiary": "#713d10",
                        "surface-container-low": "#f1f4f4",
                        "primary-container": "#006d77",
                        "on-surface": "#181c1d",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#ebeeef",
                        "surface-container-high": "#e6e9e9",
                        "outline": "#6f797a",
                        "on-background": "#181c1d",
                        "surface-variant": "#e0e3e3",
                        "on-surface-variant": "#3e494a",
                    },

                    spacing: {
                        "stack-sm": "8px",
                        "stack-md": "16px",
                        "gutter": "24px",
                        "card-padding": "20px",
                        "margin-page": "32px",
                        "stack-lg": "24px"
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL'0,
                'wght'400,
                'GRAD'0,
                'opsz'24;
        }

        body {
            background-color: #f7fafa;
            font-family: Inter, sans-serif;
        }
    </style>

</head>

<body class="text-on-surface">

    @include('admin.sidebar')

    <main class="ml-64 min-h-screen">

        @include('admin.header')

        <div class="p-margin-page">
            @yield('content')
        </div>

    </main>

</body>

</html>