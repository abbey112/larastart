<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pizza;

class PizzaController extends Controller
{
   // public function __construct() {
   //     $this->middleware('auth');
   // }
    public function index() {
       
        $pizzas = Pizza::all();
    
        return view('pizzas.index', [
            'pizzas' => $pizzas,
            ]);
    }

    public function show($id) {
        $pizza =Pizza::findorfail($id);

        return view('Pizzas.show', ['pizza' => $pizza]);
    }

    public function create() {
        return view('Pizzas.create');
    }

    public function store() {

      $pizza = new pizza();

      $pizza ->name = request('name');
      $pizza ->Type = request('Type');
      $pizza ->base = request('base');
      $pizza ->toppings = request('toppings');
      
      $pizza->save();

        return redirect('/')->with('message', 'Order Complete');
    }

    public function destroy($id) {
        $pizza = Pizza::findorfail($id);
        $pizza->delete();

        return redirect('/Pizzas');
    }
}
