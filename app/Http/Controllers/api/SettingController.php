<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
        /**
         * @OA\Patch(
         * path="/setting/{setting}",
         * summary="update setting",
         * description="update setting",
         * operationId="updateSetting",
         * tags={"setting"},
         * @OA\RequestBody(
         *    required=true,
         *    description="required field",
         *    @OA\JsonContent(
         *       @OA\Property(property="key", type="string", format="text", example="overtime_method"),
         *       @OA\Property(property="value", type="integer", format="number", example="1"),
         *    ),
         * ),
         * @OA\Response(
         *    response=400,
         *    description="Wrong field setting",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="string", example="setting Save Failed!")
         *        )
         *     )
         * )
         */


    public function update(Request $request, setting $setting){
        //validate data
        $validator = Validator::make($request->all(), [
            'key'     => 'required',
            'value'   => 'required|exists:references,id',
        ]);

        if($request->input('key') != "overtime_method"){
            return response()->json([
                'success' => false,
                'message'    => 'Must be overtime_method'
            ],400);
        }

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'    => $validator->errors()
            ],400);

        } else {

            $setting = setting::whereId($setting->id)->update([
                'key'     => $request->input('key'),
                'value'   => $request->input('value'),
            ]);


            if ($setting) {
                return response()->json([
                    'success' => true,
                    'message' => 'Settings Updated Successfully!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Settings Failed to Update!',
                ], 500);
            }

        }
    }
}
