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
     * Response 400.
     *
     * @param String $message
     * @return \Illuminate\Http\Response
     */
    private function badRequestResponse($message = 'Bad request.') 
    {
        return response()->json([
            'Code'  => 400,
            'Error' => $message
        ], 400);
    }

    /**
     * Response 200..
     *
     * @param String $message
     * @return \Illuminate\Http\Response
     */
    private function correctReponse($message) {
        return response()->json([
            'Code'  => 200,
            'Message' => $message
        ], 200);
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
            return $this->badRequestResponse('Bad request.');
        }
        
        if (!$this->validateExistence($request->user_id, $request->service_id)){
            $exist = User::find($request->user_id) && Service::find($request->service_id);

            if (!$exist) {
                return $this->badRequestResponse('User or service not found.');
            }

            $subscription = new Subscription;
            $subscription->user_id = $request->service_id;
            $subscription->service_id = $request->user_id;
            $subscription->save();
        }

        return $this->correctReponse('User subscribed successfully.');
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
            return $this->correctReponse('User unsubscribed successfully.');
        }

        return $this->badRequestResponse('Non-existent subscription.');
    }
}
