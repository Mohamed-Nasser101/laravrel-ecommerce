@extends('layout')

@section('title', 'Products')

@section('extra-css')

@endsection

@section('content')

    <x-breadcrumbs>
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span>
    </x-breadcrumbs>
    
    <div class="container">
        @if(session()->has('success-message'))
            <div class='alert alert-success'>
                {{ session()->get('success-message') }}
            </div>
        @endif
        @if(count($errors) > 0)
            <div class='alert alert-danger'>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
            @foreach ($categories as $category)
                <li class="{{ request()->category == $category->slug ? 'active' : '' }}" ><a href="{{ route('shop.index',['category' => $category->slug]) }}">{{$category->name}}</a></li>
            @endforeach
            </ul>

            {{-- <h3>By Price</h3>
            <ul>
                <li><a href="#">$0 - $700</a></li>
                <li><a href="#">$700 - $2500</a></li>
                <li><a href="#">$2500+</a></li>
            </ul> --}}
        </div> <!-- end sidebar -->
        <div>
        <div class="row">
            <div class="col-10"><h1 class="stylish-heading">{{ $categoryName }}</h1></div>
            <div class="col-2">
                <a class="badge badge-success" href="{{ route('shop.index',['category' => request()->category,'sort' => 'asc']) }}">asc</a> |
                <a class="badge badge-success" href="{{ route('shop.index',['category' => request()->category,'sort' => 'desc']) }}">desc</a>
            </div>
        </div>
            <div class="products text-center">
                @forelse ($products as $product)
                <div class="product">
                    <a href="{{ route('shop.show',['product' => $product->slug]) }}"><img src="{{ asset('img/products/'.$product->slug.'.jpg')}}" alt="product"></a>
                    <a href="{{ route('shop.show',['product' => $product->slug]) }}"><div class="product-name">{{ $product->name }}</div></a>
                    <div class="product-price">{{ $product->presentPrice() }}</div>
                </div>
                @empty
                    <div>No Items here</div>
                @endforelse
            </div> <!-- end products -->
        </div>
    </div>

@endsection
