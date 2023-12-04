<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ColorPicker extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Storage::json('data.json');

        if (empty($data) || empty($data['selectedColor']))
        {
            $data = json_encode(['selectedColor' =>'#000000']);
            $fileName = 'data.json';
            $data = Storage::put($fileName, $data);
        }

        return Inertia::render('Welcome', [
            'data' => $data['selectedColor'] ?? '#000000'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selectedColor' => ['required', 'hex_color', 'max:10']
        ]);


        $data = json_encode(['selectedColor' => $request->input('selectedColor')]);
        $fileName = 'data.json';

        Storage::put($fileName, $data);

        return to_route('color-picker.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
