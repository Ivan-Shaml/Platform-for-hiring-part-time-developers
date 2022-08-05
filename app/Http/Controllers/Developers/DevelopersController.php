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
    public function store(Request $request)
    {
        $data= new Developer();

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable',
            'phone' => 'nullable',
            'location' => 'nullable',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'price_per_hour' => 'nullable',
            'technology' => 'nullable',
            'description' => 'nullable',
            'years_of_experience' => 'nullable',
            'native_language' => 'nullable',
            'linkedin_profile_link' => 'nullable',
        ]);

        // ensure the request has a file before we attempt anything else.
        if ($request->hasFile('profile_picture')) {

            $request->validate([
                'profile_picture' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file('profile_picture')->store('developer', 'public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $developer = new Developer([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->has('phone') ? $request->input('phone') : NULL,
                'location' => $request->get('location'),
                'profile_picture' => $request->file('profile_picture')->hashName(),
                'price_per_hour' => $request->has('price_per_hour') ? $request->input('price_per_hour') : NULL,
                'technology' => $request->get('technology'),
                'description' => $request->get('description'),
                'years_of_experience' => $request->has('years_of_experience') ? $request->input('years_of_experience') : NULL,
                'native_language' => $request->get('native_language'),
                'linkedin_profile_link' => $request->get('linkedin_profile_linkname'),
            ]);
            $developer->save(); // Finally, save the record.
        }
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
    public function edit(Developer $developer, $id)
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
        $data = $request->safe()->only([
            'name',
            'email',
            'phone',
            'location',
            'profile_picture',
            'price_per_hour',
            'technology',
            'description',
            'years_of_experience',
            'native_language',
            'linkedin_profile_link',
        ]);

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
        $developers = Developer::find($id);
        Storage::disk('public')->delete('developer/'.$developers->profile_picture);
        $developers->delete();
        return redirect('/developers')->with('success', 'Developer Data is successfully deleted');
    }
}
