<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function submitForm(Request $request)
    {
        // Process your API request here
        // You can access form data using $request->input('field_name')
        // Example: $requestData = $request->all();

        // Return a response (JSON, for example)
            // $text_input = $request->field_name;
            // echo "this the text you input ";
        return response()->json(['status' => 'success', 'value' => $request->field_name]);
    }
}
