{{-- <ul>
    <li><a href="{{ route('shop.index') }}">Shop</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Blog</a></li>
    <li><a href="{{ route('cart.index') }}">Cart <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span></a></li>
</ul> --}}

<ul>
    @foreach($items as $menu_item)
        <li>
        <a href="{{ $menu_item->link() }}">{{ $menu_item->title }}</a>
        @if ($menu_item->title == 'Cart')
            <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
        @endif
        </li>
    @endforeach
</ul>