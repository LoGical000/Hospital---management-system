<?php

namespace App\Repository\Sections;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionRepository implements \App\Interfaces\Sections\SectionRepositoryInterface
{
    public function index()
    {
        $sections = Section::all();
        return  view('Dashboard.Sections.index',compact('sections'));
    }

    public function store($request)
    {

        Section::create([
            'name'=>$request->name,
        ]);

        session()->flash('add');
        return redirect()->route('Sections.index');

    }

    public function update($request)
    {
        $section = Section::findOrFail($request->id);
        $section->update([
            'name'=>$request->name,
        ]);
        session()->flash('edit');
        return redirect()->route('Sections.index');
    }

    public function destroy($request)
    {
        $section = Section::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('Sections.index');

    }

    public function show($id)
    {
        $doctors = Section::findOrfail($id)->doctors;
        $section = Section::findOrfail($id);
        return view('Dashboard.Sections.show_doctors',compact('doctors','section'));
    }

}
