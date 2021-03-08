@extends('layout')

@section('title',"search results")

@section('extra-css')

@endsection

@section('content')

    <x-breadcrumbs>
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Search</span>
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
    <div class="search-container container">
        <div class="container">
            <h1 class="text-center my-3">Search Results</h1>
        <p class="mb-3">{{ $products->total() }} result(s) for {{ request()->input('query') }}</p>
        <table class="table table-hover table-striped table-bordered table-sm">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Details</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><a href="{{ route('shop.show',$product->slug) }}">{{ $product->name }}</a></td>
                        <td>{{ $product->details }}</td>
                        <td>{{ Str::limit($product->description,80) }}</td>
                        <td>{{ $product->presentPrice() }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          {{ $products->appends(request()->input())->links() }}
        </div>
        
    </div> <!-- end search-section -->
@endsection
