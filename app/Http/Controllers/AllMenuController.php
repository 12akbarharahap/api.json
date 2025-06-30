<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllMenuController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $errors = [];
        $files = [
            'pizza' => public_path('data/pizza.json'),
            'pasta' => public_path('data/pasta.json'),
            'minuman' => public_path('data/minuman.json'),
        ];
        foreach ($files as $key => $path) {
            if (!file_exists($path)) {
                $errors[] = ucfirst($key) . ' data not found';
                $data[$key] = [];
                continue;
            }
            $json = file_get_contents($path);
            if (empty($json)) {
                $errors[] = ucfirst($key) . ' data is empty';
                $data[$key] = [];
                continue;
            }
            $decoded = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $errors[] = ucfirst($key) . ' JSON error: ' . json_last_error_msg();
                $data[$key] = [];
                continue;
            }
            $data[$key] = $decoded['menu'] ?? [];
        }
        $q = $request->query('q');
        if ($q) {
            foreach (['pizza', 'pasta', 'minuman'] as $key) {
                $data[$key] = array_filter($data[$key], function($item) use ($q) {
                    return stripos($item['nama'], $q) !== false;
                });
            }
        }
        return view('allmenu', [
            'pizza' => $data['pizza'],
            'pasta' => $data['pasta'],
            'minuman' => $data['minuman'],
            'errors' => $errors,
            'q' => $q
        ]);
    }
} 