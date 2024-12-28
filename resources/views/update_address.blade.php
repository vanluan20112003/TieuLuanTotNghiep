<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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
    
    @if (session('status'))
                <div class="alert {{ session('status') == 'Address updated successfully.' ? 'alert-success' : 'alert-danger' }}">
                    {{ session('status') }}
                </div>
            @endif
    <form action="{{ route('update.address') }}" method="post" id="addressForm">
        @csrf
        <select id="city" name="city" required class="box">
            <option value="selected">Chọn Tỉnh</option>
            <!-- Options will be populated by JavaScript -->
        </select>
        <select id="district" name="district" required class="box">
            <option value="" selected>Chọn Quận/Huyện</option>
            <!-- Options will be populated by JavaScript -->
        </select>
        <select id="ward" name="ward" required class="box">
            <option value="" selected>Chọn Đường</option>
            <!-- Options will be populated by JavaScript -->
        </select>
        <input type="text" maxlength="50" placeholder="Nhập số nhà" required class="box" name="flat">
        <!-- Hidden inputs to store names of selected options -->
        <input type="hidden" id="selectedCity" name="selectedCity">
        <input type="hidden" id="selectedDistrict" name="selectedDistrict">
        <input type="hidden" id="selectedWard" name="selectedWard">
        <input type="submit" value="Save Address" name="submit" class="btn">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

<script>
$(document).ready(function() {
    const host = "https://provinces.open-api.vn/api/";

    // Function to fetch and render data for dropdowns
    function callAPI(api, select, key) {
        return axios.get(api)
            .then((response) => {
                const data = key ? response.data[key] : response.data;
                renderData(data, select);
            })
            .catch((error) => {
                console.error(`Error fetching data from ${api}:`, error);
            });
    }

    // Function to render options in dropdown
    function renderData(array, select) {
        let row = '<option value="" selected>Chọn</option>';
        array.forEach(element => {
            row += `<option data-id="${element.code}" value="${element.name}">${element.name}</option>`;
        });
        $(`#${select}`).html(row);
    }

    // Initialize provinces (cities)
    callAPI(`${host}?depth=1`, 'city');

    // Update districts dropdown based on selected province
    $('#city').change(function() {
        const provinceCode = $(this).find(':selected').data('id');
        if (provinceCode) {
            callAPI(`${host}p/${provinceCode}?depth=2`, 'district', 'districts');
            $('#ward').html('<option value="" selected>Chọn phường xã</option>'); // Clear wards
        } else {
            $('#district').html('<option value="" selected>Chọn quận huyện</option>'); // Clear districts
            $('#ward').html('<option value="" selected>Chọn phường xã</option>'); // Clear wards
        }
        updateHiddenFields();
    });

    // Update wards dropdown based on selected district
    $('#district').change(function() {
        const districtCode = $(this).find(':selected').data('id');
        if (districtCode) {
            callAPI(`${host}d/${districtCode}?depth=2`, 'ward', 'wards');
        } else {
            $('#ward').html('<option value="" selected>Chọn phường xã</option>'); // Clear wards
        }
        updateHiddenFields();
    });

    // Display selected address
    $('#ward').change(function() {
        updateHiddenFields();
    });

    // Function to update hidden fields with selected names
    function updateHiddenFields() {
        $('#selectedCity').val($('#city').find(':selected').text());
        $('#selectedDistrict').val($('#district').find(':selected').text());
        $('#selectedWard').val($('#ward').find(':selected').text());
    }
});
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}
</script>



</body>
</html>