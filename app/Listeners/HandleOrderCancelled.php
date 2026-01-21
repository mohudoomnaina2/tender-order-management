<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Mail\OrderCancelledMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HandleOrderCancelled
{
    /**
     * Handle the event.
     */
    public function handle(OrderCancelled $event): void
    {
        $order = $event?->order;

        Mail::to($order?->user?->email)
            ->send(new OrderCancelledMail($order));

        Log::info('Order cancelled listener executed', [
            'order_id' => $order?->id,
            'order_number' => $order?->order_number,
            'status'   => $order?->status,
        ]);
    }
}
