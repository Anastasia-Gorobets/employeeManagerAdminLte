<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function autocompleteEmployees(Request $request)
    {
        $data = Employee::where('name', 'LIKE', '%'. $request->get('query'). '%')
            ->get();

        return response()->json($data);

    }
}
