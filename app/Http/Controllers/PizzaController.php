<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index()
    {
        // Read pizza data from JSON file
        $jsonPath = public_path('data/pizza.json');
        
        if (!file_exists($jsonPath)) {
            return view('pizza', ['pizza' => []]);
        }
        
        $jsonContent = file_get_contents($jsonPath);
        $data = json_decode($jsonContent, true);
        
        $pizza = $data['menu'] ?? [];
        
        return view('pizza', compact('pizza'));
    }
} 