<?php

namespace App\Http\Controllers;

use App\Repositories\ConcessionRepositoryInterface;
use Illuminate\Http\Request;

class ConcessionController extends Controller
{
    protected $concessionRepo;

    public function __construct(ConcessionRepositoryInterface $concessionRepo)
    {
        $this->concessionRepo = $concessionRepo;
    }

    
    public function index()
    {
        $concessions = $this->concessionRepo->all();
        return view('concessions.index', compact('concessions'));
    }

    
    public function create()
    {
        return view('concessions.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['image'] = $request->file('image')->store('concessions', 'public');

        $this->concessionRepo->create($data);
        return redirect()->route('concessions.index')->with('success', 'Concession created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('concessions', 'public');
        }

        $this->concessionRepo->update($id, $data);
        return redirect()->route('concessions.index')->with('success', 'Concession updated successfully!');
    }

   
    public function edit($id)
    {
        $concession = $this->concessionRepo->find($id);
        return view('concessions.edit', compact('concession'));
    }

    


   
    public function destroy($id)
    {
        $this->concessionRepo->delete($id);
        return redirect()->route('concessions.index')->with('success', 'Concession deleted successfully!');
    }
}