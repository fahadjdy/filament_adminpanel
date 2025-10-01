<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic Meta Title --}}
    <title>
        @hasSection('title')
            @yield('title') | {{ $profile->name ?? config('app.name') }}
        @else
            {{ $profile->meta_title ?? $profile->name ?? config('app.name') }}
        @endif
    </title>

    {{-- Meta Description --}}
    <meta name="description" content="@yield('meta_description', $profile->meta_description ?? '')">

    {{-- Meta Keywords (optional) --}}
    <meta name="keywords" content="@yield('meta_keywords', $profile->meta_keywords ?? '')">

    {{-- Favicon --}}
    @if(!empty($profile?->favicon))
        <link rel="icon" type="image/png" href="{{ asset('storage/'.$profile->favicon) }}">
    @endif

    {{-- Social / Open Graph --}}
    <meta property="og:title" content="@yield('title', $profile->name )">
    <meta property="og:description" content="@yield('meta_description', $profile->meta_description ?? '')">
    <meta property="og:image" content="{{ asset('storage/'.$profile->og_image ?? '') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $profile->name )">
    <meta name="twitter:description" content="@yield('meta_description', $profile->meta_description ?? '')">
    <meta name="twitter:image" content="{{ asset('storage/'.$profile->og_image ?? '') }}">


    <!-- Font Awesome Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @include('layout.header')
    @yield('content')
    
    <a href="https://api.whatsapp.com/send?phone=<?=$profile->whatsapp ?? '7203070468'?>&text=hello" class="float" target="_blank">
        <i class="fab fa-whatsapp my-float"></i>
    </a>
    @include('layout.footer')

    <style>
        /* whatsapp icon sticky  */

.float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 100;
}

.my-float {
    margin-top: 16px;
}
    </style>
</body>
</html>
