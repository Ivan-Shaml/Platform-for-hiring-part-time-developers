<?php
namespace App\Services;

use App\Models\Developer;
use App\Models\Hire;
use Illuminate\Http\Request;

class HireService{


    public static function storeHire(Request $request) {
        $hire_devs = Developer::where('name', $request->names)->get();

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
    }

    public static function deleteHire($id) {
        $delete_dev = Hire::findOrFail($id);
        $delete_dev->delete();
    }

}
