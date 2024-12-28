@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản lý Đơn hàng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bộ lọc -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="status">Trạng thái</label>
                <select id="status" name="status" class="form-control">
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="month">Tháng</label>
                <select id="month" name="month" class="form-control">
                    <option value="">Tất cả</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                            Tháng {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="sort">Sắp xếp theo</label>
                <select id="sort" name="sort" class="form-control">
                    <option value="created_at_asc" {{ request('sort') === 'created_at_asc' ? 'selected' : '' }}>Ngày cũ đến mới</option>
                    <option value="created_at_desc" {{ request('sort') === 'created_at_desc' ? 'selected' : '' }}>Ngày mới đến cũ</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Tên khách hàng A-Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Tên khách hàng Z-A</option>
                </select>
            </div>
            <div class="form-group col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Ngày đặt hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Chi tiết đơn hàng</th>
                <th>Ghi chú từ khách hàng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Unknown' }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        @foreach($order->orderDetails as $detail)
                            - {{ $detail->product->name }} (Số lượng: {{ $detail->quantity }})<br>
                        @endforeach
                    </td>
                    <td>{{ $order->notes }}</td>
                    <td>
    @if($order->status === 'pending')
        <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST">
            @csrf
            <button type="submit" name="action" value="accept" class="btn btn-primary">Chấp nhận</button>
            <button type="submit" name="action" value="reject" class="btn btn-danger">Từ chối</button>
        </form>
    @endif
    <!-- Các hành động khác như xem, chỉnh sửa, xóa -->
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
