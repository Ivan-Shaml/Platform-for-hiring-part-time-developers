<?php

namespace App\Http\Controllers\Hire;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Hire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hire');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Undefined variable: $hire_devs -- Solution: create and store/get and post -- need to the the same routes (/hire)
        $hire_devs = Developer::all();
        $hired = // DB::table('developers')
                        Developer::select('*')
                        ->join('hire_developers', 'developers.name', '=', 'hire_developers.names')
                        ->get();
//        $hired = DB::select('SELECT d.*, h.* FROM developers d INNER JOIN hire_developers h ON d.name = h.names');
        return view('hire', compact('hire_devs', 'hired'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required',
//            'developer_id' => ['required', Rule::exists('developers', 'id')],
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

//        $new_dev = new Developer;
//        $hire_devs = Developer::with('id')->find($new_dev->id);

        $hire_devs = Developer::where('name', $request->names)->get();;

        $select_developer_to_hire = $request->names;
        $now = date("Y-m-d H:i:s");
        foreach ($select_developer_to_hire as $single_dev) {
            $array_dev[] = $single_dev;
//            $developer_for_hire_from_db_select = (new self)->row("SELECT * FROM hire_developers WHERE names = :names AND (:start_date BETWEEN start_date AND end_date OR :end_date  BETWEEN start_date AND end_date)", ["names" => $single_dev, "start_date" => $request->start_date, "end_date" => $request->end_date]);
            $developer_for_hire_from_db_select =
                //DB::table('hire_developers')
                Hire::select('*')
                ->where('names', '=', $single_dev)
                ->where(function ($query) use ($request) { $query->whereBetween('start_date', [$request->start_date, $request->end_date])->orWhereBetween('end_date', [$request->start_date, $request->end_date]); })
                ->first();
            $check_rows = $developer_for_hire_from_db_select;
            $store_res[] = $check_rows;

            if ($check_rows) {
                header('Location: /hire');
                die("Select valid date");
            }
            // Validation checks.
            if ($request->end_date < $request->start_date) {
                header('Location: /hire');
                die("Select valid date");
            }
            if ($request->start_date < $now || $request->end_date < $now) {
                header('Location: /hire');
                die("Select valid date");
            }

            if (count($store_res) !== count($select_developer_to_hire)) {
                continue;
            }
//            $request->developer_id = Auth::developer()->id;
            foreach ($array_dev as $one_dev) {
//                DB::insert("INSERT INTO hire_developers(names, start_date, end_date) VALUES(:names, :start_date, :end_date)", ["names" => $one_dev, "start_date" => $request->start_date, "end_date" => $request->end_date]);
                foreach($hire_devs as $hire) {
                    Hire::insert(
                        ["names" => $one_dev, "developer_id" => $hire->id, "start_date" => $request->start_date, "end_date" => $request->end_date]
                    );
                }
            }
        }

        return redirect('/hire')->with("sdasdsa");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function show(Hire $hire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function edit(Hire $hire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hire $hire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_dev = Hire::findOrFail($id);
        $delete_dev->delete();
        return redirect('/hire')->with('success', 'Dev Data is successfully deleted');
    }
}
