<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Concession;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo->all();
        return view('orders.index', compact('orders'));
    }

    
    public function create()
    {
        $concessions = Concession::all();

    // Pass the concessions to the view
    return view('orders.create', compact('concessions'));

        
    }

   
    public function store(Request $request)
    {
        // Filter out unselected checkboxes (only keep checked concessions)
        $selectedConcessions = collect($request->selected_concessions)
            ->filter(fn($concession) => !empty($concession['id']) && !empty($concession['quantity'])) // Ensure ID & quantity exist
            ->values(); // Re-index array
    
        // Validate at least one concession is selected
        if ($selectedConcessions->isEmpty()) {
            return redirect()->back()->withErrors(['selected_concessions' => 'You must select at least one concession.'])->withInput();
        }
    
        // Validate fields
        $request->validate([
            'send_to_kitchen_time' => 'required|date',
        ]);
    
        // Create a new order
        $order = $this->orderRepo->create([
            'send_to_kitchen_time' => $request->send_to_kitchen_time,
            'status' => 'Pending',
            'selected_concessions' => json_encode($selectedConcessions), // Store as JSON
        ]);
    
        // Attach selected concessions to the table
        foreach ($selectedConcessions as $concession) {
            $order->concessions()->attach($concession['id'], ['quantity' => $concession['quantity']]);
        }
    
        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }
    
    
   
    
}