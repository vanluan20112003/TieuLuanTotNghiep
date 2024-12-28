<!-- resources/views/csv/upload.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tải lên và hiển thị file CSV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Tải lên và hiển thị file CSV</h1>
        <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="csv_file">Chọn file CSV</label>
                <input type="file" class="form-control" id="csv_file" name="csv_file" required>
                @error('csv_file')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tải lên</button>
        </form>

        @if(!empty($data))
            <h2 class="mt-5">Nội dung file CSV</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @if (!empty($data))
                            @foreach ($data[0] as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $row)
                        
                            <tr>
                                @foreach ($row as $cell)
                                    <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                     
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
