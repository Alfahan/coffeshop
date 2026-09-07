<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {
        Config::$serverKey = config("services.midtrans.serverKey");
        Config::$isProduction = config("services.midtrans.isProduction");
        Config::$isSanitized = config("services.midtrans.isSanitized");
        Config::$is3ds = config("services.midtrans.is3ds");

        $notification = new Notification();

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        $transaction = Transactions::findOrFail($order_id);

        if ($status == "capture") {
            if ($type == "credit_card") {
                if ($fraud == "challenge") {
                    $transaction->status = "PENDING";
                } else {
                    $transaction->status = "SUCCESS";
                }
            }
        } elseif ($status == "settlement") {
            $transaction->status = "SUCCESS";
        } elseif ($status == "pending") {
            $transaction->status = "PENDING";
        } elseif ($status == "deny") {
            $transaction->status = "CANCELLED";
        } elseif ($status == "expire") {
            $transaction->status = "CANCELLED";
        } elseif ($status == "cancel") {
            $transaction->status = "CANCELLED";
        }

        $transaction->save();

        if ($transaction) {
            if ($status == "capture" && $fraud == "accept") {
                //
            } elseif ($status == "settlement") {
                //
            } elseif ($status == "success") {
                //
            } elseif ($status == "capture" && $fraud == "challenge") {
                return response()->json([
                    "meta" => [
                        "code" => 200,
                        "message" => "Midtrans Payment Challenge",
                    ],
                ]);
            } else {
                return response()->json([
                    "meta" => [
                        "code" => 200,
                        "message" => "Midtrans Payment not Settlement",
                    ],
                ]);
            }

            return response()->json([
                "meta" => [
                    "code" => 200,
                    "message" => "Midtrans Notification Success",
                ],
            ]);
        }
    }
}
