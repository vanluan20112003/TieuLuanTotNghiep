<?php
namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SlideController extends Controller
{
    // Lấy tất cả các slide có status = 1
    public function index()
    {
        // Lấy tất cả các banner có status = 1, sắp xếp theo ngày tạo, ưu tiên is_header = 1
        $banners = Slide::where('status', 1)
                        ->orderByDesc('created_at')
                        ->get();
        
        return response()->json($banners);
    }

    // Lấy dữ liệu chi tiết của banner để chỉnh sửa
    public function show($id)
    {
        $banner = Slide::find($id);

        if ($banner) {
            return response()->json($banner);
        } else {
            return response()->json(['message' => 'Banner not found'], 404);
        }
    }

    // Cập nhật thông tin banner
    public function update(Request $request)
    {
        $banner = Slide::find($request->id);
    
        if ($banner) {
            // Kiểm tra nếu banner đang là ảnh bìa và status = 1
            if ($request->is_header == 1) {
                $existingHeader = Slide::where('is_header', 1)->where('status', 1)->where('id', '!=', $request->id)->first();
                if ($existingHeader) {
                    return response()->json(['message' => 'Slide id đang là header. Vui lòng tắt header!'], 400);
                }
            }
    
            // Cập nhật các trường nội dung
            $banner->content_1 = $request->content_1;
            $banner->content_2 = $request->content_2;
            $banner->content_3 = $request->content_3;
            $banner->is_header = $request->is_header;
            
            // Cập nhật URL nếu có
            if ($request->has('url')) {
                $banner->url = $request->url;
            }
    
            // Cập nhật ảnh nếu có
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($banner->image && File::exists(public_path('images/' . $banner->image))) {
                    File::delete(public_path('images/' . $banner->image));
                }
            
                // Lưu ảnh mới
                $image = $request->file('image');
                $imageExtension = $image->getClientOriginalExtension();
                $imageName = $banner->id . '_slide.' . $imageExtension; // Đặt tên ảnh theo id_slide
            
                // Lưu ảnh vào thư mục images
                $image->move(public_path('images'), $imageName);
            
                // Cập nhật trường 'image' trong database
                $banner->image = $imageName;
            }
    
            // Lưu lại
            $banner->save();
    
            return response()->json(['message' => 'Banner updated successfully']);
        } else {
            return response()->json(['message' => 'Banner not found'], 404);
        }
    }
    
    public function checkHeader($bannerId)
    {
        $existingHeader = Slide::where('is_header', 1)->where('status', 1)->where('id', '!=', $bannerId)->exists();
        return response()->json(['exists' => $existingHeader]);
    }
    // Cập nhật trạng thái (Tắt/Bật)
    public function toggleStatus(Request $request)
    {
        $banner = Slide::find($request->id);

        if ($banner) {
            $banner->status = $request->status;
            $banner->save();

            return response()->json(['message' => $request->status == 1 ? 'Banner enabled' : 'Banner disabled']);
        } else {
            return response()->json(['message' => 'Banner not found'], 404);
        }
    }

    // Tạo mới một banner
    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'content_1' => 'nullable|string|max:255',
                'content_2' => 'nullable|string|max:255',
                'content_3' => 'nullable|string|max:255',
                'image' => 'required|image|max:2048', // giới hạn 2MB
                'url' => 'nullable|string|max:255'
            ]);
    
            // Kiểm tra ít nhất một content phải có
            if (empty($request->content_1) && empty($request->content_2) && empty($request->content_3)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập ít nhất một ô nội dung.'
                ], 422);
            }
    
           
            // Tạo banner
            $banner = new Slide();
            $banner->content_1 = $request->content_1;
            $banner->content_2 = $request->content_2;
            $banner->content_3 = $request->content_3;
            $banner->url = $request->url;
            $banner->save();
    
            // Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $banner->id . '_slide.' . $image->getClientOriginalExtension();
                
                // Đảm bảo thư mục tồn tại
                if (!file_exists(public_path('images'))) {
                    mkdir(public_path('images'), 0777, true);
                }
                
                $image->move(public_path('images'), $imageName);
                $banner->image = $imageName;
                $banner->save();
            }
    
         
    
            return response()->json([
                'success' => true,
                'message' => 'Slide mới đã được tạo thành công.'
            ]);
    
        } catch (\Exception $e) {
       
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateBannerStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:slide,id', // Thay đổi từ 'banners' thành 'slides'
            'status' => 'required|in:0,1',
        ]);
    
        // Lấy slide bằng ID từ bảng 'slides'
        $slide = Slide::find($request->id); // Slide model sẽ tương tác với bảng slides
    
        if ($slide) {
            // Kiểm tra nếu trạng thái slide là 1 (Đang là ảnh bìa)
            if ($slide->is_header == 1 && $slide->status == 1 && $request->status == 0) {
                return response()->json(['message' => 'Slide đang là ảnh bìa. Vui lòng tắt ảnh bìa trước.'], 400);
            }
    
            // Cập nhật trạng thái
            $slide->status = $request->status;
            $slide->save();
    
            return response()->json(['message' => 'Trạng thái slide đã được cập nhật thành công.']);
        }
    
        return response()->json(['message' => 'Slide không tồn tại.'], 404);
    }
    
}
