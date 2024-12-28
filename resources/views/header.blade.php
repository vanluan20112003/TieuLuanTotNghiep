<!-- resources/views/layouts/header.blade.php -->
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
         <a href="{{ url('/cart') }}"><i class="fas fa-shopping-cart"></i><span>{{$cartQuantity}}</span></a>
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
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <p class="name">
            @auth
               {{ Auth::user()->name }}
            @else
               Guest
            @endauth
         </p>
         <div class="flex">
            @auth
               <a href="{{ url('/profile') }}" class="btn">Profile</a>
               <button class="delete-btn" onclick="confirmLogout()">Logout</button>
               
               <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  @csrf
               </form>
            @else
               <a href="{{ url('/login') }}" class="btn">Login</a>
               <a href="{{ url('/register') }}" class="btn">Register</a>
            @endauth
         </div>
      </div>
   </section>
</header>
