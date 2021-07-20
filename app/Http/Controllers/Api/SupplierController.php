<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:suppliers,name',
            'email' => 'required',
            'phone' => 'required|unique:suppliers,phone',
            'address' => 'required',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
        }

        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shop_name' => $request->shop_name,
            'address' => $request->address,
            'photo' => $image_url ?? null,
        ]);
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validateData = $request->validate([
            'name' => [
                "required",
                Rule::unique('suppliers')->ignore($supplier->id, 'id')
            ],
            'email' => 'required',
            'phone' => [
                'required',
                Rule::unique('suppliers')->ignore($supplier->id, 'id')
            ],
            'address' => 'required',
        ]);

        $data  = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['shop_name'] = $request->shop_name;
        $data['address'] = $request->address;
        $newImage = $request->newPhoto;

        if ($newImage) {
            $position = strpos($newImage, ';');
            $sub = substr($newImage, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($newImage)->resize(240, 200);
            $upload_path = 'backend/supplier/';
            $newImageUrl = $upload_path . $name;
            $success = $img->save($newImageUrl);

            if ($success) {
                $data['photo'] = $newImageUrl;
                if (strpos($supplier->photo, '.wip')) {
                    $oldPhoto = $supplier->photo;
                    $oldPhoto = explode('.wip/', $oldPhoto)[1];
                    unlink($oldPhoto);
                }
            }
        }

        $supplier->update($data);
        $supplier->save();
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $photo = $supplier->photo;

        if ($photo) {
            unlink($photo);
        }

        $supplier->delete();
    }
}
