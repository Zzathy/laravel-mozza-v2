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
            'manufacturers' => Manufacturer::all(),
            'types' => Type::all(),
        ];
        return view('manty', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->get('mode') == 'type') {
            $code = "TYP";
            $type = Type::orderBy('created_at', 'desc')->first();
            if(!is_null($type)) {
                $type_code = $code.strval($type->type_id + 1);
            } else {
                $type_code = $code.'1';
            }
            Type::create([
                'type_code' => $type_code,
                'name' => $request->name
            ]);
        } else {
            $code = "MNFCTR";
            $manufacturer = Manufacturer::orderBy('created_at', 'desc')->first();
            if(!is_null($manufacturer)) {
                $manufacturer_code = $code.strval($manufacturer->manufacturer_id + 1);
            } else {
                $manufacturer_code = $code.'1';
            }
            Manufacturer::create([
                'manufacturer_code' => $manufacturer_code,
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
            Type::where('type_code', $id)->update([
                'name' => $request->name
            ]);
        } else {
            Manufacturer::where('manufacturer_code', $id)->update([
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
            $type = Type::where('type_code', $id)->delete();
        } else {
            $manufacturer = Manufacturer::where('manufacturer_code', $id)->delete();
        }

        return redirect()->route('manty.index');
    }
}
