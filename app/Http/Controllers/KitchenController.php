<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;

class KitchenController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

   
    public function index()
    {

        return view('kitchen.index'); 
    }

    

    
}