<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
<style>
   /* app.css */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    color: #fff;
}

.alert-success {
    background-color: #28a745; /* Màu xanh lá cho thành công */
    border: 1px solid #28a745;
}

.alert-danger {
    background-color: #dc3545; /* Màu đỏ cho lỗi */
    border: 1px solid #dc3545;
}



</style>
</head>
<body>
   
<header class="header">

   <section class="flex">

      <a href="{{ url('/') }}" class="logo">yum-yum 😋</a>

      <nav class="navbar">
         <a href="{{ url('/') }}">Home</a>
         <a href="{{ url('/about') }}">About</a>
         <a href="{{ url('/menu') }}">Menu</a>
         <a href="{{ url('/orders') }}">Orders</a>
         <a href="{{ url('/contact') }}">Contact</a>
      </nav>

      <div class="icons">
         <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
         <a href="{{ url('/cart') }}" id="cart-link">
   
    <i class="fas fa-shopping-cart"></i><span>{{$cartQuantity}}</span>
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
<section class="form-container">
            <!-- Hiển thị thông báo thành công nếu có -->
            @if (session('status'))
                <div class="alert {{ session('status') == 'Cập nhật thành công.' ? 'alert-success' : 'alert-danger' }}">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Hiển thị các lỗi nếu có -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('update.profile.submit') }}" method="POST">
                @csrf
                <h3>Update Profile</h3>
                <input type="text" required maxlength="20" name="name" placeholder="Enter your name" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="{{ old('name', $user->name) }}">
                <input type="email" required maxlength="50" name="email" placeholder="Enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="{{ old('email', $user->email) }}">
                <input type="number" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" placeholder="Enter your number" required class="box" name="number" value="{{ old('number', $user->phone_number) }}">
                <input type="password" maxlength="20" name="old_pass" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="password" maxlength="20" name="new_pass" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="password" maxlength="20" name="new_pass_confirmation" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="submit" value="Update Now" class="btn" name="submit">
            </form>
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
   <img src="images/loader.gif" alt="">
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