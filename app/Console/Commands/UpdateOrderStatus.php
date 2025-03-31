<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:update-status';
    protected $description = 'Update order status from Pending to In-Progress when send_to_kitchen_time is reached';

    public function handle()
    {
        $currentTime = Carbon::now();

        $orders = Order::where('status', 'Pending')
            ->where('send_to_kitchen_time', '<=', $currentTime)
            ->update(['status' => 'In-Progress']);

        $this->info('Orders updated successfully!');
    }
}
