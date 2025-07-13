<meta charset="utf-8">
{{-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>{{ $title ?? '' }} | Fléx ERP</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="A fully featured Fléx ERP system" />
<meta name="author" content="Flex" />

{{-- App favicon --}}
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

<style>
  /* General styles */
  body {
    margin: 0 !important;
    padding: 0 !important;
  }

  /* Adjust zoom level for medium and small screens */
  @media (max-width: 768px) {
    html {
      zoom: 0.9 !important; /* Adjust zoom for screens 768px wide or less */
    }
  }

  @media (max-width: 480px) {
    html {
      zoom: 0.85 !important; /* Further adjust zoom for screens 480px wide or less */
    }
  }
</style>
