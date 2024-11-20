<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderProcessed extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
      $this->order = $order;
    }

    public function via($notifiable)
    {
      return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
      $orderUrl = url("/orders/{$this->order->id}");
      $company = 'Acme';
      $deliveryDate = $this->order->created_at->addDays(4)->toFormattedDateString();


      return (new WhatsAppMessage)
      ->content("Your {$company} order of {$this->order->name} has shipped and should be delivered on {$deliveryDate}. Details: {$orderUrl}");
        //   ->content('ANG ANG ANG ANG');
    }
}
