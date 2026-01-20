<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_all_orders');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->hasPermission('view_all_orders')
            || ($user->hasPermission('view_own_orders') && $order->user_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_order');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order, string $newStatus): bool
    {
        // Admin override
        if ($user->hasPermission('override_status')) {
            return true;
        }

        // Cancel allowed only when pending
        if ($newStatus === 'cancelled') {
            return $order->status === 'pending'
                && $user->hasPermission('cancel_order');
        }

        // Validate status flow
        $allowed = config('order_status.flow')[$order->status] ?? [];

        return in_array($newStatus, $allowed)
            && $user->hasPermission('update_order_status');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
