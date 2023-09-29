<?php

namespace App\Repository\Doctors;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Traits\UploadTrait;
use App\Validators\DoctorValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorRepository implements \App\Interfaces\Doctors\DoctorRepositoryInterface{
use UploadTrait;

    public function index()
    {
        $doctors = Doctor::with('appointmentdoctor')->get();
        return  view('Dashboard.Doctors.index',compact('doctors'));
    }

    public function create(){
        $sections = Section::all();
        $appointments = Appointment::all();
        return view('Dashboard.Doctors.add',compact('sections','appointments'));
    }

    public function store($request){
        //$this->doctorValidator->validate($request);

        DB::beginTransaction();

        try {
            $doctor = new Doctor();
            $doctor->name = $request->name;
            $doctor->password = bcrypt($request->password);
            $doctor->email = $request->email;
            $doctor->phone = $request->phone;
            $doctor->section_id = $request->section_id;
            //$doctor->price = $request->price;
            //$doctor->appointments =implode(",",$request->appointments);
            $doctor->appointmentdoctor()->attach($request->appintments);
            $doctor->save();

            $this->UploadImage($request,'photo','doctors','upload_image',$doctor->id,'App\Models\Doctor');

            DB::commit();
            session()->flash('add');
            return redirect()->route('Doctors.create');
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request){
        if($request->page_id==1){
            if($request->filename)
                $this->Delete_file('upload_image','doctors/'.$request->filename,$request->filename);

            Doctor::destroy($request->id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        }
        else{
            $ids = explode(',',$request->delete_select_id);
            foreach ($ids as $id ){
                $doctor  = Doctor::findOrfail($id);
                if(isset($doctor->image->filename))
                $this->Delete_file('upload_image','doctors/'.$doctor->image->filename,$doctor->image->filename);
                Doctor::destroy($id);

            }

            session()->flash('delete');
            return redirect()->route('Doctors.index');




        }


    }

    public function edit($id)
    {
        $appointments = Appointment::all();
        $sections = Section::all();
        $doctor = Doctor::findOrfail($id);
        return view('Dashboard.Doctors.edit',compact('appointments','sections','doctor'));
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            $doctor = Doctor::findorfail($request->id);

            $doctor->email = $request->email;
            $doctor->section_id = $request->section_id;
            $doctor->phone = $request->phone;
            $doctor->save();
            $doctor->name = $request->name;
            $doctor->save();


            $doctor->appointmentdoctor()->sync($request->appointments);


            if ($request->has('photo')){
                // Delete old photo
                if ($doctor->image){
                    $old_img = $doctor->image->filename;
                    $this->Delete_file('upload_image','doctors/'.$old_img,$old_img);
                }
                //Upload img
                $this->UploadImage($request,'photo','doctors','upload_image',$request->id,'App\Models\Doctor');
            }

            DB::commit();
            session()->flash('edit');
            return redirect()->back();

        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update_password($request)
    {
        try {
            $doctor = Doctor::findorfail($request->id);
            $doctor->update([
                'password'=>bcrypt($request->password)
            ]);

            session()->flash('edit');
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function update_status($request)
    {
        try {
            $doctor = Doctor::findorfail($request->id);
            $doctor->update([
                'status'=>$request->status
            ]);

            session()->flash('edit');
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


}
