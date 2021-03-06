<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:employees,name',
            'email' => 'required',
            'phone' => 'required|unique:employees,phone',
            'salary' => 'required',
            'address' => 'required',
            'joining_date' => 'required',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
        }

        $employee = new Employee;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->salary = $request->salary;
        $employee->address = $request->address;
        $employee->nid = $request->nid;
        $employee->joining_date = $request->joining_date;
        $employee->photo = $image_url ?? null;

        $employee->save();
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validateData = $request->validate([
            'name' => [
                'required',
                Rule::unique('employees')->ignore($employee->id, 'id')
            ],
            'email' => 'required',
            'phone' => [
                'required',
                Rule::unique('employees')->ignore($employee->id, 'id')
            ],
            'salary' => 'required',
            'address' => 'required',
            'joining_date' => 'required',
        ]);

        $data  = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['salary'] = $request->salary;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;
        $newImage = $request->newPhoto;

        if ($newImage) {
            $position = strpos($newImage, ';');
            $sub = substr($newImage, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . '.' . $ext;
            $img = Image::make($newImage)->resize(240, 200);
            $upload_path = 'backend/employee/';
            $newImageUrl = $upload_path . $name;
            $success = $img->save($newImageUrl);

            if ($success) {
                $data['photo'] = $newImageUrl;
                if (strpos($employee->photo, '.wip')) {
                    $oldPhoto = $employee->photo;
                    $oldPhoto = explode('.wip/', $oldPhoto)[1];
                    unlink($oldPhoto);
                }
            }
        }

        $employee->update($data);
        $employee->save();
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        $photo = $employee->photo;

        if ($photo) {
            unlink($photo);
        }

        $employee->delete();
    }
}
