<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\overtime;
use App\Models\reference;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OvertimePayController extends Controller
{
    /**
         * @OA\Post(
         * path="/overtimes-pays/calculate",
         * summary="calculate overtime",
         * description="calculate overtime",
         * operationId="postOvertime",
         * tags={"overtime"},
         * @OA\Response(
         *    response=400,
         *    description="Wrong field overtime",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="string", example="overtime Save Failed!")
         *        )
         *     )
         * )
         */

        


    public function index(Request $request)
    {
        $employees = employee::with('overtime')->get();
        if ($request->date) {
            $employees = employee::whereHas('overtime', function ($query) {
                $query->where('date', '=', request()->date);
            })->get();
        }

        if($employees){
            $setting = setting::first()->value;

            foreach ($employees as $employee) {
                $data = array();
                $data['id'] = $employee->id;
                $data['name'] = $employee->name;
                $data['salary'] = $employee->salary;
                foreach ($employee->overtime as $o) {
                    $start = strtotime($o->date . ' ' . $o->time_started);
                    $end = strtotime($o->date . ' ' . $o->time_ended);
                    $diff    = $end - $start;
                    $jam    = floor($diff / (60 * 60));

                    $dataOvertime = [
                        'id' => $o->id,
                        'date' => $o->date,
                        'time_stared' => $o->time_started,
                        'time_ended' => $o->time_ended,
                        'overtime_duration' => $jam
                    ];
                    $data['overtime'][] = $dataOvertime;
                    $overtimeDurationTotal = array();
                    foreach ($data['overtime'] as $overtime) {
                        $overtimeDurationTotal[] = $overtime['overtime_duration'];
                    }
                }


                $data['overtime_duration_total'] = array_sum($overtimeDurationTotal);
                if ($setting == 2) {
                    $amount = 10000 * $data['overtime_duration_total'];
                } else {
                    $amount = $data['salary'] / 173 * $data['overtime_duration_total'];
                }
                $data['amount'] = number_format($amount);
                $row[] = $data;
            }

            return response()->json([
                "data" => $row
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message'    => 'Not Found'
        ],400);
    }
}
