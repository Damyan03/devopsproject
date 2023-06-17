<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function index()
    {
        $cats = \App\Models\Cat::all();

        return view('cats.index', [
            'cats' => $cats,
        ]);
    }
    public function show(Cat $cat)
    {
        $cat = \App\Models\Cat::findOrFail($cat->id);

        return view('cats.show', [
            'cat' => $cat,
        ]);
    }
    public function create()
    {
        return view('cats.create');
    }
    public function store(Request $request)
    {
        $cat = new \App\Models\Cat();

        $cat->user_id = auth()->user()->id;
        $cat->name = $request->input('name');
        $cat->color = $request->input('color');
        $cat->age = $request->input('age');

        $cat->save();

        return redirect()->route('cats.index');
    }
    public function edit(Cat $cat)
    {
        $cat = Cat::find($cat->id);

        return view('cats.edit', [
            'cat' => $cat,
        ]);
    }
    public function update(Request $request, $id)
    {
        $cat = \App\Models\Cat::findOrFail($id);

        $cat->name = $request->input('name');
        $cat->color = $request->input('color');
        $cat->age = $request->input('age');

        $cat->save();

        return redirect()->route('cats.index');
    }
    public function destroy($id)
    {
        $cat = \App\Models\Cat::findOrFail($id);

        $cat->delete();

        return redirect()->route('cats.index');
    }
}
