<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Beneficiaries;
use App\Models\Archives;
use App\Models\Messages;

use Illuminate\Http\Request;
use App\Models\Needs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function delete_user($id)
    {

        $user = Users::find($id);
        $result = $user->delete();
        if ($result) {
            return ["result" => "record has been deleted" . $id];
        } else {
            return ["result" => "delete has failed"];
        }
    }

    public function update_user(Request $request, $id)
    {
        $record = Users::find($id);

        $data = $request->all();

        foreach ($data as $key => $value) {
            if ($key !== 'password') {
                $record->$key = $value;
            }
            return ["result" => "change password has failed"];
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = Users::find($request->input('user_id'));

        // Verify the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect current password',
            ], 400);
        }

        // Change the password
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully',
        ]);
    }

    //////////////////////


    public function makeDonation(Request $request)
    {
        $donaterId = $request->input('donater_id');
        $beneficiarId = $request->input('beneficiar_id');
        $amount = $request->input('amount');

        // Find the beneficiar and update the status
        $beneficiar = Beneficiaries::find($beneficiarId);

        if (!$beneficiar) {
            return response()->json(['error' => 'Beneficiar not found.'], 404);
        }



        // Get additional information for the archive
        $service = $beneficiar->needy_type;
        $overview = $beneficiar->overview;

        // Find the user and get additional information
        $user = Users::find($donaterId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $usersName = $user->full_name;
        $charityId = $beneficiar->charity_id;

        // Find the charity and get additional information
        $charity = Users::find($charityId);

        if (!$charity) {
            return response()->json(['error' => 'Charity not found.'], 404);
        }
        $beneficiar->status = 1;
        $beneficiar->save();
        $charityId = $charity->id;
        $beneficiariesName = $beneficiar->full_name;

        // Create a new archive record
        Archives::create([
            'service' => $service,
            'overview' => $overview,
            'total_amount_of_donation' => $amount,
            'users_id' => $donaterId,
            'users_name' => $usersName,
            'charity_id' => $charityId,
            'Beneficiaries_id' => $beneficiarId,
            'Beneficiaries_name' => $beneficiariesName,
        ]);

        return response()->json(['message' => 'Donation successful']);
    }

    public function makePurchase(Request $request)
    {

        if (!$request->has('orderDetails')) {
            return response()->json(['error' => 'orderDetails key not found in request.'], 400);
        }

        $orderDetails = $request->input('orderDetails');
        $iteamsPurchased = $orderDetails['iteamsPurchased'] ?? [];
        $totalAmount = $orderDetails['totalAmount'] ?? 0;





        // Iterate over each item purchased
        foreach ($iteamsPurchased as $item) {
            // Check if the key 'Quantity' exists in the $item array
            if (!isset($item['quantity'])) {
                return response()->json(['error' => 'Quantity not provided for an item.'], 400);
            }

            $itemName = $item['itemName'];
            $quantity = $item['quantity'];
            $subtotal = $item['subtotal'];
            $donater_id = $item['donater_id'];
            $charity_id = $item['charity_id'];
            $id = $item['id'];



            // Get the service value and overview from the Needs model
            $needs = Needs::find($id);
            if (!$needs) {
                return response()->json(['error' => 'Need not found.'], 404);
            }
            $user = Users::find($donater_id);
            if (!$user) {
                return response()->json(['error' => 'user not found.'], 404);
            }
            $username = $user->full_name;

            $charity = Users::find($charity_id);
            if (!$charity) {
                return response()->json(['error' => 'charity not found.'], 404);
            }

            $newAvailableCount = $needs->available_count - $item['quantity'];
            if ($newAvailableCount < 0) {
                return response()->json(['error' => 'Insufficient available quantity for purchase.'], 400);
            }

            // If added quantity equals available count, update status to 0
            if ($newAvailableCount === 0) {
                $needs->status = 0;
            }

            // Update the available count in the needs table
            $needs->available_count = $newAvailableCount;
            $needs->save();
            // Optionally, you can update the status of the need after the purchase


            $benename = $charity->full_name;
            $service = $needs->needs_type;
            $overview = $needs->overview;

            // Create a new archive record for the item
            Archives::create([
                'service' => $service,
                'overview' => $overview,
                'total_amount_of_donation' => $subtotal,
                'users_id' => $donater_id,
                'Beneficiaries_name' => $benename,
                'users_name' => $username,
                'charity_id' => $charity_id,
                'Beneficiaries_id' => $id,
                // Assuming 'users_name' and 'Beneficiaries_name' are not applicable here
            ]);
        }

        // Calculate new available count


        return response()->json(['message' => 'Purchase completed successfully']);
    }
    public function get_user_messages($user_id)
    {
        $data = Messages::where('user_id', $user_id)->get();


        if ($data->isEmpty()) {
            return response()->json(['message' => 'No messages found for this user'], 404);
        }

        return response()->json(['data' => $data], 200);
    }
}
