<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\TheDaNang;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Models\Transaction;

use Illuminate\Support\Facades\Auth;
class ExportController extends Controller
{
    public function exportUsers()
    {
        // Lấy dữ liệu từ bảng users
        $users = DB::table('users')->get();

    // Đặt tên file CSV
    $fileName = "users.csv";

    // Header để tạo file CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');

    // Mở output stream
    $output = fopen('php://output', 'w');

    // Thêm BOM để Excel nhận diện mã hóa UTF-8
    fwrite($output, "\xEF\xBB\xBF");

    // In dòng đầu tiên là tên các cột
    if ($users->isNotEmpty()) {
        // Lấy tên cột từ key của dòng đầu tiên
        fputcsv($output, array_keys((array) $users->first()));
    }

    // In dữ liệu từng hàng, sử dụng fputcsv để tách cột đúng chuẩn CSV
    foreach ($users as $user) {
        fputcsv($output, (array) $user);
    }

    fclose($output);
    exit;
    }
    
     public function exportTransactionsToCsv()
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        $theDaNang = TheDaNang::where('user_id', $user->id)->first(); // Lấy thẻ đa năng của người dùng

        if (!$theDaNang) {
            return response()->json(['error' => 'TheDaNang not found.'], 404);
        }

        // Lấy tất cả các giao dịch của thẻ đa năng
        $transactions = Transaction::where('the_da_nang_id', $theDaNang->id)->get();

        // Đặt tên file CSV
        $fileName = "transactions.csv";

        // Header để tạo file CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');

        // Mở output stream
        $output = fopen('php://output', 'w');

        // Thêm BOM để Excel nhận diện mã hóa UTF-8
        fwrite($output, "\xEF\xBB\xBF");

        // In dòng đầu tiên là tên các cột
        fputcsv($output, ['Loại Giao Dịch', 'Số Tiền', 'Ngày']);

        // In dữ liệu từng hàng, sử dụng fputcsv để tách cột đúng chuẩn CSV
        foreach ($transactions as $transaction) {
            fputcsv($output, [
                $transaction->loai_giao_dich,
                $transaction->so_tien,
                $transaction->created_at->format('d F Y'),
            ]);
        }

        fclose($output);
        exit;
    }
    public function exportProduct(Request $request)
    {
        // Kiểm tra loại xuất
        $type = $request->input('type', 'all'); // Mặc định xuất tất cả

        // Lấy dữ liệu sản phẩm
        if ($type === 'selected') {
            $ids = $request->input('ids', []); // Lấy danh sách ID, mặc định là mảng rỗng
            if (!is_array($ids)) {
                $ids = explode(',', $ids); // Nếu `$ids` là chuỗi, chuyển thành mảng
            }
        
            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'Không có sản phẩm nào được chọn.']);
            }
        
            $products = Product::whereIn('id', $ids)->get();
        } else {
            $products = Product::all();
        }
        

        // Tạo response dạng StreamedResponse để xuất CSV
        $response = new StreamedResponse(function () use ($products) {
            // Mở file output
            $handle = fopen('php://output', 'w');

            // Ghi BOM để đảm bảo UTF-8
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Ghi tiêu đề cột
            fputcsv($handle, [
                'ID',
                'Tên',
                'Danh mục',
                'Giá gốc',
                'Khuyến mãi (%)',
                'Giá bán',
                'Số lượng tồn',
                'Ngày thêm'
            ]);

            // Ghi dữ liệu sản phẩm vào file CSV
            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->name,
                    $product->category->name ?? 'Không có danh mục',
                    number_format($product->original_price, 0, ',', '.'),
                    $product->discount ? $product->discount . '%' : '0%',
                    number_format($product->price, 0, ',', '.'),
                    $product->quantity_in_stock,
                    $product->created_at->format('d/m/Y')
                ]);
            }

            // Đóng file output
            fclose($handle);
        });

        // Thiết lập header để trình duyệt tải file
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="danh_sach_san_pham.csv"');

        return $response;
    }
}
