<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        // Try to read from public directory first
        $jsonPath = public_path('data/pizza.json');
        
        if (!file_exists($jsonPath)) {
            return view('menu', ['menu' => [], 'error' => 'Menu data not found']);
        }

        $json = file_get_contents($jsonPath);
        
        // Check if JSON is not empty
        if (empty($json)) {
            return view('menu', ['menu' => [], 'error' => 'Menu data is empty']);
        }

        $decoded = json_decode($json, true);
        
        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            return view('menu', ['menu' => [], 'error' => 'Invalid JSON format: ' . json_last_error_msg()]);
        }

        // Check if 'menu' key exists
        if (!isset($decoded['menu'])) {
            return view('menu', ['menu' => [], 'error' => 'Menu data structure is invalid']);
        }

        $menu = $decoded['menu'];
        return view('menu', compact('menu'));
    }
}
