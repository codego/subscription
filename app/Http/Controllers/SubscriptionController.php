<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use App\User;
use App\Service;

use Validator;

class SubscriptionController extends Controller
{
    /**
     * Validates the existence of a subscription.
     *
     * @param int $user_id - User ID
     * @return int $service_id - Service ID
     */
    private function validateExistence($user_id, $service_id)
    {
        return Subscription::select()->where('user_id', '=', $user_id)->where('service_id', '=', $service_id)->count();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'Code'  => 400,
                'Error' => 'Bad request'
            ], 400);
        }
        
        if (!$this->validateExistence($request->user_id, $request->service_id)){
            User::findOrFail($request->user_id);
            Service::findOrFail($request->service_id);
            
            $subscription = new Subscription;
            $subscription->user_id = $request->service_id;
            $subscription->service_id = $request->user_id;
            $subscription->save();
        }

        return response()->json([
            'Code'  => 200,
            'Message' => 'User subscribed successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $user_id - User ID
     * @return int $service_id - Service ID
     */
    public function destroy($user_id, $service_id)
    {
        if ($this->validateExistence($user_id, $service_id)){
            Subscription::where('user_id', '=', $user_id)->where('service_id', '=', $service_id)->delete();
            return response()->json([
                'Code'  => 200,
                'Message' => 'User unsubscribed successfully.'
            ], 200);
        }

        return response()->json([
            'Code'  => 404,
            'Message' => 'Non-existent subscription.'
        ], 200);
        
    }
}
