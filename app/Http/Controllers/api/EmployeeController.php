<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
        /**
         * @OA\Post(
         * path="/employees",
         * summary="create new employee",
         * description="create new employee",
         * operationId="postEmployee",
         * tags={"employee"},
         * @OA\RequestBody(
         *    required=true,
         *    description="required field",
         *    @OA\JsonContent(
         *       @OA\Property(property="name", type="string", format="text", example="ferry Permana"),
         *       @OA\Property(property="salary", type="string", format="text", example="4000000"),
         *    ),
         * ),
         * @OA\Response(
         *    response=400,
         *    description="Wrong field employee",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="string", example="employee Save Failed!")
         *        )
         *     )
         * )
         */
    public function store(Request $request){
        //validate data
        $validator = Validator::make($request->all(), [
            'name'     => 'required|unique:employees,name|min:2',
            'salary'   => 'required|integer|min:2000000|max:10000000',
        ]);


        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ],400);

        } else {

            $employee = employee::create([
                'name'     => $request->input('name'),
                'salary'   => $request->input('salary')
            ]);

            if ($employee) {
                return response()->json([
                    'success' => true,
                    'message' => 'employee Saved Successfully!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'employee Save Failed!',
                ], 400);
            }
        }
    }
}
