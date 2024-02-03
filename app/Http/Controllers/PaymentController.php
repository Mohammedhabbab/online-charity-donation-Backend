<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPayment($amount)
    {
        $url = "https://egate-t.fatora.me/api/create-payment";

        $data = [
            "lang" => "en",
            "terminalId" => "14740055",
            "amount" => $amount,
            "callbackURL" => "your_callback_url",
            "triggerURL" => "your_trigger_url",
        ];

        $username = "ocd";
        $password = "ocd@123";

        $response = Http::withBasicAuth($username, $password)
            ->post($url, $data);

        if ($response->successful()) {
            $paymentInfo = $response->json();

            // Extracting relevant information from Fatora's response
            $url = $paymentInfo["Data"]["url"];
            $paymentId = $paymentInfo["Data"]["paymentId"];

            $formattedResponse = [
                "ErrorMessage" => $paymentInfo["ErrorMessage"],
                "ErrorCode" => $paymentInfo["ErrorCode"],
                "Data" => [
                    "url" => $url,
                    "paymentId" => $paymentId,
                ],
            ];

            return response()->json($formattedResponse);
        } else {
            return response()->json([
                "ErrorMessage" => "Error creating payment",
                "ErrorCode" => $response->status(),
                "Data" => null,
            ], $response->status());
        }
    }

    public function handleCallback($paymentId)
    {
        $url = "https://egate-t.fatora.me/api/get-payment-status/$paymentId";

        $username = "ocd";
        $password = "ocd@123";

        $response = Http::withBasicAuth($username, $password)
            ->get($url);

        if ($response->successful()) {
            $paymentStatus = $response->json();

            // Extracting relevant information from Fatora's response
            $formattedResponse = [
                "ErrorMessage" => $paymentStatus["ErrorMessage"],
                "ErrorCode" => $paymentStatus["ErrorCode"],
                "Data" => [
                    "status" => $paymentStatus["Data"]["status"],
                    "creationTimestamp" => $paymentStatus["Data"]["creationTimestamp"],
                    "rrn" => $paymentStatus["Data"]["rrn"],
                    "amount" => $paymentStatus["Data"]["amount"],
                    "terminalId" => $paymentStatus["Data"]["terminalId"],
                    "notes" => $paymentStatus["Data"]["notes"],
                ],
            ];

            return response()->json($formattedResponse);
        } else {
            return response()->json([
                "ErrorMessage" => "Error getting payment status",
                "ErrorCode" => $response->status(),
                "Data" => null,
            ], $response->status());
        }
    }

    public function reversePayment($paymentId)
    {
        $url = "https://egate-t.fatora.me/api/cancel-payment";

        $data = [
            "lang" => "en",
            "payment_id" => $paymentId,
        ];

        $username = "ocd";
        $password = "ocd@123";

        $response = Http::withBasicAuth($username, $password)
            ->post($url, $data);

        if ($response->successful()) {
            $reversalInfo = $response->json();

            // Extracting relevant information from Fatora's response
            $formattedResponse = [
                "ErrorMessage" => $reversalInfo["ErrorMessage"],
                "ErrorCode" => $reversalInfo["ErrorCode"],
            ];

            return response()->json($formattedResponse);
        } else {
            return response()->json([
                "ErrorMessage" => "Error reversing payment",
                "ErrorCode" => $response->status(),
            ], $response->status());
        }
    }
}
