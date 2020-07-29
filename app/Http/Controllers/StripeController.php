<?php

namespace App\Http\Controllers;

class StripeController extends Controller
{
    public function getCurrentSubscription() {
        $user = auth()->user();
        $data = [];
        $data['has_payment_method'] = $user->hasDefaultPaymentMethod();
        if ($user->subscribed('default')) {
            $data['subscribed'] = true;
            $data['plan_id'] = $user->subscription()->stripe_plan;
        } else {
            $data['subscribed'] = false;
        }
        return $data;
    }

    public function getIntent() {
        $user = auth()->user();
        return ['intent' => $user->createSetupIntent()];
    }

    public function subscribe() {
        $user = auth()->user();
        $plan_id = request()->plan_id;
        if(request()->has('payment_method')) {
            $paymentMethod = request()->payment_method;
            $user->newSubscription('default', $plan_id)->create($paymentMethod,['name' => request()->card_holder_name, "address" => ["country" => 'GB', "state" => 'England', "city" => 'Abberley', "postal_code" => 'WR6', "line1" => 'test', "line2" => ""]]);
        } else if($user->hasDefaultPaymentMethod()) {
            $paymentMethod = $user->defaultPaymentMethod();
            $user->newSubscription('default', $plan_id)->create($paymentMethod->id);
        } else {
            $user->subscription('default')->swap($plan_id);
        }
        return ['success' => true];
    }

    public function unsubscribe() {
        $user = auth()->user();
        $user->subscription('default')->cancel();
        $user->role_id = 3; //expired role
        $user->save();
        return ['success' => true];
    }

    public function webhook() {
        $data = request()->all();
        $custom_data = explode(",", $data['data']['object']['client_reference_id']);
        $user = App\Models\User::find($custom_data[0]);
        $user->stripe_id = $data['data']['object']['customer'];
        switch($custom_data[1]) {
            case 'price_1H9ZbJJZEMHu7eXxIv0Kn3NG':
                $user->role_id = 9;
            break;
            case 'price_1H9ZbJJZEMHu7eXxKtlWHRjL':
                $user->role_id = 8;
            break;
            case 'price_1H9ZbKJZEMHu7eXxf2jzzyol':
                $user->role_id = 7;
            break;
            case 'price_1H9ZbJJZEMHu7eXxTVw8KMqw':
                $user->role_id = 6;
            break;
            case 'price_1H9ZbKJZEMHu7eXxFUsuK0kd':
                $user->role_id = 5;
            break;
            case 'price_1H9ZbJJZEMHu7eXxlVHmrPiN':
                $user->role_id = 4;
            break;
        }
        $user->save();
    }
}
