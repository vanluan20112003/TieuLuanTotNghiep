<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
// app/Http/Controllers/AdminOrderController.php

// app/Http/Controllers/AdminOrderController.php
public function index(Request $request)
{
    // Lấy các tham số từ request
    $status = $request->input('status');
    $month = $request->input('month');
    $sort = $request->input('sort', 'created_at_asc'); // Mặc định sắp xếp từ cũ đến mới

    // Lọc đơn hàng theo trạng thái
    $query = Order::query();

    if ($status) {
        $query->where('status', $status);
    }

    if ($month) {
        $query->whereMonth('created_at', $month);
    }

    // Sắp xếp
    switch ($sort) {
        case 'created_at_desc':
            $query->orderBy('created_at', 'desc');
            break;
        case 'name_asc':
            $query->orderBy('user_id');
            break;
        case 'name_desc':
            $query->orderBy('user_id', 'desc');
            break;
        default:
            $query->orderBy('created_at');
            break;
    }

    // Lấy dữ liệu đơn hàng với thông tin chi tiết
    $orders = $query->with('user', 'orderDetails.product')->get();

    return view('layouts.admin_orders', compact('orders'));
}


    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('layouts.show_admin_order', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('layouts.edit_admin_order', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa.');
    }
    public function updateStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);
    
        if ($order->status === 'pending') {
            if ($request->input('action') === 'accept') {
                $order->status = 'processing'; // Cập nhật trạng thái thành 'processing'
            } elseif ($request->input('action') === 'reject') {
                $order->status = 'cancelled'; // Cập nhật trạng thái thành 'cancelled'
            }
    
            $order->save();
        }
    
        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
    
}
