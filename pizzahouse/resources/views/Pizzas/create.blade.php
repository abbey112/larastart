@extends('layouts.app')
       
@section('content')
<div class="wrapper create-pizza">
    <h1>Create New Pizza</h1>
    <form action="/Pizzas" method="POST">
    @csrf
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name">
        <label for="Type">Choose Pizza Type:</label>
        <select name="Type" id="Type">
            <option value="marghiritta">maghiritts</option>
            <option value="hawaiian">hawaiian</option>
            <option value="veg supreme">veg supreme</option>
            <option value="volcano">volacano</option>
        </select>
        <label for="Type">Choose base Type:</label>
        <select name="base" id="base">
            <option value="chissy crust">chissy crust</option>
            <option value="galic crust">galic crust</option>
            <option value="thin & cripsy">thin & cripsy</option>
            <option value="thick">thick</option>
        </select><br />
        <label> Extra Toppings:</label>
        <input type="checkbox" name="toppings[]" value="mushroom">mushroom <br />
        <input type="checkbox" name="toppings[]" value="pepper">pepper <br />
        <input type="checkbox" name="toppings[]" value="suya">suya <br />
        <input type="checkbox" name="toppings[]" value="chicken">chicken <br />
        <input type="submit" value="Order Pizza">
    </form>
</div>
@endsection