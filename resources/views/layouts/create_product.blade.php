@extends('layouts.admin')

@section('content')
    <h2>Add New Product</h2>

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label for="quantity_in_stock">Quantity in Stock</label>
            <input type="number" id="quantity_in_stock" name="quantity_in_stock" class="form-control" step="1" min="0" required>
        </div>

        <div class="form-group">
            <label for="original_price">Original Price</label>
            <input type="number" id="original_price" name="original_price" class="form-control" step="0.01" min="0">
        </div>

        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" id="discount" name="discount" class="form-control" step="0.01" min="0">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
@endsection
