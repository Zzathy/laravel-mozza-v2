<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Type;
use Illuminate\Http\Request;
// use App\Http\Requests\StoreTypeRequest;
// use App\Http\Requests\UpdateTypeRequest;

class ManTyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $context = [
            'manufacturers' => Manufacturer::select('id', 'name', 'email')->get(),
            'types' => Type::select('id', 'name')->get(),
        ];
        return view('manty', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->get('mode') == 'type') {
            Type::create([
                'name' => $request->name
            ]);
        } else {
            Manufacturer::create([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }

        return redirect()->route('manty.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if($request->get('mode') == 'type') {
            Type::where('id', $id)->update([
                'name' => $request->name
            ]);
        } else {
            Manufacturer::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }

        return redirect()->route('manty.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, $id)
    {
        if($request->get('mode') == 'type') {
            $type = Type::find($id);
            $type->delete();
        } else {
            $manufacturer = Manufacturer::find($id);
            $manufacturer->delete();
        }

        return redirect()->route('manty.index');
    }
}
