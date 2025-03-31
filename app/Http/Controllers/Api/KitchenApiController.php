<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;
class KitchenApiController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function getOrders()
    {
       
        $orders = $this->orderRepo->all()->sortByDesc('created_at')->values()->load('concessions');
        return response()->json(['orders' => $orders]);
    }
    

    public function completeOrder($id)
    {
        $order = $this->orderRepo->find($id);
        $order->update(['status' => 'Completed']);
        return response()->json(['message' => 'Order marked as completed!']);
    }

    public function updatePendingOrders()
    {
        $currentTime = Carbon::now()->setTimezone('Asia/Colombo');

        $orders = $this->orderRepo->all()->filter(function ($order) use ($currentTime) {
            return $order->status === 'Pending' && $order->send_to_kitchen_time <= $currentTime;
        });

        foreach ($orders as $order) {
            $order->update(['status' => 'In-Progress']);
        }

        return response()->json(['message' => 'Orders updated successfully!']);
    }

}