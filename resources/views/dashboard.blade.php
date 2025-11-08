@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div>
        <h2>Total User: {{ $totalUsers }}</h2>
        <h2>Total Produk: {{ $totalProducts }}</h2>
        <h2>Total Pendapatan: ${{ $totalRevenue }}</h2>
    </div>
</div>
@endsection
