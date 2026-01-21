<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * View orders
     */
    public function listForUser(User $user): Collection
    {
        if ($user->hasPermission('view_all_orders')) {
            return Order::with('items', 'statusHistories')
                ->latest()
                ->get();
        }

        return Order::with('items', 'statusHistories')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }

    /**
     * Create new order
     */
    public function create(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {

            // Calculate total
            $total = collect($data['items'])->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            // Create order
            $order = Order::create([
                'user_id'      => $user->id,
                'order_number' => Str::uuid(),
                'status'       => 'pending',
                'total_amount' => $total,
            ]);

            // Create order items
            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
            }

            // Status
            OrderStatusHistory::create([
                'order_id'    => $order->id,
                'from_status' => null,
                'to_status'   => 'pending',
                'changed_by'  => $user->id,
            ]);

            return $order->load('items');
        });
    }

    /**
     * Update order status (used for cancel as well)
     */
    public function updateStatus(Order $order, string $newStatus, User $user): Order {
        return DB::transaction(function () use ($order, $newStatus, $user) {
            $oldStatus = $order->status;

            $order->update([
                'status' => $newStatus,
            ]);

            OrderStatusHistory::create([
                'order_id'    => $order->id,
                'from_status' => $oldStatus,
                'to_status'   => $newStatus,
                'changed_by'  => $user->id,
            ]);

            return $order->fresh();
        });
    }
}
