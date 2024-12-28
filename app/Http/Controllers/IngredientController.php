<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
class IngredientController extends Controller
{
    public function getIngredients(Request $request)
    {
        $query = Ingredient::query();

        // Tìm kiếm theo tên hoặc mã
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }

        // Lọc theo danh mục
      

        // Lọc và sắp xếp
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'active':
                    $query->where('status', 'active');
                    break;
                case 'inactive':
                    $query->where('status', 'inactive');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Giới hạn số lượng hiển thị
        $limit = $request->get('limit', 10);
        $ingredients = $query->paginate($limit);

        // Trả về dữ liệu JSON
        return response()->json($ingredients);
    }
    public function update(Request $request, $id)
    {
        try {
            // Tìm gia vị theo ID
            $ingredient = Ingredient::findOrFail($id);

            // Cập nhật thông tin từ request
            $ingredient->name = $request->input('name', $ingredient->name);
            $ingredient->unit = $request->input('unit', $ingredient->unit);
            $ingredient->save();

            // Trả về phản hồi thành công
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật gia vị thành công.',
                'data' => $ingredient,
            ], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi và trả về phản hồi thất bại
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật gia vị thất bại. ' . $e->getMessage(),
            ], 500);
        }
    }
    public function activate($id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return response()->json(['success' => false, 'message' => 'Nguyên liệu không tồn tại!'], 404);
        }

        $ingredient->status = 'active'; // Chuyển trạng thái sang "Sẵn sàng"
        $ingredient->save();

        return response()->json(['success' => true, 'message' => 'Nguyên liệu đã được kích hoạt sẵn sàng.']);
    }

    /**
     * Kích hoạt trạng thái "Không sẵn sàng" của nguyên liệu.
     */
    public function deactivate($id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return response()->json(['success' => false, 'message' => 'Nguyên liệu không tồn tại!'], 404);
        }

        $ingredient->status = 'inactive'; // Chuyển trạng thái sang "Không sẵn sàng"
        $ingredient->save();

        return response()->json(['success' => true, 'message' => 'Nguyên liệu đã được chuyển thành không sẵn sàng.']);
    }
    public function store(Request $request)
    {
        // Xác nhận dữ liệu nhận được từ client
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
    
        // Kiểm tra xem gia vị có trùng tên với gia vị đã có trong cơ sở dữ liệu hay không
        $existingIngredient = Ingredient::where('name', $validated['name'])->first();
    
        if ($existingIngredient) {
            // Nếu gia vị đã tồn tại, trả về thông báo lỗi
            return response()->json([
                'success' => false,
                'message' => 'Gia vị này đã tồn tại trong hệ thống!',
            ], 400);
        }
    
        try {
            // Tạo nguyên liệu mới
            $ingredient = Ingredient::create([
                'name' => $validated['name'],
                'unit' => $validated['unit'],
                'status' => $validated['status'],
            ]);
    
            // Trả về kết quả thành công
            return response()->json([
                'success' => true,
                'message' => 'Nguyên liệu đã được thêm thành công!',
                'ingredient' => $ingredient,
            ]);
        } catch (\Exception $e) {
            // Trả về lỗi nếu gặp sự cố
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi thêm nguyên liệu. Vui lòng thử lại.',
            ], 500);
        }
    }
    public function index()
{
    $products = Product::with('ingredients')->get();
    return response()->json($products);
}

public function addIngredients(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $ingredients = $request->input('ingredients');

    foreach ($ingredients as $ingredientData) {
        $product->ingredients()->attach($ingredientData['ingredientId'], ['quantity' => $ingredientData['quantity']]);
    }

    return response()->json(['success' => true]);
}

public function removeIngredient($productId)
{
    $product = Product::findOrFail($productId);
    $product->ingredients()->detach(); // Xóa tất cả nguyên liệu của sản phẩm
    
    return response()->json(['success' => true]);
}
public function getIngredientsOfProduct($productId)
{
    try {
        // Lấy sản phẩm theo ID
        $product = Product::findOrFail($productId);

        // Lấy danh sách nguyên liệu của sản phẩm, bao gồm tên và đơn vị
        $ingredients = $product->ingredients()->get();

        // Trả về dữ liệu nguyên liệu dưới dạng JSON
        return response()->json([
            'success' => true,
            'ingredients' => $ingredients
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm hoặc có lỗi xảy ra.',
        ], 404);
    }
}
public function getAllIngredients()
{
    try {
        // Lấy tất cả nguyên liệu
        $ingredients = Ingredient::all();

        return response()->json([
            'success' => true,
            'ingredients' => $ingredients
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi khi lấy danh sách nguyên liệu.',
        ], 500);
    }
}

public function addIngredientsToProduct(Request $request, $productId)
{
    try {
        // Lấy thông tin sản phẩm
        $product = Product::findOrFail($productId);

        // Lấy thông tin nguyên liệu từ request
        $ingredients = $request->input('ingredients');

        foreach ($ingredients as $ingredientData) {
            $ingredientId = $ingredientData['ingredientId'];
            $quantity = $ingredientData['quantity'];

            // Kiểm tra xem nguyên liệu có tồn tại trong CSDL không
            $ingredient = Ingredient::findOrFail($ingredientId);

            // Kiểm tra nếu nguyên liệu đã có cho sản phẩm này
            $existingIngredient = ProductIngredient::where('product_id', $productId)
                                                    ->where('ingredient_id', $ingredientId)
                                                    ->first();

                                                    if ($existingIngredient) {
                                                        // Nếu nguyên liệu đã có, chỉ cập nhật số lượng mới
                                                        $existingIngredient->update([
                                                            'quantity' => $quantity, // Cập nhật số lượng mới
                                                            'updated_at' => now() // Cập nhật thời gian sửa đổi
                                                        ]);
            } else {
                // Nếu nguyên liệu chưa có, thêm mới
                ProductIngredient::create([
                    'product_id' => $productId,
                    'ingredient_id' => $ingredientId,
                    'quantity' => $quantity,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm nguyên liệu thành công!',
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Xử lý khi không tìm thấy sản phẩm hoặc nguyên liệu
        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm hoặc nguyên liệu không tồn tại.',
            'error' => $e->getMessage(),
        ], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Xử lý khi có lỗi xác thực dữ liệu
        return response()->json([
            'success' => false,
            'message' => 'Dữ liệu nhập vào không hợp lệ.',
            'error' => $e->getMessage(),
        ], 422);
    } catch (\Exception $e) {
        // Xử lý các lỗi khác
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi thêm nguyên liệu. Vui lòng thử lại!',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function updateIngredient(Request $request, $productId, $ingredientId)
{
    try {
        // Lấy thông tin sản phẩm
        $product = Product::findOrFail($productId);

        // Kiểm tra nếu nguyên liệu có tồn tại
        $ingredient = Ingredient::findOrFail($ingredientId);

        // Kiểm tra nếu nguyên liệu đã có cho sản phẩm này
        $existingIngredient = ProductIngredient::where('product_id', $productId)
                                                ->where('ingredient_id', $ingredientId)
                                                ->first();

        if ($existingIngredient) {
            // Cập nhật số lượng nguyên liệu
            $quantity = $request->input('quantity');

            if (!$quantity || $quantity <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng phải lớn hơn 0.',
                ], 400);
            }

            // Cập nhật số lượng nguyên liệu
            $existingIngredient->update([
                'quantity' => $quantity,
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật nguyên liệu thành công!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nguyên liệu không tồn tại cho sản phẩm này.',
            ], 404);
        }

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Xử lý khi không tìm thấy sản phẩm hoặc nguyên liệu
        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm hoặc nguyên liệu không tồn tại.',
            'error' => $e->getMessage(),
        ], 404);
    } catch (\Exception $e) {
        // Xử lý các lỗi khác
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật nguyên liệu.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function removeProductIngredient($productId, $ingredientId)
    {
        try {
            // Tìm kiếm bản ghi nguyên liệu của sản phẩm
            $productIngredient = ProductIngredient::where('product_id', $productId)
                                                  ->where('ingredient_id', $ingredientId)
                                                  ->first();

            if ($productIngredient) {
                // Xóa bản ghi nguyên liệu khỏi sản phẩm
                $productIngredient->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Xóa nguyên liệu thành công!'
                ]);
            } else {
                // Nếu không tìm thấy nguyên liệu cho sản phẩm
                return response()->json([
                    'success' => false,
                    'message' => 'Nguyên liệu không tồn tại trong sản phẩm!'
                ], 404);
            }
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa nguyên liệu.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
