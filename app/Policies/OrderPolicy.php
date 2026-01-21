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
        return $user->hasPermission('view_all_orders') || $user->hasPermission('view_own_orders');
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
        // Check status text validation
        if (! in_array($newStatus, config('order_status.valid', []), true)) {
            return false;
        }

        // Cancel logic
        if ($newStatus === 'cancelled') {
            // Warehouse(Never cancel)
            if ($user->hasRole('warehouse')) {
                return false;
            }

            // Customer(Only pending)
            if ($user->hasRole('customer')) {
                return $order->status === 'pending';
            }

            // Admin & Order Manager(Any status)
            return $user->hasRole('admin')
                || $user->hasRole('order_manager');
        }

        // Warehouse update status(limited)
        if ($user->hasRole('warehouse')) {
            $allowedStatuses = config('order_status.warehouse_allowed', []);

            return in_array($newStatus, $allowedStatuses, true)
                && in_array(
                    $newStatus,
                    config('order_status.flow')[$order->status] ?? [],
                    true
                ) && $user->hasPermission('update_order_status');
        }

        // Admin override
        if ($user->hasPermission('override_status')) {
            return true;
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
