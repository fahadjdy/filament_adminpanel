@extends('layout.base')

@section('content')

    <h1>Home Page</h1>
    <p> Name : <?=$profile->name?> </p>
    <p> Slogan : <?=$profile->slogan?> </p>
    <p> About : <?=$profile->about?> </p>
    <p> Email : <?=$profile->email?> </p>
    <p> Contact : <?=$profile->contact?> </p>
    <p> Whatsapp : <?=$profile->whatsapp?> </p>
    <p> location : <?=$profile->location?> </p>
    <p> city : <?=$profile->city?> </p>
    <p> state : <?=$profile->state?> </p>
    <p> pincode : <?=$profile->pincode?> </p>
    <p> logo : <img width="100px" src="{{asset('storage/'.$profile->logo)}}" alt="{{ $profile->name }}"> </p>
    <p> favicon : <img width="50px" src="{{asset('storage/'.$profile->favicon)}}" alt="{{ $profile->name }}"></p>
    <iframe
        class="map-frame"
        src="https://www.google.com/maps?q=<?=$profile->latitude?>,<?=$profile->longitude?>&z=15&output=embed"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Map showing location (lat long)">
    </iframe>


@endsection