<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodities = \App\Models\Commodity::latest()->get();
        return view('commodities.index', compact('commodities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commodities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'unit', 'price']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/commodities'), $filename);
            $data['image_path'] = 'uploads/commodities/' . $filename;
        }

        $commodity = \App\Models\Commodity::create($data);

        // Record initial price history
        \App\Models\PriceHistory::create([
            'commodity_id' => $commodity->id,
            'price_value' => $commodity->price,
            'date_recorded' => now(),
            'recorded_by_id' => auth()->id() ?? null, 
        ]);

        return redirect()->route('commodities.index')->with('success', 'Commodity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $commodity = \App\Models\Commodity::findOrFail($id);
        return view('commodities.edit', compact('commodity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $commodity = \App\Models\Commodity::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'unit', 'price']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/commodities'), $filename);
            $data['image_path'] = 'uploads/commodities/' . $filename;
        }

        // Check if price changed
        if ($commodity->price != $request->price) {
             \App\Models\PriceHistory::create([
                'commodity_id' => $commodity->id,
                'price_value' => $request->price,
                'date_recorded' => now(),
                'recorded_by_id' => auth()->id() ?? null,
            ]);
        }

        $commodity->update($data);

        return redirect()->route('commodities.index')->with('success', 'Commodity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commodity = \App\Models\Commodity::findOrFail($id);
        $commodity->delete();
        return redirect()->route('commodities.index')->with('success', 'Commodity deleted successfully.');
    }
    public function print_pdf()
    {
        $commodities = \App\Models\Commodity::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('commodities.pdf', ['commodities' => $commodities]);
        return $pdf->download('laporan-harga-pasar.pdf');
    }
}
