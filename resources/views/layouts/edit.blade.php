<!-- resources/views/admin/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <h2>Edit Category</h2>

    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="image">Category Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if ($category->image)
                <img src="{{ asset('images/' . $category->image) }}" alt="{{ $category->name }}" style="width: 100px; height: auto;">
            @endif
            @if ($errors->has('image'))
                <span class="text-danger">{{ $errors->first('image') }}</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
