@extends('layouts.admin')

@section('content')
    <h2>Category Management</h2>
    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('admin.category.index') }}" method="GET" class="form-inline">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search categories" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
    <i class="bi bi-plus"></i> Add Category
</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Product Count</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->product_count }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('images/' . $category->image) }}" alt="{{ $category->name }}" style="width: 100px; height: auto;">
                            @else
                                No image
                            @endif
                        </td>
                        <td>
                           <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            $('.delete-form').on('submit', function (e) {
                e.preventDefault(); // Ngăn không cho form gửi theo cách truyền thống
                var form = $(this);
                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(), // Serialize form data
                        success: function (response) {
                            alert(response.message); // Hiển thị thông báo từ server
                            if (response.redirect) {
                                window.location.href = response.redirect; // Điều hướng đến trang danh mục
                            } else {
                                // Xóa hàng khỏi bảng mà không làm tải lại trang
                                form.closest('tr').remove();
                            }
                        },
                        error: function (xhr) {
                            console.error('Error:', xhr.responseText);
                            alert('Failed to delete category');
                        }
                    });
                }
            });
        });
    </script>
@endsection
