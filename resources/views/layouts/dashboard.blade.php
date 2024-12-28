@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1>Welcome to the Admin Dashboard</h1>
    <p>Here you can manage products, categories, users, orders, and view statistics.</p>

    <!-- Card Container -->
    <div class="card-container mb-4">
        <div class="row">
            <!-- Card 1: Today's Revenue -->
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Today's Revenue</h5>
                        <p class="card-text">${{ number_format($todayRevenue, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Weekly Revenue -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Weekly Revenue</h5>
                        <p class="card-text">${{ number_format($weeklyRevenue, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Monthly Revenue -->
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Revenue</h5>
                        <p class="card-text">${{ number_format($monthlyRevenue, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: Weekly User Registrations -->
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">New Users This Week</h5>
                        <p class="card-text">{{ $weeklyUserRegistrations }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 5: Weekly Product Additions -->
            <div class="col-md-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Products Added This Week</h5>
                        <p class="card-text">{{ $weeklyProductAdditions }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
