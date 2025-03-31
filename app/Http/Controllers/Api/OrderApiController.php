<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo->all()->sortByDesc('created_at')->values()->load('concessions');
        return response()->json(['orders' => $orders]);
    }

    public function sendToKitchen($id)
    {
        $order = $this->orderRepo->find($id);
        $order->update(['status' => 'In-Progress']);
        return response()->json(['message' => 'Order sent to kitchen successfully!']);
    }

    public function destroy($id)
    {
        $order = $this->orderRepo->find($id);

        if ($order) {
            // Delete the order and associated records
            $order->concessions()->detach();  // Detach the associated concessions
            $order->delete();  // Delete the order from the database

            return response()->json(['message' => 'Order deleted successfully!'], 200);
        }

        return response()->json(['message' => 'Order not found!'], 404);
    }

    
}