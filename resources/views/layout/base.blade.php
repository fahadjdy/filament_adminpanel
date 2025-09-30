
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    {{-- Favicon --}}
    @if(!empty($profile?->favicon))
        <link rel="icon" type="image/png" href="{{ asset('storage/'.$profile->favicon) }}">
    @endif
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