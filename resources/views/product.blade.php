@extends('layout')

@section('title',$product->name)

@section('extra-css')

@endsection

@section('content')

<x-breadcrumbs>
    <a href="/">Home</a>
    <i class="fa fa-chevron-right breadcrumb-separator"></i>
    <span>Product</span>
</x-breadcrumbs>
    </div>
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

    <div class="product-section container">
        <div class="product-section-image">
            <img src="{{ asset('img/products/'.$product->slug.'.jpg')}}" alt="product">
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div class="badge badge-info">{{$status }}</div>
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p> {{ $product->description }} </p>

            <p>&nbsp;</p>

            {{-- <a href="" class="button">Add to Cart</a> --}}
            <form method='post' action='{{ route('cart.store') }}'>
                @csrf
                <input type='hidden' name='id' value='{{ $product->id }}' >
                <input type='hidden' name='name' value='{{ $product->name }}' >
                <input type='hidden' name='price' value='{{ $product->price }}' >
                <button type='submit' class='button button-plain'>Add to Cart</button>
            </form>
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')


@endsection
