<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodSuggestion;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class FoodSuggestionController extends Controller
{
    /**
     * Kiểm tra khoa từ giọng nói và trả về câu hỏi tiếp theo hoặc thông báo không tìm thấy.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDepartment(Request $request)
{
    $departmentInput = $request->input('department'); // Lấy khoa từ người dùng
    
    // Làm sạch và chuẩn hóa chuỗi khoa
    $departmentInput = $this->sanitizeInput($departmentInput);

    // Lấy danh sách các khoa từ cơ sở dữ liệu
    $departmentSuggestions = FoodSuggestion::select('department_suggestion')->distinct()->get();

    // So sánh tương đối khoa
    $found = false;
    $matchedDepartment = null;

    foreach ($departmentSuggestions as $suggestion) {
        $departments = explode(',', $suggestion->department_suggestion); // Tách danh sách khoa
        foreach ($departments as $department) {
            // Làm sạch và chuẩn hóa khoa trong cơ sở dữ liệu
            $department = $this->sanitizeInput($department);

            // So sánh khoa đã làm sạch
            if (stripos($department, $departmentInput) !== false || stripos($departmentInput, $department) !== false) {
                $found = true;
                $matchedDepartment = $department;
                break 2;
            }
        }
    }

    if ($found) {
        // Random câu hỏi về bệnh
        $questions = [
            "Có phải khoa của bạn là $matchedDepartment, Bạn đang gặp vấn đề gì ở $matchedDepartment?",
            "Cảm ơn bạn vì câu trả lời, Bạn có thể mô tả triệu chứng liên quan đến khoa $matchedDepartment không?",
            "Vâng tôi đã hiểu, Xin hỏi, bạn đang gặp bệnh nào thuộc khoa $matchedDepartment?",
            "Vâng tôi hiểu khoa của bạn là $matchedDepartment, vậy  Vui lòng cho biết bạn đang cần tư vấn thực phẩm cho bệnh nào ở khoa $matchedDepartment."
        ];
        $randomQuestion = $questions[array_rand($questions)];

        return response()->json([
            'status' => 'success',
            'message' => $randomQuestion
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => "Xin lỗi, tôi không tìm thấy hướng dẫn về thực phẩm cho  \"$departmentInput\"."
        ]);
    }
}


    /**
     * Làm sạch và chuẩn hóa đầu vào (xóa dấu cách thừa, chuyển thành chữ thường, v.v.)
     *
     * @param string $input
     * @return string
     */
    private function sanitizeInput($input)
    {
        // Loại bỏ dấu cách thừa và chuyển về chữ thường
        $input = trim($input); // Loại bỏ dấu cách đầu và cuối
        $input = strtolower($input); // Chuyển sang chữ thường
      // Loại bỏ ký tự đặc biệt
      $input = trim(preg_replace('/\bKhoa\b/i', '', $input));
        return $input;
    }

    public function checkDisease(Request $request)
    {
        $departmentInput = $this->sanitizeInput($request->input('department'));
        $diseaseInput = $this->sanitizeInput($request->input('disease'));
        
        // Process disease input to remove unnecessary words
        $diseaseInput = $this->processDiseaseInput($diseaseInput);
        
        // Get all unique combinations of department and disease from database
        $suggestions = FoodSuggestion::select('department_suggestion', 'disease_suggestion')
            ->distinct()
            ->get();
        
        // Variables to track best matches
        $found = false;
        $bestMatchDepartment = $departmentInput; // Mặc định là input ban đầu
        $bestMatchDisease = $diseaseInput; // Mặc định là input ban đầu
        $exactMatch = false;
        
        // Compare both department and disease
        foreach ($suggestions as $suggestion) {
            $departments = explode(',', $suggestion->department_suggestion);
            $diseases = explode(',', $suggestion->disease_suggestion);
            
            // Check each department
            foreach ($departments as $department) {
                $department = $this->sanitizeInput($department);
                
                // If department matches, check diseases
                if (stripos($department, $departmentInput) !== false || 
                    stripos($departmentInput, $department) !== false) {
                    
                    // Lưu department match tốt nhất
                    $bestMatchDepartment = $department;
                    
                    // Check each disease for this department
                    foreach ($diseases as $disease) {
                        $disease = $this->sanitizeInput($disease);
                        
                        // Compare disease strings
                        if (stripos($disease, $diseaseInput) !== false || 
                            stripos($diseaseInput, $disease) !== false) {
                            $found = true;
                            $bestMatchDisease = $disease;
                            $exactMatch = true;
                            break 3;  // Break all loops if exact match found
                        }
                    }
                }
            }
        }
        
        if ($exactMatch) {
            // Query for products matching the found department and disease
            $matchingProducts = FoodSuggestion::where('department_suggestion', 'LIKE', "%$bestMatchDepartment%")
                ->where('disease_suggestion', 'LIKE', "%$bestMatchDisease%")
                ->get();
                
            if ($matchingProducts->count() > 0) {
                // Filter by meal time if applicable
                $mealTime = $this->getMealTime();
                $mealTimeMatches = $matchingProducts->filter(function ($foodSuggestion) use ($mealTime) {
                    return strpos($foodSuggestion->meal_time, $mealTime) !== false;
                });
                
                // Select appropriate product
                $selectedProduct = $mealTimeMatches->count() > 0 ? 
                    $mealTimeMatches->random() : 
                    $matchingProducts->random();
                
                $product = $selectedProduct->product;
                
                // Generate random response message
                $messages = [
                    "Vâng cảm ơn câu trả lời của bạn, tôi đã tìm thấy sản phẩm phù hợp cho bệnh {$bestMatchDisease}! Đây là sản phẩm: {$product->name} (Mã sản phẩm: {$product->id}).",
                    "Cảm ơn đã chia sẽ cụ thể cho tôi, Với tình trạng {$bestMatchDisease}, tôi gợi ý cho bạn sản phẩm: {$product->name}. Đây là mã sản phẩm: {$product->id}.",
                    "Tôi hiểu rồi, dựa trên bệnh {$bestMatchDisease}, sản phẩm phù hợp là: {$product->name} (Mã sản phẩm: {$product->id}).",
                    "Cảm ơn đã cung cấp thông tin cho tôi, cho bệnh {$bestMatchDisease}, tôi đề xuất sản phẩm: {$product->name} với mã sản phẩm: {$product->id}.",
                ];
                
                $randomMessage = $messages[array_rand($messages)];
                $randomMessage .= "\nHương vị: {$selectedProduct->flavor}.";
                $randomMessage .= "\nLợi ích: {$selectedProduct->benefits}.";
                $randomMessage .= "\nĐể mua sản phẩm, vui lòng tìm kiếm tên sản phẩm '{$product->name}' hoặc ID sản phẩm '{$product->id}'.";
                $randomMessage .= "\n\nBạn có hài lòng với sản phẩm này không? Vui lòng trả lời 'Có' hoặc 'Không'.";
                
                return response()->json([
                    'status' => 'success',
                    'message' => $randomMessage,
                    'ask_feedback' => true,
                    'product_id' => $product->id
                ]);
            }
        }
        
        // Nếu không tìm thấy kết quả chính xác, tìm sản phẩm thay thế với các giá trị gần đúng nhất
        return $this->getAlternateProduct($bestMatchDepartment, $bestMatchDisease);
    }
    /**
     * Xử lý chuỗi bệnh lý người dùng nhập, loại bỏ từ không cần thiết.
     */
    private function processDiseaseInput($input)
    {
        // Danh sách từ không cần thiết
        $unwantedWords = ['tôi', 'bị', 'có', 'là', 'mà', 'này', 'và', 'thì', 'đã', 'vừa'];
    
        // Chuyển về chữ thường và loại bỏ các từ không cần thiết
        $input = strtolower($input); // Chuyển về chữ thường để so sánh không phân biệt
        $input = preg_replace('/\b(' . implode('|', $unwantedWords) . ')\b/', '', $input); // Loại bỏ từ không cần thiết
        $input = trim($input); // Loại bỏ khoảng trắng thừa
    
        return $input;
    }
    

    public function getAlternativeProducts(Request $request)
    {
        $currentProductId = $request->input('current_product_id');
        $departmentInput = $this->sanitizeInput($request->input('department'));
        
        // Lấy tất cả các khoa từ database để so sánh
        $suggestions = FoodSuggestion::select('department_suggestion')
            ->where('product_id', '!=', $currentProductId)
            ->distinct()
            ->get();
        
        // Tìm khoa phù hợp nhất
        $matchedDepartment = null;
        $found = false;
        
        foreach ($suggestions as $suggestion) {
            $departments = explode(',', $suggestion->department_suggestion);
            
            foreach ($departments as $department) {
                $department = $this->sanitizeInput($department);
                
                // So sánh tương đối
                if (stripos($department, $departmentInput) !== false || 
                    stripos($departmentInput, $department) !== false) {
                    $found = true;
                    $matchedDepartment = $department;
                    break 2;
                }
            }
        }
        
        if ($found) {
            // Lấy 2 sản phẩm ngẫu nhiên từ khoa đã tìm thấy
            $alternativeProducts = FoodSuggestion::where('product_id', '!=', $currentProductId)
                ->where('department_suggestion', 'LIKE', "%$matchedDepartment%")
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->map(function($suggestion) {
                    return [
                        'name' => $suggestion->product->name,
                        'flavor' => $suggestion->flavor,
                        'benefits' => $suggestion->benefits,
                        'product_id' => $suggestion->product->id
                    ];
                });
    
            return response()->json([
                'status' => 'success',
                'products' => $alternativeProducts
            ]);
        }
        
        // Nếu không tìm thấy khoa phù hợp
        return response()->json([
            'status' => 'error',
            'message' => "Không tìm thấy sản phẩm thay thế cho khoa \"$departmentInput\"."
        ]);
    }
    private function getMealTime()
    {
        $currentTime = Carbon::now()->format('H:i');
        
        if ($currentTime >= '05:00' && $currentTime <= '10:00') {
            return 'sáng';
        } elseif ($currentTime >= '10:00' && $currentTime <= '14:00') {
            return 'trưa';
        } elseif ($currentTime >= '14:00' && $currentTime <= '17:00') {
            return 'xế';
        } else {
            return 'tối';
        }
    }

    private function getAlternateProduct($department, $disease)
    {
        $partialMatches = FoodSuggestion::where('department_suggestion', 'LIKE', "%$department%")
            ->orWhere('disease_suggestion', 'LIKE', "%$disease%")
            ->get();
    
        if ($partialMatches->count() > 0) {
            $mealTime = $this->getMealTime();
            $mealTimeMatches = $partialMatches->filter(function ($foodSuggestion) use ($mealTime) {
                return strpos($foodSuggestion->meal_time, $mealTime) !== false;
            });
    
            $selectedProduct = $mealTimeMatches->count() > 0 ? $mealTimeMatches->random() : $partialMatches->random();
            $product = $selectedProduct->product;
    
            // Tạo nhiều câu trả lời ngẫu nhiên cho sản phẩm thay thế
            $messages = [
                "Mặc dù không có sản phẩm chính xác, tôi sẽ gợi ý một sản phẩm có thể phù hợp với bạn: {$product->name} (Mã sản phẩm: {$product->id}).",
                "Chúng tôi không tìm thấy sản phẩm chính xác, nhưng có một sản phẩm khác mà bạn có thể thử: {$product->name}. Mã sản phẩm: {$product->id}.",
                "Dù không có sản phẩm chính xác, tôi có một sản phẩm thay thế có thể giúp bạn: {$product->name} (Mã sản phẩm: {$product->id}).",
                "Không có sản phẩm chính xác, nhưng tôi sẽ gợi ý sản phẩm: {$product->name} với mã sản phẩm: {$product->id}.",
            ];
    
            // Chọn một câu trả lời ngẫu nhiên từ danh sách
            $randomMessage = $messages[array_rand($messages)];
            $randomMessage .= "\nHương vị: {$selectedProduct->flavor}.";
            $randomMessage .= "\nLợi ích: {$selectedProduct->benefits}.";
            $randomMessage .= "\nĐể mua sản phẩm, vui lòng tìm kiếm tên sản phẩm '{$product->name}' hoặc ID sản phẩm '{$product->id}'.";
            $randomMessage .= "\n\nBạn có hài lòng với sản phẩm này không? Vui lòng trả lời 'Có' hoặc 'Không'.";
    
            return response()->json([
                'status' => 'partial',
                'message' => $randomMessage,
                'ask_feedback' => true,
                'product_id' => $product->id
            ]);
        }
    
        return response()->json([
            'status' => 'error',
            'message' => "Xin lỗi, tôi không tìm thấy sản phẩm phù hợp với khoa '$department' và bệnh '$disease'."
        ]);
    }
    public function getFoodSuggestions()
    {
        // Lấy danh sách sản phẩm
        $products = Product::all();
        $suggestions = [];
    
        foreach ($products as $product) {
            // Truy vấn các gợi ý thực phẩm liên quan đến sản phẩm
            $foodSuggestions = FoodSuggestion::where('product_id', $product->id)->get();
    
            if ($foodSuggestions->isEmpty()) {
                // Nếu không có gợi ý, thêm thông tin sản phẩm với các ô trống cho gợi ý
                $suggestions[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'department_suggestion' => '',
                    'disease_suggestion' => '',
                    'flavor' => '',
                    'benefits' => '',
                    'meal_time' => '',
                ];
            } else {
                // Nếu có gợi ý, thêm thông tin gợi ý vào mảng
                foreach ($foodSuggestions as $foodSuggestion) {
                    $suggestions[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'department_suggestion' => $foodSuggestion->department_suggestion,
                        'disease_suggestion' => $foodSuggestion->disease_suggestion,
                        'flavor' => $foodSuggestion->flavor,
                        'benefits' => $foodSuggestion->benefits,
                        'meal_time' => $foodSuggestion->meal_time,
                    ];
                }
            }
        }
    
        return response()->json(['products' => $suggestions]);
    }
    public function saveProductSuggestion(Request $request)
    {
        
    
        // Validate input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id', // Kiểm tra sản phẩm có tồn tại không
            'department_suggestion' => 'nullable|string',
            'disease_suggestion' => 'nullable|string',
            'flavor' => 'nullable|string',
            'benefits' => 'nullable|string',
            'meal_time' => 'nullable|string',
        ]);
    
        // Nếu có lỗi validation
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
    
        // Kiểm tra sản phẩm đã có gợi ý chưa
        $foodSuggestion = FoodSuggestion::where('product_id', $request->input('product_id'))->first();
    
        if ($foodSuggestion) {
            // Cập nhật lại gợi ý nếu đã có
            $foodSuggestion->update([
                'department_suggestion' => $request->input('department_suggestion', $foodSuggestion->department_suggestion),
                'disease_suggestion' => $request->input('disease_suggestion', $foodSuggestion->disease_suggestion),
                'flavor' => $request->input('flavor', $foodSuggestion->flavor),
                'benefits' => $request->input('benefits', $foodSuggestion->benefits),
                'meal_time' => $request->input('meal_time', $foodSuggestion->meal_time),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Gợi ý sản phẩm đã được cập nhật thành công!'
            ]);
        } else {
            // Tạo mới gợi ý nếu chưa có
            FoodSuggestion::create([
                'product_id' => $request->input('product_id'),
                'department_suggestion' => $request->input('department_suggestion'),
                'disease_suggestion' => $request->input('disease_suggestion'),
                'flavor' => $request->input('flavor'),
                'benefits' => $request->input('benefits'),
                'meal_time' => $request->input('meal_time'),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Gợi ý sản phẩm đã được lưu thành công!'
            ]);
        }
    }
    
    // Hàm để xác định thời gian bữa ăn
}

