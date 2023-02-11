<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $pageTitle = "Membership";
        $plans = Plan::where("plan_name", "!=", "Free")->get();
        $currentPlan = seller()->Plan();
        return view('seller.membership.index', compact('pageTitle', 'plans', 'currentPlan'));
    }
    public function plan($hash)
    {
        $pageTitle = "Membership";
        $plan = Plan::where("hash", $hash)->where("plan_name", "!=", "Free")->firstOrFail();
        $duration = request()->query("duration") == "" ? 'monthly' : request()->query('duration');

        if ($duration != 'monthly' and $duration != 'yearly') abort(404);
        return view('seller.membership.plan', compact('pageTitle', 'plan', 'duration'));
    }
    public function createPayment(Request $request)
    {
        $this->validate($request, [
            "channel" => "required",
            "amount" => "required",
            "duration" => "required",
            "plan" => "required",
        ]);

        $plan = Plan::where("hash", $request->plan)->first();

        // ge tamount 
        $amount = $plan->ConvertedAmount($request->duration);

        $sub = Subscription::create([
            "seller_id" => seller()->id,
            "plan_id" => $plan->id,
            "due_date" => strtotime(Carbon::now()->addYear(1)),
            "channel" => $request->channel,
            "status" => "pending",
            "amount_paid" => $amount,
            "duration" => $request->duration
        ]);

        return response()->json(["payment" => $sub->id]);
    }

    public function validatePayment($payment, $reference)
    {
        $payment = Subscription::where("id", $payment)->where("status", "pending")->firstOrFail();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . env('PAYSTACK_SECRET'),
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        if ($response["status"]) {
            $data = $response["data"];
            $amount = $data["amount"];
            if ($amount >= $payment->amount_paid) {

                // get user lastsub
                $lastSub = Subscription::where("seller_id", seller()->id)->where("status", "paid")->orderBy("id", "DESC")->first();
                $now = strtotime(Carbon::now(1));
                $remaining = 0;
                if($lastSub){
                    if($lastSub->plan_id != '1'){
                        // check if its still valid
                        if($lastSub->due_date > $now){
                            // check the plan, if plan is not this plan
                            $remaining = $lastSub->due_date - $now;
                        }
                    }
                }

                $yearly = strtotime(Carbon::now(1)->addYear(1)) + $remaining;
                $monthly = strtotime(Carbon::now(1)->addMonths(1)) + $remaining;

                $payment->reference = $reference;
                $payment->due_date = $payment->duration == 'yearly' ? $yearly : $monthly;
                $payment->status = "paid";
                $payment->save();
                return redirect('/seller')->with( "notify", [["success", "Payment verified successfully"]]);
            }
           
        }
        return back()->withErrors(["payment" => "Unable to verify payment, contact admin"]);
    }

    public function validatePaymentPaypal(Request $request){
        $this->validate($request, [
            "plan" => "required",
            "amount" => "required",
            "txid" => "required",
            "duration" => "required"
        ]);

        $plan = Plan::where("hash", $request->plan)->first();

        $lastSub = Subscription::where("seller_id", seller()->id)->where("status", "paid")->orderBy("id", "DESC")->first();
        $now = strtotime(Carbon::now(1));
        $remaining = 0;
        if($lastSub){
            if($lastSub->plan_id != '1'){
                // check if its still valid
                if($lastSub->due_date > $now){
                    // check the plan, if plan is not this plan
                    $remaining = $lastSub->due_date - $now;
                }
            }
        }

        $yearly = strtotime(Carbon::now(1)->addYear(1)) + $remaining;
        $monthly = strtotime(Carbon::now(1)->addMonths(1)) + $remaining;

        Subscription::create([
            "seller_id" => seller()->id,
            "plan_id" => $plan->id,
            "due_date" => $request->duration == 'yearly' ? $yearly : $monthly,
            "channel" => "paypal",
            "status" => "paid",
            "amount_paid" => $request->amount,
            "duration" => $request->duration,
            "reference" => $request->txid,
            "payload" => json_encode($request->payload),
        ]);

        return response()->json(["status" => true]);

    }
}
