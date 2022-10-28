<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use URL;
use Validator;


class FeedbackApiController extends Controller
{
    public function save_feedback(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'name'        => 'required',
                    'mobile'      => 'required',
                    'email'       => 'required',
                    'subject'     => 'required',
                    'description' => 'required'
                ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }


            $userfeedback              = new UserFeedback();
            $userfeedback->user_id     = auth()->user()->id;
            $userfeedback->name        = $request->name;
            $userfeedback->mobile      = $request->mobile;
            $userfeedback->email       = $request->email;
            $userfeedback->subject     = $request->subject;
            $userfeedback->description = $request->description;
            $userfeedback->save();

            return response()->json([
                'status'  => true,
                'message' => 'Successfully'
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

}
