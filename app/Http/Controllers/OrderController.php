<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Get all orders for the logged-in user
        $orders = Order::where('user_id', Auth::id()) // Assuming orders are related to the user by user_id
                      ->orderBy('created_at', 'desc') // Orders will be displayed by date
                      ->get();

        return view('order-history', compact('orders'));
    }

    /**
     * Display the order form.
     */
    public function create()
    {
        return view('order');
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'required|string',
            'weight' => 'required|numeric|min:1',
            'address' => 'required|string',
        ]);

        try {
            // Calculate the price based on weight (assuming a fixed price per kg, e.g., 10)
            $pricePerKg = 10000;  // Adjust this rate as needed
            $price = $request->weight * $pricePerKg;

            // Create the order with the validated data and calculated price and status
            $order = Order::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'service' => $request->service,
                'weight' => $request->weight,
                'address' => $request->address,
                'status' => 'pending', // Default status
                'price' => $price, // Calculated price
                'user_id' => auth()->id(), // Assuming the order is related to the authenticated user
            ]);

            // Redirect back with a success message including the order ID
            return redirect()->route('orders.create')->with('success', 'Order placed successfully! Order ID: ' . $order->id);
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with an error message
            return redirect()->route('orders.create')->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function cancelOrder(Order $order)
    {
        // Check if the user is authorized to cancel the order
        if (auth()->user()->id !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Update the status to 'canceled'
        $order->status = 'canceled';
        $order->save();
    
        return response()->json(['message' => 'Order canceled successfully', 'order' => $order]);
    }
}
