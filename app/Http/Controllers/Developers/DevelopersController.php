<?php

namespace App\Http\Controllers\Developers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;
use App\Models\Hire;
use App\Services\DeveloperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DevelopersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $developer = DeveloperService::getDeveloper();
        return view('developers', compact('developer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeveloperRequest $request)
    {

        $data = $request->validated();

        DeveloperService::createDeveloper($request);
        return redirect('/developers')->with('success', 'Developer is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function show(Developer $developer)
    {

    }

    public function getDeveloper($id) {
        $get_dev_profile = Developer::find($id);
        return view('profile', compact('get_dev_profile'))->with('success', 'Developer is successfully saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $developers = Developer::findOrFail($id);
        return view('edit', compact('developers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function update(DeveloperRequest $request, $id)
    {
        $data = $request->validated();

      DeveloperService::updateDeveloper($id, $data);

        return redirect('/developers')->with('success', `Developer Data is successfully updated`);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeveloperService::deleteDeveloper($id);
        return redirect('/developers')->with('success', 'Developer Data is successfully deleted');
    }
}
