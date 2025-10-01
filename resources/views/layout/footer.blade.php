
<footer>
    <h1>Footer section</h1>

    @foreach($socialmedia as $key => $val)
    <a href="{{$val->link}}">
        <i class="{{$val->icon}}"></i>
    </a>
    @endforeach
</footer>