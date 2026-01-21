<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use App\Mail\OrderShippedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HandleOrderShipped implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(OrderShipped $event): void
    {
        $order = $event?->order;

        Mail::to($order?->user?->email)
            ->send(new OrderShippedMail($order));

        Log::info('Order shipped listener executed', [
            'order_id' => $order?->id,
            'order_number' => $order?->order_number,
            'status'   => $order?->status,
        ]);
    }
}

