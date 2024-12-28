<?php
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailChatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\importController;
use App\Http\Controllers\SpinHistoryController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FoodSuggestionController;
use App\Http\Controllers\TheDaNangController;
use App\Http\Controllers\AdminDashBoardController;
use App\Http\Controllers\FinancialStatsController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\RestoreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BanAnController;
use App\Http\Controllers\Auth\QrCodeLoginController;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\MaintenanceController;


use App\Http\Middleware\CheckAdmin;
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/orders/details/{id}', [OrderController::class, 'getOrderDetails'])->name('order.details');
Route::get('/products/{productId}/ingredients', [IngredientController::class, 'getIngredientsOfProduct']);
Route::post('/ingredients/update/{id}', [IngredientController::class, 'update']);
// routes/web.php


// Route xóa nguyên liệu khỏi sản phẩm
Route::delete('/products/{productId}/remove-Productingredient/{ingredientId}', [IngredientController::class, 'removeProductIngredient']);

Route::get('/list-ingredients', [IngredientController::class, 'getAllIngredients']);
Route::post('/ingredients/{id}/activate', [IngredientController::class, 'activate']);
Route::post('/ingredients/{id}/deactivate', [IngredientController::class, 'deactivate']);
Route::post('/add-ingredients', [IngredientController::class, 'store']);
// Route để lấy danh sách sản phẩm kèm theo nguyên liệu
Route::post('/products/{productId}/add-productingredients', [IngredientController::class, 'addIngredientsToProduct']);
Route::get('/ingredient-products', [IngredientController::class, 'index'])->name('products.index');
Route::post('/products/{productId}/ingredients/{ingredientId}/update', [IngredientController::class, 'updateIngredient']);
// routes/web.php
Route::get('/maintenance/{secret}', [MaintenanceController::class, 'startMaintenance']);

// Route để thêm nguyên liệu vào sản phẩm
Route::post('/products/{productId}/add-ingredients', [ProductController::class, 'addIngredients'])->name('products.addIngredients');

// Route để xóa nguyên liệu khỏi sản phẩm
Route::delete('/products/{productId}/remove-ingredient', [ProductController::class, 'removeIngredient'])->name('products.removeIngredient');
// web.php
Route::post('/start-maintenance', [MaintenanceController::class, 'startMaintenance']);


use App\Http\Controllers\Admin\AuthController;

Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login']);
Route::get('admin/2fa/setup', [AuthController::class, 'show2faSetup'])->name('2fa.setup');
Route::post('admin/2fa/setup', [AuthController::class, 'setup2fa']);
Route::get('admin/2fa/enter', [AuthController::class, 'show2faEnter'])->name('2fa.enter');
Route::post('admin/2fa/enter', [AuthController::class, 'verify2fa']);
Route::post('/update-password', [UserController::class, 'updatePassword'])->name('user.update.password');
Route::get('/filter-orders', [OrderController::class, 'filterOrders'])->name('filter.orders');
Route::match(['get', 'post'], '/csv/upload', [importController::class, 'index'])->name('csv.upload');
Route::get('/export-transactions', [ExportController::class, 'exportTransactionsToCsv'])->name('export.transactions');
Route::post('/qr-code-login', [QrCodeLoginController::class, 'login']);
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
Route::post('/mailbox/{mailboxId}/message', [MailChatController::class, 'storeMessage'])->name('store.message');
// Routes cho trang chính
Route::post('/mailbox/{mailboxId}/messages/read', [MailChatController::class, 'markMessagesAsRead'])->name('mark.messages.read');
Route::get('/mailbox/{mailboxId}/messages', [MailChatController::class, 'getMessages']);

Route::get('/expense-data', [OrderController::class, 'getExpenseData'])->name('expense-data');
Route::get('/export-users', [ExportController::class, 'exportUsers']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/about', [UserController::class, 'about']);
Route::get('/log-users', [UserController::class, 'getUserLog']);
Route::get('/payment', function () {
    return view('payment');
});
Route::post('/maintenance/start', function () {
    Artisan::call('down'); // Kích hoạt chế độ bảo trì
    return response()->json(['message' => 'Hệ thống đã chuyển sang chế độ bảo trì.']);
})->name('maintenance.start');
Route::middleware([
    'auth',
    CheckPermission::class . ':manage_products'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/ingredient', function () {
        return view('layouts.admin_ingredients');
    })->name('admin.ingredients');
});
Route::get('/banners', [SlideController::class, 'index']);

// Lấy thông tin banner để chỉnh sửa
Route::get('/banners/{id}', [SlideController::class, 'show']);
Route::get('/api/ingredients', [IngredientController::class, 'getIngredients'])->name('api.ingredients');
// Cập nhật thông tin banner
Route::post('/banner/update', [SlideController::class, 'update']);
Route::post('/banner/update-status', [SlideController::class, 'updateBannerStatus']);
Route::get('/check-header/{bannerId}', [SlideController::class, 'checkHeader']);
// Cập nhật trạng thái (Bật/Tắt) banner
Route::post('/banner/toggle-status', [SlideController::class, 'toggleStatus']);
Route::post('/banner/store', [SlideController::class, 'store']);

// Tạo mới một banner
Route::post('/banner/store', [SlideController::class, 'store']);

Route::middleware([
    'auth',
    CheckPermission::class . ':manage_system'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/restore', function () {
        return view('layouts.admin_restore');
    })->name('admin.restore');
});
Route::post('/financial-report', [FinancialStatsController::class, 'generateReport']);
Route::get('/finance/static', [FinancialStatsController::class, 'index']);
Route::get('/cards/user/{userId}', [TheDaNangController::class, 'getCardDetails']);
Route::post('/cards/{id}/transaction', [TheDaNangController::class, 'transaction']);
Route::get('/transactions/{cardId}', [TheDaNangController::class, 'getTransactions']);
Route::get('/the-da-nang-list', [TheDaNangController::class, 'getTheDaNangList']);
Route::middleware([
    'auth',
    CheckPermission::class . ':manage_products'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/category', function () {
        return view('layouts.admin_category');
    })->name('admin.category');
});
Route::post('/radio-notification/save', [SpeechController::class, 'saveNotification']);

Route::middleware([
    'auth',
    CheckPermission::class . ':manage_finance'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/finance', function () {
        return view('layouts.admin_finance');
    })->name('admin.finance');
});

Route::get('/deleted-products', [RestoreController::class, 'getDeletedProducts']);
Route::get('/deleted-orders', [RestoreController::class, 'getDeletedOrders']);
Route::post('/cards/{id}/update-pin', [TheDaNangController::class, 'updatePin']);
Route::get('admin/categories/statistics', [CategoryController::class, 'getCategoryStatistics']);
Route::post('/admin/categories/add', [CategoryController::class, 'Add'])->name('admin.categories.add');
Route::get('admin/categories/{id}', [CategoryController::class, 'showCategory']);
Route::post('admin/categories/{id}', [CategoryController::class, 'updateCategory']);
Route::get('/admin/categories/{id}/products', [CategoryController::class, 'viewCategoryProducts']);
Route::get('/admin/categories', [CategoryController::class, 'getCategory']);
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);
Route::post('/check-department', [FoodSuggestionController::class, 'checkDepartment']);
Route::middleware([
    'auth',
    CheckPermission::class . ':manage_users'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/user', function () {
        return view('layouts.admin-user');
    })->name('admin.user');
});
Route::get('/fetch-transactions-summary', [TheDaNangController::class, 'fetchTransactionsSummary'])->name('fetch.transactions.summary');
Route::get('/fetch-transactions', [TheDaNangController::class, 'fetchTransactions'])->name('fetch.transactions');
Route::get('/link_payment', [PaymentController::class, 'showPaymentOptions'])->name('link.payment');
Route::post('/process_payment', [PaymentController::class, 'processPayment'])->name('process.payment');
Route::get('/chat/unread-messages', [MailChatController::class, 'getUnreadMessages']);
Route::post('/chat/mark-as-read', [MailChatController::class, 'markMessagesAsRead']);
Route::get('/payment_info', function () {
    return view('payment_info');
});
Route::get('/notifications/unread', [NotificationController::class, 'getUnreadCount']);
Route::get('/check-login-status', function () {
    return response()->json(['loggedIn' => auth::check()]);
});
Route::post('/products/{id}/restore', [RestoreController::class, 'restoreProduct']);
Route::post('/orders/{id}/restore', [RestoreController::class, 'restoreOrder']);
Route::get('/radio-notifications', [SpeechController::class, 'index']);
Route::get('/radio-notifications/{id}', [SpeechController::class, 'show']);
Route::post('/radio-notifications/{id}', [SpeechController::class, 'update']);
Route::delete('/radio-notifications/{id}', [SpeechController::class, 'destroy']);
Route::get('/api/random-announcement', [SpeechController::class, 'getRandomAnnouncement']);
Route::get('/staff-logs/{user_id}', [AdminController::class, 'getStaffLogs']);
Route::get('/log-admins', [AdminController::class, 'getLogs']);
Route::post('/check-disease', [FoodSuggestionController::class, 'checkDisease']);
Route::post('/users/{id}/update', [UserController::class, 'update']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::post('/chat/send-message', [MailChatController::class, 'sendAdminMessage']);
Route::post('/update_card', [TheDaNangController::class, 'updateCard']);
Route::post('/transaction/confirm', [PaymentController::class, 'confirmTransaction']);
Route::post('/transaction/check-pin', [PaymentController::class, 'checkPinCode']);
Route::post('/check-card', [TheDaNangController::class, 'checkCard'])->name('check.card');
Route::post('/check-pin', [TheDaNangController::class, 'checkPin'])->name('check.pin');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
     ->name('notifications.read');
     Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
     Route::delete('/notifications/delete/{id}', [NotificationController::class, 'deleteNotification']);
     Route::delete('/notifications/delete-read', [NotificationController::class, 'deleteAllReadNotifications']);
// routes/web.php
Route::get('/admin-info', [UserController::class, 'getAdminInfo']);
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/check-login', function() {
    return response()->json(['isLoggedIn' => Auth::check()]);
})->name('check.login');
Route::get('/test-mail', [HomeController::class, 'testEmail']);
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/contact', [BanAnController::class, 'index']);
Route::post('/dat-ban', [BanAnController::class, 'store'])->name('dat-ban');
Route::get('/fetch-tables', [BanAnController::class, 'fetchTables'])->name('fetch-tables');
Route::post('/cancel-reservation/{id}', [BanAnController::class, 'cancelReservation'])->name('cancel-reservation');
Route::get('/available-times/{tableId}', [BanAnController::class, 'getAvailableTimes']);
Route::post('/discount/send', [DiscountController::class, 'sendDiscount']);
Route::prefix('admin')->middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/dashboard', [AdminDashBoardController::class, 'index'])->name('admin.dashboard');
});
Route::get('/post', [PostController::class, 'index'])->name('post');
Route::get('/post_detail/{id}', [PostController::class, 'show'])->name('post_detail');
Route::get('/comments/{comment_id}/replies', [CommentController::class, 'getReplies'])->name('comment.replies'); // Sử dụng CommentController để lấy reply
Route::post('/comments/{comment}/replies', [CommentController::class, 'submitReply']);
Route::get('/products/{product}/comments', [CommentController::class, 'getComments'])->name('product.comments');
Route::post('/update-points', [UserController::class, 'updatePoints'])->name('updatePoints');
Route::post('/admin/change-password', [UserController::class, 'changePassword']);
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/discount/users', [DiscountController::class, 'getUsers']);
// routes/web.php
Route::post('/admin/api/reports/{commentId}/complete', [ReportController::class, 'completeReport']);
Route::get('/admin/api/products/reports', [ReportController::class, 'showProductReports']);
Route::post('/admin/comments/{commentId}/reply', [ReportController::class, 'replyComment']);
Route::get('/admin/api/order-reports', [ReportController::class, 'getOrderReports']);
Route::post('/admin/api/process-report', [ReportController::class, 'processReport']);
Route::post('/admin/api/complete-report', [ReportController::class, 'completeReportOrder']);
Route::get('/admin/api/products/{product}/comments', [ReportController::class, 'getProductComments']);
Route::delete('/admin/comments/{commentId}', [ReportController::class, 'deleteComment'])->name('comments.delete');
// routes/web.php hoặc routes/api.php (tùy vào cấu trúc)
Route::post('/addDiscounts', [DiscountController::class, 'store']);
Route::get('/discount-statistics/{days?}', [DiscountController::class, 'getDiscountStatistics']);
Route::get('/discount-report/{days?}', [DiscountController::class, 'exportDiscountReport']);
Route::get('/api/getdiscounts/{id}', [DiscountController::class, 'getDiscountDetail']);
Route::put('/updateDiscount/{id}', [DiscountController::class, 'updateDiscount']);
Route::post('/api/check-pin', [TheDaNangController::class, 'checkPinDraw']);
Route::post('/top-up', [TheDaNangController::class, 'topUp']);
Route::post('/withdraw', [TheDaNangController::class, 'withdraw']);
Route::post('orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
Route::post('/order/{id}/complete', [OrderController::class, 'completeOrder'])->name('order.complete');
Route::delete('/remove-payment-method/{method}', [TheDaNangController::class, 'removePaymentMethod']);
// Routes cho đăng nhập và đăng xuất// Route để lấy thông tin dinh dưỡng
Route::get('/nutrition-facts/{productId}', [ProductController::class, 'getNutritionFact']);

// Route để lưu thông tin dinh dưỡng
Route::post('/nutrition-facts/save', [ProductController::class, 'saveNutritionFact']);
Route::get('/admin/api/users', [ReportController::class, 'getUsers']);
Route::post('/admin/api/toggle-block-user', [ReportController::class, 'toggleBlockUser']);
Route::get('/scan-qr', [TheDaNangController::class, 'showScanner'])->name('qr.scanner');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/my-cards', [TheDaNangController::class, 'index'])->name('my.cards');
Route::post('/open-card', [TheDaNangController::class, 'openCard'])->name('open.card');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
// Routes cho profile và cập nhật thông tin
Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
Route::post('/update-avatar', [UserController::class, 'updateAvatar'])->name('update.avatar');
Route::get('/update_profile', [UserController::class, 'showUpdateProfile'])->name('update.profile');
Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update.profile.submit');
Route::get('/update_address', [UserController::class, 'showUpdateForm'])->name('update.address.form');
Route::post('/update_address', [UserController::class, 'updateAddress'])->name('update.address');
Route::get('/search-products', [ProductController::class, 'search'])->name('search.products');
Route::get('/search', [ProductController::class, 'viewSearch'])->name('search');
// web.php
Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');
Route::post('/admins/check-duplicate-id', [AdminController::class, 'checkDuplicateId']);
Route::post('/admins/update-staff', [AdminController::class, 'updateStaff']);
Route::get('/generate-qrcode', [TheDaNangController::class, 'generateQRCode'])->name('generate.qrcode');

Route::post('/spin-history', [SpinHistoryController::class, 'store'])->name('spin.history.store');
Route::post('/admins/revoke-admin', [AdminController::class, 'revokeAdmin'])->name('admins.revoke-admin');
Route::post('/update-prize', [SpinController::class, 'updatePrize'])->name('spin.updatePrize');
Route::post('/check-products', [ProductController::class, 'checkProducts']);
// Routes cho đăng ký người dùng
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/quick_view/{id}', [ProductController::class, 'quickView'])->name('quick_view');
Route::post('/import-products', [ProductController::class, 'importProducts'])->name('import.products');
// Route tìm kiếm
Route::post('/orders/{order}/delete', [OrderController::class, 'softDelete'])->name('orders.softDelete');
use App\Http\Controllers\RestockSuggestionController;
Route::post('/get-history', [ProductController::class, 'getHistory']);
Route::post('/validate-masp-category', [ProductController::class, 'validateMaspCategory']);
Route::get('/api/restock-suggestions', [ProductController::class, 'getRestockSuggestions'])->name('restock.suggestions');

// web.php
Route::post('/comments/like', [ProductController::class, 'like'])->name('comments.like');
Route::post('/comments/dislike', [ProductController::class, 'dislike'])->name('comments.dislike');
Route::get('/api/initial-stats', [OrderController::class, 'getInitialStats']);

// Lọc thống kê theo bộ lọc (ngày, trạng thái)
Route::get('/api/stats', [OrderController::class, 'filterStats']);
Route::get('/cart-info', [CartController::class, 'getCartInfo'])->name('cart.info');

Route::get('/quick_view', function () {
    return view('quick_view');
});
Route::get('/mic', function () {
    return view('layouts.mic');
});

Route::middleware([
    'auth',
    CheckPermission::class . ':manage_reservations'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/datban', function () {
        return view('layouts.admin_dat_ban');
    })->name('admin.datban');
});
Route::post('/api/add-table', [BanAnController::class, 'addTable']);
Route::get('/api/tables/{id}/schedule', [BanAnController::class, 'getSchedule']);
Route::get('/api/tables/booked', [BanAnController::class, 'getBookedTables']);
Route::get('/api/tables-with-pending-bookings', [BanAnController::class, 'getTablesWithPendingBookings']);
Route::get('/api/dat-ban-details/{userId}', [BanAnController::class, 'getDatBanDetails']);
Route::get('/schedules/excel', [BanAnController::class, 'getSchedulesForExcel']);
// routes/web.php hoặc routes/api.php (tùy vào nơi bạn muốn sử dụng)
Route::get('/api/report-order/{orderId}', [OrderController::class, 'getReportOrder']);

Route::post('/schedules/{scheduleId}/approve', [BanAnController::class, 'approveSchedule']);
Route::post('/schedules/{scheduleId}/reject', [BanAnController::class, 'rejectSchedule']);
Route::get('/api/tra-cuu-the', [TheDaNangController::class, 'traCuuThe']);
Route::get('/api/order', [OrderController::class, 'traCuuDonHang']);
Route::get('/api/tables', [BanAnController::class, 'getAllTables']);
Route::get('/api/orders', [OrderController::class, 'fetchOrders'])->name('api.orders');
Route::post('/api/orders/change-status', [OrderController::class, 'changeStatus'])->name('api.orders.change-status');
Route::post('/api/orders/cancel', [OrderController::class, 'cancelOrderAdmin'])->name('api.orders.cancel');
Route::delete('/api/orders/{id}', [OrderController::class, 'deleteOrder'])->name('api.orders.delete');
Route::get('/orders/{id}/details', [OrderController::class, 'fetchOrderDetails']);
Route::post('/orders/history', [OrderController::class, 'fetchOrderHistory']);;
Route::get('orders/report', [OrderController::class, 'generateOrderReport']);

Route::post('/api/tables/{id}/update-name', [BanAnController::class, 'updateName']); // Đổi tên bàn
Route::post('/api/tables/{id}/update-status', [BanAnController::class, 'updateStatus']); // Đổi trạng thái bàn

Route::post('/stop-maintenance', [MaintenanceController::class, 'stopMaintenance'])->name('maintenance.stop');
Route::middleware([
    'auth',
    CheckPermission::class . ':manage_orders'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/order', function () {
        return view('layouts.admin_order');
    })->name('admin.order');
});
Route::post('/apply-filters', [MenuController::class, 'applyFilters'])->name('apply.filters');

Route::get('/get-notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead1'])->name('notifications.markAsRead');
Route::get('/check-maintenance-status', [MaintenanceController::class, 'checkMaintenanceStatus']);
Route::get('/get-statistics', [ProductController::class, 'getStatistics']);
Route::get('/api/charts-data', [ProductController::class, 'getChartsData']);
Route::post('/store-multiple', [ProductController::class, 'storeMultiple'])->name('products.storeMultiple');
Route::get('/product/{id}/statistics', [ProductController::class, 'showStatistics'])->name('product.statistics');
Route::get('/products', [ProductController::class, 'fetchProducts']);
Route::get('/api/products/filter', [ProductController::class, 'filterAndSort']);
Route::get('/api/products/search', [ProductController::class, 'searchProduct']);
Route::get('/export-excel', [ExportController::class, 'exportProduct'])->name('export.excel');
Route::middleware([
    'auth',
    CheckPermission::class . ':manage_products'
])->group(function () {
    Route::get('/admin_product', [ProductController::class, 'index'])->name('admin.product');
});

Route::get('/admin/staff', function () {
    return view('layouts.admin_staff');
});
Route::middleware([
    'auth',
    CheckPermission::class . ':manage_staff'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/staff', function () {
        return view('layouts.admin_staff');
    })->name('admin.staff');
});
Route::post('/report/order', [ReportController::class, 'reportOrder'])->name('report.order');

Route::post('/report/comment', [ReportController::class, 'reportComment'])->name('report.comment');

Route::prefix('admin')->middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/report',function (){return view('layouts.admin_report');});
});

Route::middleware([
    'auth',
    CheckPermission::class . ':manage_promotions'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/discount', function () {
        return view('layouts.admin_discount');
    })->name('admin.discount');
});
Route::put('/comments/{commentId}', [PostController::class, 'editComment'])->name('comments.edit');

Route::middleware([
    'auth',
    CheckPermission::class . ':manage_posts'  // Chú ý dấu chấm để nối chuỗi
])->group(function () {
    Route::get('/admin/post', function () {
        return view('layouts.admin_post');
    })->name('admin.post');
});
Route::post('/postStatistics', [PostController::class, 'getPostStatistics'])->name('statistics.get');
Route::post('/posts/delete/{postId}', [PostController::class, 'deletePost'])->name('posts.delete');
Route::post('/editPost/{postId}', [PostController::class, 'updatePost'])->name('post.update');
Route::post('/addPost', [PostController::class, 'addPost'])->name('addPost');
Route::delete('/posts/{postId}/comments/{commentId}', [PostController::class, 'destroyComment'])
    ->name('comments.destroy');
Route::get('/posts', [PostController::class, 'getPosts']); // Lấy danh sách bài viết
Route::get('/posts/{id}', [PostController::class, 'getPostDetail']); // Lấy chi tiết bài viết và bình luận
Route::get('/posts/{id}/comments', [PostController::class, 'getComments']); // Lấy bình luận
Route::post('/posts/{id}/comments', [PostController::class, 'addComment']); // Thêm bình luận
Route::get('/table-history', [BanAnController::class, 'getTableHistory']);
Route::get('/api/table-static', [BanAnController::class, 'getTableStatic']);
Route::get('/api/discounts', [DiscountController::class, 'getDiscounts']);
Route::post('/api/save-product-suggestion', [FoodSuggestionController::class, 'saveProductSuggestion']);
Route::post('/chat/ai-response', [MailChatController::class, 'getAIResponse']);
Route::get('/api/admins', [AdminController::class, 'getAdmins']);
Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
Route::get('/admin/products/filter', [ProductController::class, 'filter'])->name('admin.product.filter');
Route::post('/get-alternative-products', [FoodSuggestionController::class, 'getAlternativeProducts']);
Route::get('/api/food-suggestions', [FoodSuggestionController::class, 'getFoodSuggestions']);

Route::get('/quick_view/{id}', [ProductController::class, 'quickView'])->name('quick.view');
Route::post('/product/{product}/comment', [ProductController::class, 'addOrUpdateComment'])->name('product.comment');
Route::post('/change-pin', [TheDaNangController::class, 'changePin'])->name('change.pin');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/delete', [CartController::class, 'delete'])->name('cart.delete');
Route::post('/cart/remove-item', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/searchmenu', [ProductController::class, 'searchmenu'])->name('products.searchmenu');
// Đảm bảo rằng route này tồn tại và có phương thức POST
Route::post('/updateproduct/{id}', [ProductController::class, 'update']);
Route::get('/chat-users', [MailChatController::class, 'getChatUsers']);
Route::get('/getMessages/{userId}', [MailChatController::class, 'getMessagesChat']);
Route::get('/checkUnreadMessages', [MailChatController::class, 'checkUnreadMessages']);

// Trong routes/web.php hoặc routes/api.php
Route::post('/markAsRead/{userId}', [MailChatController::class, 'markAsRead']);
Route::get('/api/users', [UserController::class, 'getUsers']);
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
Route::get('/chat/messages', [MailChatController::class, 'loadMessages'])->name('chat.messages');
Route::post('/sendMessage', [MailChatController::class, 'sendMessage']);
Route::get('admins/check-existence', [AdminController::class, 'checkAdminExistence']);
Route::post('users/update-admin-status', [AdminController::class, 'updateAdminStatus']);
Route::post('admins/add', [AdminController::class, 'addAdmin']);
Route::post('admins/update-permissions', [AdminController::class, 'updatePermissions']);
Route::post('/admins/update-permission', [AdminController::class, 'updatePermission']);
Route::get('/users/admin-data/{id}', [AdminController::class, 'getAdminData']);

Route::get('/product/{id}/history', [ProductController::class, 'getProductHistory']);
Route::post('/get-user-statistics', [UserController::class, 'getUserStatistics'])->name('api.user.statistics');
Route::post('/admin/products/{id}/delete', [ProductController::class, 'delete'])->name('products.delete');
Route::post('/check-if-data-exists', [UserController::class, 'checkIfDataExists']);
Route::get('/fetch-users', [UserController::class, 'fetchUsers']);
Route::post('/add-users', [UserController::class, 'addUsers']);
Route::get('/users/non-admin', [AdminController::class, 'getNonAdminUsers']);
Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
Route::get('/search-users', [UserController::class, 'searchUsers']);
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/admin/product-stats', [ProductController::class, 'filterStats'])->name('product.stats.filter');
Route::post('/check-qr-code', [TheDaNangController::class, 'checkQrCode']);
Route::post('/cart/delete-all', [CartController::class, 'deleteAll'])->name('cart.deleteAll');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
// Routes cho trang quản trị
Route::prefix('dashboard')->middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard111');
    
    // Routes cho quản lý sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
   
    // Routes cho quản lý danh mục
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    // Routes cho quản lý người dùng
    Route::get('users', [AdminUserController::class, 'index'])->name('admin.user.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('admin.user.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('admin.user.store');
    Route::get('users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::put('users/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('users/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');

    // Routes cho quản lý đơn hàng
    Route::get('admin-orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin-orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('admin-orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('admin-orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('admin-orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::post('orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.order.updateStatus');

    // Routes cho thống kê
    Route::get('statistics', [AdminStatisticsController::class, 'index'])->name('admin.statistics.index');
});