<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OvertimeController extends Controller
{
    /**
         * @OA\Post(
         * path="/overtimes",
         * summary="create new overtime",
         * description="create new overtime",
         * operationId="postOvertime",
         * tags={"overtime"},
         * @OA\RequestBody(
         *    required=true,
         *    description="required field",
         *    @OA\JsonContent(
         *       @OA\Property(property="employee_id", type="integer", format="number", example="1"),
         *       @OA\Property(property="date", type="date", format="text", example="2022-06-26"),
         *    ),
         * ),
         * @OA\Response(
         *    response=400,
         *    description="Wrong field overtime",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="string", example="overtime Save Failed!")
         *        )
         *     )
         * )
         */

    public function store(Request $request){
         //validate data
         $validator = Validator::make($request->all(), [
            'employee_id'       => 'required|integer',
            'date'              => 'required|date',
            'time_started'      => 'required|date_format:H:i|before_or_equal:time_ended',
            'time_ended'        => 'required|date_format:H:i|after_or_equal:time_started',
        ]);

        $date = overtime::where('employee_id', $request->input('employee_id'))
                            ->where('date', $request->input('date'))
                            ->first();

        if(isset($date)){
            return response()->json([
                'success' => false,
                'message' => 'employee with this date already exists!'
            ],400);
        }

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ],400);

        } else {

            $overtime = overtime::create([
                'employee_id'     => $request->input('employee_id'),
                'date'            => $request->input('date'),
                'time_started'    => $request->input('time_started'),
                'time_ended'      => $request->input('time_ended'),
            ]);

            if ($overtime) {
                return response()->json([
                    'success' => true,
                    'message' => 'overtime Saved Successfully!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'overtime Save Failed!',
                ], 400);
            }
        }
    }
}
