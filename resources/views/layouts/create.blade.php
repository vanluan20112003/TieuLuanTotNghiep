@extends('layouts.admin')

@section('content')
    <h2>Add Category</h2>
    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Category Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
