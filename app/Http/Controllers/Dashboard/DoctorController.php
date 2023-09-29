<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Doctor;
use App\Repository\Doctors\DoctorRepository;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    private $DoctorRepository;

    public function __construct(DoctorRepositoryInterface $DoctorRepository)
    {
        $this->DoctorRepository = $DoctorRepository;
    }

    public function index()
    {
        return $this->DoctorRepository->index();

    }


    public function create()
    {
        return $this->DoctorRepository->create();

    }


    public function store(Request $request)
    {
        return $this->DoctorRepository->store($request);

    }


    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
       return $this->DoctorRepository->edit($id);
    }

    public function update(Request $request)
    {
        return $this->DoctorRepository->update($request);

    }

    public function destroy(Request $request)
    {
     return $this->DoctorRepository->destroy($request);
    }

    public function update_password(Request $request){
        $request->validate([
            'password'=>['required','min:6','confirmed'],
            'password_confirmation'=>['required','min:6']
        ]);
        return $this->DoctorRepository->update_password($request);
    }

    public function update_status(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:0,1',
        ]);
        return $this->DoctorRepository->update_status($request);
    }
}
