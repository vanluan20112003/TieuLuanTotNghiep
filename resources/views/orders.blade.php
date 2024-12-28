<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>my orders</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="{{ asset('css/order.css') }}">
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  

<style>.header {
    background-color: #fff; /* Màu nền sáng */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
    padding: 10px 20px; /* Khoảng cách bên trong */
    background-color: #e0f7fa; /* Màu xanh nhạt dễ chịu */
}

.header .flex {
    display: flex;
    align-items: center; /* Canh giữa theo chiều dọc */
    justify-content: space-between; /* Tách đều giữa các phần tử */
}
/* Modern Orders Section Styling */
.orders {
    padding: 2rem;
    background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.orders .title {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 1rem;
    text-align: center;
}

.orders .title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, #3498db, #2ecc71);
    border-radius: 2px;
}

.box-container {
    background: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.order-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
    margin-top: 1rem;
}

.order-table thead tr {
    background: linear-gradient(to right, #3498db, #2ecc71);
    color: white;
}

.order-table th {
    padding: 1rem;
    font-weight: 600;
    text-align: left;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.order-table tbody tr {
    background: #f8f9fa;
    transition: transform 0.2s, box-shadow 0.2s;
}

.order-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.order-table td {
    padding: 1rem;
    border-top: 1px solid #eee;
    font-size: 0.95rem;
    color: #2c3e50;
}

/* Status-specific styling */
.order-table td:nth-child(9) {
    font-weight: 600;
}

/* Buttons styling */
.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.btn-danger {
    background: linear-gradient(to right, #e74c3c, #c0392b);
    color: white;
}

.btn-success {
    background: linear-gradient(to right, #2ecc71, #27ae60);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Pagination styling */
.pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border: none;
    background: #f8f9fa;
    color: #2c3e50;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: #3498db;
    color: white;
}

.pagination .active .page-link {
    background: linear-gradient(to right, #3498db, #2ecc71);
    color: white;
}

/* Alert styling */
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    background: linear-gradient(to right, rgba(46, 204, 113, 0.1), rgba(52, 152, 219, 0.1));
    border-left: 4px solid #2ecc71;
    color: #2c3e50;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .order-table {
        display: block;
        overflow-x: auto;
    }
    
    .orders {
        padding: 1rem;
    }
    
    .orders .title {
        font-size: 2rem;
    }
}

/* Empty state styling */
.box-container p {
    text-align: center;
    padding: 2rem;
    color: #7f8c8d;
    font-size: 1.1rem;
}

.box-container p a {
    color: #3498db;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.box-container p a:hover {
    color: #2980b9;
}
/* Modern Orders Section Styling */
.orders {
    padding: 2rem;
    background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.orders .title {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 1rem;
    text-align: center;
}

.orders .title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, #3498db, #2ecc71);
    border-radius: 2px;
}

.box-container {
    background: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.order-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
    margin-top: 1rem;
}

/* Cải thiện độ tương phản cho header của bảng */
.order-table thead tr {
    background: #2c3e50;  /* Màu nền tối hơn */
    color: #ffffff;
    font-weight: 700;  /* Tăng độ đậm của chữ */
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);  /* Thêm bóng cho chữ */
}

.order-table th {
    padding: 1.2rem 1rem;  /* Tăng padding dọc */
    font-weight: 600;
    text-align: left;
    text-transform: uppercase;
    font-size: 0.9rem;  /* Tăng kích thước chữ */
    letter-spacing: 0.5px;
    border-bottom: 2px solid #34495e;  /* Thêm viền dưới */
}

.order-table tbody tr {
    background: #f8f9fa;
    transition: transform 0.2s, box-shadow 0.2s;
}

.order-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.order-table td {
    padding: 1rem;
    border-top: 1px solid #eee;
    font-size: 0.95rem;
    color: #2c3e50;
}

/* Status-specific styling */
.order-table td:nth-child(9) {
    font-weight: 600;
}

/* Buttons styling */
.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.btn-danger {
    background: linear-gradient(to right, #e74c3c, #c0392b);
    color: white;
}

.btn-success {
    background: linear-gradient(to right, #2ecc71, #27ae60);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Pagination styling */
.pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border: none;
    background: #f8f9fa;
    color: #2c3e50;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: #3498db;
    color: white;
}

.pagination .active .page-link {
    background: #2c3e50;
    color: white;
}

/* Alert styling */
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    background: linear-gradient(to right, rgba(46, 204, 113, 0.1), rgba(52, 152, 219, 0.1));
    border-left: 4px solid #2ecc71;
    color: #2c3e50;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .order-table {
        display: block;
        overflow-x: auto;
    }
    
    .orders {
        padding: 1rem;
    }
    
    .orders .title {
        font-size: 2rem;
    }
}

/* Empty state styling */
.box-container p {
    text-align: center;
    padding: 2rem;
    color: #7f8c8d;
    font-size: 1.1rem;
}

.box-container p a {
    color: #3498db;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.box-container p a:hover {
    color: #2980b9;
}</style>
</head>
<body>
   
<header class="header">

<section class="flex">

<a href="{{ url('/') }}" class="logo">
 <img src="{{ asset('images/logocanteen.jpg') }}" alt="Logo" style="max-width: 30%; height: auto;">
</a>


   <nav class="navbar">
      <a href="{{ url('/') }}">Trang chủ</a>
      <a href="{{ url('/about') }}">Giới thiệu</a>
      <a href="{{ url('/menu') }}">Menu</a>
      <a href="{{ url('/orders') }}">Đơn hàng của bạn</a>
      <a href="{{ url('/contact') }}">Đặt bàn</a>
      <a href="{{ url('/post') }}">Các bài đăng</a>

   </nav>

   <div class="icons">
      <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
      <a href="{{ url('/cart') }}" id="cart-link">
     
      <i class="fas fa-shopping-cart"></i>
      <span>({{ $cartQuantity }})</span> 
     </a>
     <a href="{{ url('/notifications') }}" class="notification-link">
 <i class="fa-solid fa-bell"></i>
 <span class="dot" id="notificationDot"></span> <!-- Dấu chấm đỏ -->
</a>

      <div id="user-btn">
 @auth
     @if(auth()->user()->avatar)
         <img src="{{ asset(auth()->user()->avatar) }}" alt="User Avatar" class="user-avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
     @else
         <div class="fas fa-user" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #ddd;"></div>
     @endif
 @else
     <div class="fas fa-user" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #ddd;"></div>
 @endauth
</div>

</div>

      <div id="menu-btn" class="fas fa-bars"></div>
   </div>

   <div class="profile">
 <p class="name">
     @if(Auth::check())
         {{ Auth::user()->name }}
     @else
         Guest
     @endif
 </p>
 <div class="flex">
     @if(Auth::check())
         <a href="{{ url('/profile') }}" class="btn">Profile</a>
         <button class="delete-btn" onclick="confirmLogout()">Logout</button>
         
         <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
             @csrf
         </form>
     @else
         <a href="{{ url('/login') }}" class="btn">Login</a>
         <a href="{{ url('/register') }}" class="btn">Register</a>
     @endif
 </div>
</div>


</section>

</header>

<div class="heading">
   <h3>Hóa Đơn Của Bạn</h3>
   <p><a href="{{ url('/') }}">home </a> <span> / orders</span></p>
</div>

<section class="orders">
    <h1 class="title">Placed Orders</h1>
    <div class="box-container">
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    alert('{{ session("success") }}');
                });
            </script>
        @endif

        @auth
            @if ($orders->isEmpty())
                <p>No orders placed yet.</p>
            @else
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order Date</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Order Details</th>
                            <th>Total Price</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->user->phone_number }}</td>
                                <td>{{ $order->user->email }}</td>
                                <td>{{ $order->user->address ?: 'Please update your address' }}</td>
                                <td>
                                    @foreach ($orderDetails[$order->id] as $detail)
                                        {{ $detail->product->name }} ({{ $detail->quantity }})<br>
                                    @endforeach
                                </td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                <td>{{ $order->payment_method }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->notes }}</td>
                                <td>
                                    @if($order->status === 'completed' || $order->status === 'cancelled')
                                        <form action="{{ route('orders.softDelete', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif

                                    @if($order->status === 'pending')
                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    @elseif($order->status === 'processing')
                                        <form action="{{ route('order.complete', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Mark as Completed</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <p>Please <a href="{{ route('login') }}">log in</a> to view your orders.</p>
        @endauth
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</section>

























<footer class="footer">

   <section class="box-container">

      <div class="box">
         <img src="images/email-icon.png" alt="">
         <h3>our email</h3>
         <a href="mailto:shaikhanas@gmail.com">shaikhanas@gmail.com</a>
         <a href="mailto:anasbhai@gmail.com">anasbhai@gmail.com</a>
      </div>

      <div class="box">
         <img src="images/clock-icon.png" alt="">
         <h3>opening hours</h3>
         <p>00:07am to 00:10pm </p>
      </div>

      <div class="box">
         <img src="images/map-icon.png" alt="">
         <h3>our address</h3>
         <a href="https://www.google.com/maps">mumbai, india - 400104</a>
      </div>

      <div class="box">
         <img src="images/phone-icon.png" alt="">
         <h3>our number</h3>
         <a href="tel:1234567890">+123-456-7890</a>
         <a href="tel:1112223333">+111-222-3333</a>
      </div>

   </section>

   <div class="credit">&copy; copyright @ 2022 by <span>mr. web designer</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/Animation - 1735092558904.gif" alt="">
</div>

<script src="js/script.js"></script>
<script>
   function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}
</script>

</body>
</html>