@extends('layouts.layouts')
       
@section('content')
  <div class="wrapper pizza-index">
    <h1>Pizza list</h1>
   @foreach($pizzas as $pizza)
      <div class="pizza-item">
        <img src="/img/pizzadude.jpg" alt="pizza icon">
        <h4><a href="/Pizzas/{{ $pizza->id}}">{{ $pizza->name}}</a></h4>
      </div>
    @endforeach
   </div>
           
@endsection