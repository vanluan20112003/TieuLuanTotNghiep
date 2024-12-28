@extends('layouts.admin')

@section('content')
    <h2>Edit Product</h2>
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" id="category" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="original_price">Original Price</label>
            <input type="number" name="original_price" id="original_price" class="form-control" value="{{ old('original_price', $product->original_price) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="quantity_in_stock">Quantity in Stock</label>
            <div class="input-group">
                <input type="number" name="quantity_in_stock" id="quantity_in_stock" class="form-control" value="{{ old('quantity_in_stock', $product->quantity_in_stock) }}" min="0" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-secondary" onclick="changeQuantity(-1)">-</button>
                    <button type="button" class="btn btn-secondary" onclick="changeQuantity(1)">+</button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="discount">Discount (%)</label>
            <input type="number" name="discount" id="discount" class="form-control" value="{{ old('discount', $product->discount) }}" step="0.01" min="0" max="100" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image (Optional)</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($product->image)
                <img src="{{  asset('images/' . $product->image) }}" alt="Product Image" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <script>
        function changeQuantity(amount) {
            var quantityInput = document.getElementById('quantity_in_stock');
            var currentValue = parseInt(quantityInput.value) || 0;
            quantityInput.value = currentValue + amount;
        }
    </script>
@endsection
