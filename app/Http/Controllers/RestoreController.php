<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class RestoreController extends Controller
{
    public function getDeletedProducts()
    {
        $products = Product::where('is_deleted', 1)->with('category')->get();
        return response()->json($products);
    }

    public function getDeletedOrders()
    {
        $orders = Order::where('is_deleted', 1)->with('user')->get();
        return response()->json($orders);
    }
    public function restoreProduct($id)
{
    $product = Product::findOrFail($id);
    $product->is_deleted = 0;
    $product->save();

    return response()->json(['message' => 'Product restored successfully.']);
}

public function restoreOrder($id)
{
    $order = Order::findOrFail($id);
    $order->is_deleted = 0;
    $order->save();

    return response()->json(['message' => 'Order restored successfully.']);
}
}
