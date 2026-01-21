<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreOrderRequest;
use App\Http\Requests\Api\V1\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    
    private OrderService $orderService;

    /**
     * Inject Dependencies
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * View orders
     */
    public function index()
    {
        return response()->json(
            $this->orderService->listForUser(request()->user())
        );
    }

    /**
     * Create order
     */
    public function store(StoreOrderRequest $request)
    {
        return response()->json(
            $this->orderService->create(
                $request->user(),
                $request->validated()
            ),
            201
        );
    }

    /**
     * Update order status
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order) {
        return response()->json(
            $this->orderService->updateStatus(
                $order,
                $request->status,
                $request->user()
            )
        );
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        $this->authorize('update', [$order, 'cancelled']);

        return response()->json(
            $this->orderService->updateStatus(
                $order,
                'cancelled',
                request()->user()
            )
        );
    }
}
