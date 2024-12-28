@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản lý Người dùng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <!-- Tìm kiếm người dùng -->
            <form action="{{ route('admin.user.index') }}" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên hoặc email" value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <!-- Thêm người dùng -->
            <a href="{{ route('admin.user.create') }}" class="btn btn-success">Thêm Người dùng</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->address ?: 'Chưa cập nhật' }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at}}</td>
                    <td>
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Không có người dùng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>


@endsection
