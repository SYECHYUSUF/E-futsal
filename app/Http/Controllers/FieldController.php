<?php

namespace App\Http\Controllers;

use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::all();

        return view('customer.fields.index', compact('fields'));
    }
}
