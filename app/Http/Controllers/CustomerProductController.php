<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProductController extends Controller
{
    /**
     * Show form to assign product to customer
     */
    public function create($customerId)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $customer = Customer::with('lead')->findOrFail($customerId);
        
        // Get products not yet assigned to this customer
        $assignedProductIds = $customer->products->pluck('id')->toArray();
        $products = Product::whereNotIn('id', $assignedProductIds)->get();

        return view('customers.assign-product', compact('customer', 'products'));
    }

    /**
     * Assign product to customer
     */
    public function store(Request $request, $customerId)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $customer = Customer::findOrFail($customerId);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Check if product already assigned
        if ($customer->products()->where('product_id', $validated['product_id'])->exists()) {
            return back()->withErrors(['product_id' => 'Product already assigned to this customer.']);
        }

        $customer->products()->attach($validated['product_id'], [
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Product assigned successfully.');
    }

    /**
     * Remove product from customer
     */
    public function destroy($customerId, $productId)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $customer = Customer::findOrFail($customerId);
        $customer->products()->detach($productId);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Product removed from customer.');
    }
}
