<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinumanController extends Controller
{
    public function index()
    {
        $jsonPath = public_path('data/minuman.json');
        if (!file_exists($jsonPath)) {
            return view('minuman', ['menu' => [], 'error' => 'Menu data not found']);
        }
        $json = file_get_contents($jsonPath);
        if (empty($json)) {
            return view('minuman', ['menu' => [], 'error' => 'Menu data is empty']);
        }
        $decoded = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return view('minuman', ['menu' => [], 'error' => 'Invalid JSON format: ' . json_last_error_msg()]);
        }
        if (!isset($decoded['menu'])) {
            return view('minuman', ['menu' => [], 'error' => 'Menu data structure is invalid']);
        }
        $menu = $decoded['menu'];
        return view('minuman', compact('menu'));
    }
} 