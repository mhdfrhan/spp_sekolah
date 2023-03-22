<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ $page_title ?? '' }} | {{ setting('title') }}</title>
<!-- Favicon -->
<link rel="icon" href="{{ asset('assets/img/brand/logo.png') }}" type="image/png">
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
@stack('up')
<!-- Argon CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.1.0') }}" type="text/css">
</head>