<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Twilio\Rest\Client;
use App\Models\Messages;
use Illuminate\Http\Request;
use App\Models\UsersPhoneNumber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Twilio\Exceptions\RestException;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function show()
    {
        $userId = Auth::id();
        $users = UsersPhoneNumber::all();
        if ($users->count() > 0) {
            return response()->json([
                "status" => 200,
                "user_numbers" => $users
            ], 200);
        } else {
            return response()->json([
                "status" => 404,
                "message" => "No record found"
            ], 404);
        }        // view('welcome', compact("users"));
    }

    public function storePhoneNumber(Request $request)
    {
        // Preprocess the phone number
        $phoneNumber = $request->phone_number;
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '+254' . substr($phoneNumber, 1);
        }
        $userId = Auth::id();
        $validator = Validator::make(['phone_number' => $phoneNumber], [
            'phone_number' => 'required|unique:users_phone_number|numeric',
            // 'user_id'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages()
            ], 422);
        } else {
            $user_phone = UsersPhoneNumber::create([
                "added_by"=> $userId,
                "user_id"=>$request->user_id,
                "phone_number" => $phoneNumber
            ]);

            if ($user_phone) {
                try {
                    $this->sendMessage('User phone added successfully!!', $phoneNumber);
                    return response()->json([
                        "status" => 200,
                        "message" => "User phone added successfully!!"
                    ], 200);
                } catch (RestException $e) {
                    return response()->json([
                        "status" => 500,
                        "message" => "phone number saved but Failed to send message: " . $e->getMessage()
                    ], 500);
                }
            } else {
                return response()->json([
                    "status" => 500,
                    "message" => "Something went wrong"
                ], 500);
            }
        }
    }

    public function sendCustomMessage(Request $request)
    {
        $validatedData = $request->validate([
            'users' => 'required|array',
            'body' => 'required',
        ]);
        $recipients = $validatedData["users"];
        $errors = [];
        foreach ($recipients as $recipient) {
            try {
                $this->sendMessage($validatedData["body"], $recipient);
            } catch (\Twilio\Exceptions\RestException $e) {
                // Capture the error message and the recipient
                $errors[] = [
                    'recipient' => $recipient,
                    'error' => $e->getMessage()
                ];
            }
        }

        // Check if there were any errors
        if (!empty($errors)) {
            return response()->json([
                "status" => 400,
                "message" => "Some messages failed to send",
                "errors" => $errors
            ], 400);
        }

        return response()->json([
            "status" => 200,
            "message" => "Messages sent successfully!"
        ], 200);
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $userId = Auth::id();

        try {
            $sentMessage = $client->messages->create($recipients, [
                'from' => $twilio_number,
                'body' => $message
            ]);

            Messages::create([
                'added_by' => $userId,
                'twilio_message_id' => $sentMessage->sid,
                'body' => $message,
                'recipient' => $recipients,
                'status' => $sentMessage->status,
                // Add more fields as needed
            ]);
        } catch (RestException $e) {
            Log::error('Twilio API error: ' . $e->getMessage());
            throw $e;
        }
        // $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }
    public function showMessages()
    {
        $userId = Auth::id();
        $users = Messages::where('added_by', $userId)->get();;
        if ($users->count() > 0) {
            return response()->json([
                "status" => 200,
                "messages" => $users
            ], 200);
        } else {
            return response()->json([
                "status" => 404,
                "message" => "No record found"
            ], 404);
        }        // view('welcome', compact("users"));
    }

    public function showInboxMessages()
{
    // Get the ID of the currently logged-in user
    $userId = Auth::id();

    // Retrieve phone numbers where user_id matches the current user's ID
    $phoneNumbers = UsersPhoneNumber::where('user_id', $userId)->pluck('phone_number')->toArray();

    // Retrieve messages where the recipient is in the list of the user's phone numbers
    $messages = Messages::whereIn('recipient', $phoneNumbers)->get();

    if ($messages->count() > 0) {
        return response()->json([
            "status" => 200,
            "messages" => $messages
        ], 200);
    } else {
        return response()->json([
            "status" => 404,
            "message" => "No record found"
        ], 404);
    }}



    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $to = $validatedData['to'];
        $subject = $validatedData['subject'];
        $message = $validatedData['message'];

        try {
            // Send the email
            // Mail::to($to)->send(new SendEmail($subject, $message));
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)
                    ->subject($subject);
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Email sent successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log any errors if necessary
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
