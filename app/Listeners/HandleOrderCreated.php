<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HandleOrderCreated
{
    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event?->order;

        Mail::to($order?->user?->email)
            ->send(new OrderCreatedMail($order));

        Log::info('Order created listener executed', [
            'order_id' => $order?->id,
            'order_number' => $order?->order_number,
            'status'   => $order?->status,
        ]);
    }
}
