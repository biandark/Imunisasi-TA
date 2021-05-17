<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class Reminder extends Model
{
    use HasFactory;

    public function sendReminder($jenis_imunisasi){
        $sid    = getenv('TWILIO_ACCOUNT_SID');
        $token  = getenv('TWILIO_AUTH_TOKEN');
        $sandbox_number=getenv('WHATSAPP_SANDBOX_NUMBER');
        $subscriber_number = "+6282140302548";
        $message = "Halo besok waktunya imunisasi: $jenis_imunisasi";

        $twilio = new Client($sid, $token);
        $message = $twilio->messages
                        ->create("whatsapp:".$subscriber_number,
                                array(
                                    "from" => "whatsapp:".$sandbox_number,
                                    "body" => $message
                                )
                        );
    }
}
