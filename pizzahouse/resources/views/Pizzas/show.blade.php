@extends('layouts.layouts')
       
@section('content')
<div class="wrapper pizza-work">
  <h1>order for {{ $pizza->name }}</h1>
  <p class="type">Type - {{ $pizza->type}}</p>
  <p class="base">base - {{ $pizza->base}}</p>
  <p class="toppings">Extra Toppings:</p>
  <ul>
    @foreach($pizza->toppings as $topping)
      <li>{{ $topping }}</li>
    @endforeach
  </ul>
  <form action="/Pizzas/{{ $pizza->id}}" method="POST">
    @csrf
    @method('DELETE')
    <button>complete your order</button>
</form>
</div>
<a href="/Pizzas" class="back"><- Back to all pizzas</a>
@endsection