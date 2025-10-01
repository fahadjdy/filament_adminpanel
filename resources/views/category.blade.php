@extends('layout.base')

@section('meta_description', $category->meta_description ?? '')
@section('meta_title', $category->meta_title ?? '')
@section('title')
  Category 
@endsection

@section('content')


    <p> Category Name : {{$category->name}} </p>
    <p> Category Description : {{$category->description}} </p>
    
    <p>Category Products </p>
    @foreach ($category->products as $key => $product)
        
        <p> Product Name : {{$product->name}} </p>
        
    @endforeach

@endsection