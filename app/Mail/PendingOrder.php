<?php
/**
 * Created by PhpStorm.
 * User: vgs
 * Date: 12/23/20
 * Time: 2:06 PM
 */

namespace App\Mail;

use App\MasterBooking;
use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $orderId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $OrderDetail=MasterBooking::find($this->orderId);
        $sendMail=User::find($OrderDetail->user_master_iduser_master);

        return $this->
        view('emails/order-place',['orderId'=>$this->orderId,])->
        to($sendMail->email)->
        subject('Royal Laundry Place Message');

    }

}