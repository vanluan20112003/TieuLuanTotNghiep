@extends('layouts.admin')

@section('content')
    <h2>Product Management</h2>
    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('admin.product.index') }}" method="GET" class="form-inline">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search products" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Product
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Posted Date</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Original Price</th>
                    <th>Discount</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Quantity sold</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr id="product-{{ $product->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td> <!-- Assuming category relationship is defined -->
                        <td>{{ $product->posted_date }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity_in_stock }}</td>
                        <td>{{ $product->original_price }}</td>
                        <td>{{ $product->discount }}</td>
                        <td>{{ $product->description }}</td>
                        

                        <td>
                            @if($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                            @else
                                No image
                            @endif
                        </td>
                        <td>{{ $product->quantity_sold}}</td>

                        <td>
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $product->id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                         </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện nhấn nút xóa
        $('.delete-btn').on('click', function(e) {
            e.preventDefault(); // Ngăn form gửi theo cách truyền thống

            var button = $(this);
            var form = button.closest('form');
            var productId = button.data('id');
            var row = $('#product-' + productId); // Lấy dòng sản phẩm

            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(), // Serialize form data
                    success: function(response) {
                        if (response.success) {
                            // Xóa dòng khỏi bảng
                            row.remove();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Error deleting product');
                    }
                });
            }
        });
    });
</script>

@endsection
