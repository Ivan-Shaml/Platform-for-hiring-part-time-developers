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
        $hire_devs_by_names = Developer::whereIn('name', $request->names)->get();

        $selected_developers_to_hire = $request->names;
        $now = date("Y-m-d H:i:s");

        // Loop every selected developer for hiring and store them in an array by "names"
        foreach ($selected_developers_to_hire as $single_developer) {
            $collected_developers[] = $single_developer;
            $select_hired_developers_by_names = Hire::select('*')
                ->where('names', '=', $single_developer)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                        });
                })
                ->first();

            if ($select_hired_developers_by_names) {
                throw ValidationException::withMessages(['hire_error' => 'Select valid date.']);
            }

            // Validation checks.
            if ($request->end_date < $request->start_date) {
                throw ValidationException::withMessages(['hire_error' => 'Select valid date.']);
            }

            if ($request->start_date < $now || $request->end_date < $now) {
                throw ValidationException::withMessages(['hire_error' => 'Select valid date.']);
            }

            $hire_dates = Hire::select('*')->where('developer_id', '=', $single_developer)->get();

            $can_hire = true;

            foreach ($hire_dates as $hire_date) {
                if (($request->start_date <= $hire_date->end_date) && ($request->end_date >= $hire_date->start_date)) {
                    $can_hire = false;
                    break;
                }
            }

            if ($can_hire) {
                // Loop all the collected/selected in array developers and hire simultaneously.
                foreach ($collected_developers as $single_collected_developer) {
                    foreach($hire_devs_by_names as $dev) {
                        Hire::insert(
                            ["names" => $single_collected_developer, "developer_id" => $dev->id, "start_date" => $request->start_date, "end_date" => $request->end_date]
                        );
                    }
                }
            } else {
                throw ValidationException::withMessages(['hire_error' => "Developer '$single_developer->name' already hired for this time period."]);
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
