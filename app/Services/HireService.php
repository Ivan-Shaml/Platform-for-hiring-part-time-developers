<?php

namespace App\Services;

use App\Http\Requests\DeveloperRequest;
use App\Http\Requests\HireRequest;
use App\Models\Developer;
use App\Models\Hire;
use App\Services\Contracts\IHireService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HireService implements IHireService
{


    public function getHire(): \Illuminate\Database\Eloquent\Collection
    {
        return Hire::all();
    }

    public function storeHire(HireRequest $request)
    {
        // Select all from developer where name = names from hire_developers
        $hired_devs_by_id = [];
        foreach ($request->ids as $id) {
            $hired_devs_by_id[] = $hired_dev = Developer::find($id);
                $hired_dev ?? throw ValidationException::withMessages(['hire_error' => "Developer with id: $id not found."]);
        }

        $selected_developers_to_hire = $request->ids;
        $now = date("Y-m-d");
        // Loop every selected developer for hiring and store them in an array by "names"
        foreach ($hired_devs_by_id as $single_developer) {
            // For every selected developer: Select all from hire_developers where names = 'selected developer' where start_date and end_date do not overlap
            $select_hired_developers_by_id =
                Hire::select('*')
                    ->where('developer_id', '=', $single_developer->id)
                    ->where(function ($query) use ($request) {
//                        $query->whereBetween('start_date', [$request->start_date, $request->end_date])->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                        $query->whereDate('start_date', '<=', $request->start_date, 'or')
                            ->whereDate('end_date', '>=', $request->end_date, 'or');
                    })
                    ->first();
//            dd($select_hired_developers_by_id);
            $store_hired_developers_by_names[] = $select_hired_developers_by_id;
            // Validation checks.
            if ($select_hired_developers_by_id) {
                throw ValidationException::withMessages(['hire_error' => "Developer '$single_developer->name' already hired for this time period."]);
            }

            if ($request->end_date <= $request->start_date || $request->start_date < $now || $request->end_date < $now) {
                throw ValidationException::withMessages(['hire_error' => 'Select valid date.']);
            }

            // Check if the looped developers count is equal to the selected developers from the list: if more than one developer is selected from the list, the loop does not exit but gets back and iterates for every other.
            if (count($store_hired_developers_by_names) !== count($selected_developers_to_hire)) {
                continue;
            }
            // Loop all the collected/selected in array developers and hire simultaneously.
            foreach ($hired_devs_by_id as $dev) {
                Hire::insert(
                    ["names" => $dev->name, "developer_id" => $dev->id, "start_date" => $request->start_date, "end_date" => $request->end_date, 'user_hired_id' => Auth::user()->id]
                );
            }
        }
    }

    public function deleteHire($id)
    {
        $delete_dev = Hire::find($id);
        if (is_null($delete_dev)) {
            return false;
        }

        return $delete_dev->delete();
    }

    public function updateHires(DeveloperRequest $request, $id)
    {
        $hire = Hire::where('developer_id', $id)->get();
        foreach ($hire as $single_hire) {
            $single_hire->names = $request->get('name', 'No Data');
            $single_hire->save();
        }
    }

}
