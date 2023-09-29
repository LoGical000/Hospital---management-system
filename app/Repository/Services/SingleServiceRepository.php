<?php

namespace App\Repository\Services;

use App\Models\Service;

class SingleServiceRepository implements \App\Interfaces\Services\SingleServiceRepositoryInterface
{

    public function index()
    {
        $services = Service::all();
        return view('Dashboard.Services.Single Service.index',compact('services'));
    }

    public function store($request)
    {
        try {
         $service = new Service();
         $service->name = $request->name;
         $service->price = $request->price;
         $service->description = $request->description;
         $service->save();

            session()->flash('add');
            return redirect()->route('Service.index');


        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $service = Service::findOrfail($request->id);
            $service->name = $request->name;
            $service->price = $request->price;
            $service->description = $request->description;
            $service->save();

            session()->flash('add');
            return redirect()->route('Service.index');


        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        Service::destroy($request->id);
        session()->flash('delete');
        return redirect()->route('Service.index');
    }
}
