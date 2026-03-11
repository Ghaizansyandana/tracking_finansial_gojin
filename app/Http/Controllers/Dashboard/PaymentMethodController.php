<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->paginate(10);
        return view('dashboard.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('dashboard.payment-methods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank,ewallet',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment-methods', $filename, 'public');
            $validated['logo'] = $path;
        }

        PaymentMethod::create($validated);

        return redirect()->route('dashboard.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('dashboard.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank,ewallet',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($paymentMethod->logo) {
                Storage::disk('public')->delete($paymentMethod->logo);
            }
            
            $file = $request->file('logo');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment-methods', $filename, 'public');
            $validated['logo'] = $path;
        }

        $paymentMethod->update($validated);

        return redirect()->route('dashboard.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->logo) {
            Storage::disk('public')->delete($paymentMethod->logo);
        }
        
        $paymentMethod->delete();

        return redirect()->route('dashboard.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
