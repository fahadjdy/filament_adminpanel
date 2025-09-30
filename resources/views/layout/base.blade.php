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


</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @include('layout.header')
    @yield('content')
    @include('layout.footer')
</body>
</html>
