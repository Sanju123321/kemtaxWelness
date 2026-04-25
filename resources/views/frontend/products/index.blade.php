@extends('frontend.layouts.master')

@section('title', 'Ayurvedic Products - KemtexWellness')

@push('styles')
<style>
/* ── Page Hero ── */
.products-hero{background:linear-gradient(135deg,#1e7e34 0%,#28a745 60%,#5cb85c 100%);padding:60px 0 40px;color:#fff}
.products-hero h1{font-size:2.2rem;font-weight:800;margin-bottom:8px}
.products-hero p{opacity:.85;font-size:1rem;margin-bottom:0}
.breadcrumb-hero{background:none;padding:0;margin-bottom:10px}
.breadcrumb-hero .breadcrumb-item,.breadcrumb-hero .breadcrumb-item a{color:rgba(255,255,255,.75);font-size:13px}
.breadcrumb-hero .breadcrumb-item.active{color:#fff}
.breadcrumb-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.5)}
.stats-bar{background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.08);padding:18px 0;margin-bottom:30px}
.stat-item{text-align:center;padding:0 20px;border-right:1px solid #e9ecef}
.stat-item:last-child{border-right:none}
.stat-item .stat-number{font-size:1.8rem;font-weight:800;color:#28a745;line-height:1}
.stat-item .stat-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#888;margin-top:4px}
.filter-card{background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.07);padding:20px;position:sticky;top:20px}
.filter-card h6.filter-heading{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#aaa;margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid #f0f0f0}
.filter-chip{display:inline-block;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid #dee2e6;color:#555;margin:3px 2px;transition:all .15s;user-select:none}
.filter-chip:hover{border-color:#28a745;color:#28a745}
.filter-chip.active{background:#28a745;border-color:#28a745;color:#fff}
.products-toolbar{background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.07);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.toolbar-search{flex:1;min-width:200px;position:relative}
.toolbar-search input{width:100%;border:1.5px solid #e9ecef;border-radius:8px;padding:8px 14px 8px 36px;font-size:14px;outline:none;transition:border-color .15s}
.toolbar-search input:focus{border-color:#28a745}
.toolbar-search i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#aaa;font-size:13px}
.toolbar-sort select{border:1.5px solid #e9ecef;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;color:#555}
.view-toggle button{border:1.5px solid #e9ecef;background:#fff;width:34px;height:34px;border-radius:6px;cursor:pointer;color:#aaa;transition:all .15s}
.view-toggle button.active,.view-toggle button:hover{border-color:#28a745;color:#28a745;background:#eaf7ef}
.result-count{font-size:13px;color:#888;white-space:nowrap}
.product-card{background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.07);overflow:hidden;transition:all .25s;height:100%;display:flex;flex-direction:column}
.product-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.13)}
.product-img-wrap{height:200px;display:flex;align-items:center;justify-content:center;position:relative;background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%);overflow:hidden}
.product-img-wrap img{max-height:100%;max-width:100%;object-fit:cover}
.product-img-wrap .product-emoji{font-size:70px}
.product-badge{position:absolute;top:10px;left:10px;padding:3px 9px;border-radius:4px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em}
.badge-new{background:#28a745;color:#fff}
.badge-sale{background:#dc3545;color:#fff}
.badge-best{background:#ff9800;color:#fff}
.btn-fav{position:absolute;top:10px;right:10px;background:rgba(255,255,255,.9);border:none;width:32px;height:32px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;font-size:14px;color:#ccc}
.btn-fav:hover,.btn-fav.active{color:#e53935}
.product-body{padding:16px;flex:1;display:flex;flex-direction:column}
.product-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#28a745;margin-bottom:4px}
.product-name{font-size:15px;font-weight:700;color:#222;margin-bottom:6px;line-height:1.4}
.product-desc{font-size:12.5px;color:#777;line-height:1.5;flex:1;margin-bottom:10px}
.product-benefits{display:flex;flex-wrap:wrap;gap:4px;margin-bottom:10px}
.benefit-tag{background:#f0fdf4;color:#28a745;border:1px solid #bbf7d0;padding:2px 7px;border-radius:10px;font-size:10px;font-weight:600}
.product-rating{display:flex;align-items:center;gap:4px;margin-bottom:10px}
.product-rating i{color:#ffc107;font-size:12px}
.product-rating span{font-size:12px;color:#888}
.product-footer{display:flex;align-items:center;justify-content:space-between;padding-top:10px;border-top:1px solid #f0f0f0}
.price-current{font-size:1.2rem;font-weight:800;color:#28a745}
.price-original{font-size:12px;color:#bbb;text-decoration:line-through;margin-left:4px}
.price-discount{font-size:11px;font-weight:700;color:#dc3545;margin-left:4px}
.btn-add-cart{background:#28a745;color:#fff;border:none;padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;transition:background .15s;white-space:nowrap}
.btn-add-cart:hover{background:#1e7e34}
.btn-add-cart.loading{opacity:.7;pointer-events:none}
#products-container.list-view .product-col{flex:0 0 100%;max-width:100%}
#products-container.list-view .product-card{flex-direction:row}
#products-container.list-view .product-img-wrap{width:140px;height:140px;flex-shrink:0}
#products-container.list-view .product-body{padding:14px 18px}
.no-results{text-align:center;padding:60px 20px;color:#aaa}
.no-results i{font-size:3rem;margin-bottom:16px;display:block}
#toast-container{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px}
.toast-msg{background:#222;color:#fff;padding:10px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,.2);animation:slideIn .25s ease;max-width:280px}
.toast-msg.success{border-left:4px solid #28a745}
.toast-msg.error{border-left:4px solid #dc3545}
@keyframes slideIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
</style>
@endpush

@section('content')

<div id="toast-container"></div>
<span id="global-cart-count" data-count="{{ $cartCount }}" style="display:none"></span>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="products-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-hero">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
        <h1><i class="fas fa-leaf mr-2"></i>Ayurvedic Products</h1>
        <p>Discover our complete range of natural &amp; ayurvedic wellness products</p>
    </div>
</div>

<div class="stats-bar">
    <div class="container">
        <div class="row text-center">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ $products->total() }}</div>
                    <div class="stat-label">Products</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ count($categories) }}</div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Natural</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-4">
    <div class="container">
        <form id="filterForm" method="GET" action="{{ route('products') }}">
        <div class="row">
            <div class="col-lg-2 col-md-3 mb-4">
                <div class="filter-card">
                    <h6 class="filter-heading">Category</h6>
                    <div>
                        <span class="filter-chip {{ empty($filters['category']) || $filters['category'] === 'all' ? 'active' : '' }}"
                              data-filter="category" data-value="all">All</span>
                        @foreach($categories as $cat)
                            <span class="filter-chip {{ ($filters['category'] ?? '') === $cat ? 'active' : '' }}"
                                  data-filter="category" data-value="{{ $cat }}">{{ ucfirst($cat) }}</span>
                        @endforeach
                    </div>

                    <h6 class="filter-heading mt-4">Price Range</h6>
                    <div>
                        @foreach(['all' => 'All', '0-500' => 'Under ₹500', '500-1000' => '₹500–₹1K', '1000-2000' => '₹1K–₹2K', '2000+' => '₹2K+'] as $val => $label)
                            <span class="filter-chip {{ ($filters['price'] ?? 'all') === $val ? 'active' : '' }}"
                                  data-filter="price" data-value="{{ $val }}">{{ $label }}</span>
                        @endforeach
                    </div>

                    <h6 class="filter-heading mt-4">Availability</h6>
                    <div>
                        <span class="filter-chip {{ empty($filters['on_sale']) ? 'active' : '' }}"
                              data-filter="on_sale" data-value="">All</span>
                        <span class="filter-chip {{ !empty($filters['on_sale']) ? 'active' : '' }}"
                              data-filter="on_sale" data-value="1">On Sale</span>
                    </div>

                    <input type="hidden" name="category" id="input-category" value="{{ $filters['category'] ?? '' }}">
                    <input type="hidden" name="price"    id="input-price"    value="{{ $filters['price']    ?? '' }}">
                    <input type="hidden" name="on_sale"  id="input-on_sale"  value="{{ $filters['on_sale']  ?? '' }}">
                    <input type="hidden" name="sort"     id="input-sort"     value="{{ $filters['sort']     ?? '' }}">
                    <input type="hidden" name="search"   id="input-search"   value="{{ $filters['search']   ?? '' }}">

                    <button type="button" onclick="resetFilters()"
                            class="btn btn-sm btn-solid-border btn-round-full w-100 mt-3" style="font-size:12px;">
                        <i class="fas fa-redo mr-1"></i> Reset Filters
                    </button>
                </div>
            </div>

            <div class="col-lg-10 col-md-9">
                <div class="products-toolbar">
                    <div class="toolbar-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search products..."
                               value="{{ $filters['search'] ?? '' }}"
                               oninput="debounceSearch(this.value)">
                    </div>
                    <div class="toolbar-sort">
                        <select id="sortSelect" onchange="setSort(this.value)">
                            <option value="default"    {{ ($filters['sort'] ?? 'default') === 'default'    ? 'selected' : '' }}>Sort: Featured</option>
                            <option value="price-asc"  {{ ($filters['sort'] ?? '') === 'price-asc'         ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price-desc" {{ ($filters['sort'] ?? '') === 'price-desc'        ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating"     {{ ($filters['sort'] ?? '') === 'rating'            ? 'selected' : '' }}>Top Rated</option>
                            <option value="discount"   {{ ($filters['sort'] ?? '') === 'discount'          ? 'selected' : '' }}>Best Discount</option>
                        </select>
                    </div>
                    <div class="view-toggle">
                        <button type="button" id="gridBtn" class="active" onclick="setView('grid')" title="Grid view"><i class="fas fa-th"></i></button>
                        <button type="button" id="listBtn" onclick="setView('list')" title="List view"><i class="fas fa-list"></i></button>
                    </div>
                    <div class="result-count">
                        {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                    </div>
                </div>

                <div class="row" id="products-container">
                    @forelse($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4 product-col">
                            <div class="product-card">
                                <div class="product-img-wrap">
                                    @if($product->tags && in_array('New',  (array)$product->tags))<span class="product-badge badge-new">New</span>
                                    @elseif($product->tags && in_array('Sale',(array)$product->tags))<span class="product-badge badge-sale">Sale</span>
                                    @elseif($product->tags && in_array('Best',(array)$product->tags))<span class="product-badge badge-best">Best</span>
                                    @endif

                                    @auth
                                        <button type="button"
                                                class="btn-fav {{ in_array($product->id, $favoritedIds) ? 'active' : '' }}"
                                                data-product-id="{{ $product->id }}"
                                                onclick="toggleWishlist(this)"
                                                title="Toggle wishlist">
                                            <i class="{{ in_array($product->id, $favoritedIds) ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-fav" title="Login to wishlist"><i class="far fa-heart"></i></a>
                                    @endauth

                                    @if($product->image)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <span class="product-emoji">🌿</span>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <div class="product-cat">{{ ucfirst($product->category) }}</div>
                                    <div class="product-name">
                                        <a href="{{ route('products.show', $product->slug) }}" style="color:inherit;text-decoration:none;">{{ $product->name }}</a>
                                    </div>
                                    @if($product->short_desc)
                                        <div class="product-desc">{{ $product->short_desc }}</div>
                                    @endif
                                    @if($product->benefits)
                                        <div class="product-benefits">
                                            @foreach(array_slice((array)$product->benefits, 0, 3) as $b)
                                                <span class="benefit-tag">{{ $b }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="product-rating">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="{{ $s <= round($product->rating) ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                        <span>({{ $product->review_count }})</span>
                                    </div>
                                    <div class="product-footer">
                                        <div>
                                            <span class="price-current">₹{{ number_format($product->price,0) }}</span>
                                            @if($product->original_price)
                                                <span class="price-original">₹{{ number_format($product->original_price,0) }}</span>
                                                @if($product->discount_percent > 0)
                                                    <span class="price-discount">{{ $product->discount_percent }}% off</span>
                                                @endif
                                            @endif
                                        </div>
                                        @auth
                                            <button type="button" class="btn-add-cart"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    onclick="addToCart(this)">
                                                <i class="fas fa-shopping-bag mr-1"></i> Add
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn-add-cart"><i class="fas fa-shopping-bag mr-1"></i> Add</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="no-results">
                                <i class="fas fa-search-minus"></i>
                                <p>No products found.<br><small>Try changing your search or filters.</small></p>
                                <button type="button" class="btn btn-main btn-round-full btn-sm" onclick="resetFilters()">Reset Filters</button>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
        </form>
    </div>
</section>

<section class="py-5" style="background:linear-gradient(135deg,#1e7e34,#28a745);">
    <div class="container text-center text-white">
        <h3 class="font-weight-bold mb-2">Become a Distributor &amp; Earn</h3>
        <p class="mb-4" style="opacity:.85">Join our wellness network and earn commissions on every product sale.</p>
        <a href="{{ route('pricing') }}" class="btn btn-light btn-round-full mr-2" style="color:#28a745;font-weight:700;">Join Now</a>
        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-round-full">Contact Us</a>
    </div>
</section>
@endsection

@push('scripts')
<script>
const IS_AUTH   = {{ auth()->check() ? 'true' : 'false' }};
const CSRF      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let   cartCount = parseInt(document.getElementById('global-cart-count').dataset.count) || 0;

function toast(msg, type) {
    type = type || 'success';
    var el = document.createElement('div');
    el.className = 'toast-msg ' + type;
    el.textContent = msg;
    document.getElementById('toast-container').appendChild(el);
    setTimeout(function(){ el.remove(); }, 3500);
}

function updateCartBadge(count) {
    cartCount = count;
    document.querySelectorAll('.cart-badge').forEach(function(b){
        b.textContent = count;
        b.style.display = count > 0 ? 'inline-block' : 'none';
    });
}

function addToCart(btn) {
    if (!IS_AUTH) { window.location.href = '{{ route("login") }}'; return; }
    var productId   = btn.dataset.productId;
    var productName = btn.dataset.productName;
    btn.classList.add('loading');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>';
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
        body: JSON.stringify({product_id: parseInt(productId), quantity: 1})
    })
    .then(function(r){ return r.json(); })
    .then(function(data){
        if (data.success) {
            toast(data.message || '"' + productName + '" added to cart!', 'success');
            updateCartBadge(data.cart_count || cartCount + 1);
            btn.innerHTML = '<i class="fas fa-check mr-1"></i> Added';
            setTimeout(function(){
                btn.innerHTML = '<i class="fas fa-shopping-bag mr-1"></i> Add';
                btn.classList.remove('loading');
            }, 2000);
        } else {
            toast(data.message || 'Could not add to cart.', 'error');
            btn.innerHTML = '<i class="fas fa-shopping-bag mr-1"></i> Add';
            btn.classList.remove('loading');
        }
    })
    .catch(function(){
        toast('Network error. Please try again.', 'error');
        btn.innerHTML = '<i class="fas fa-shopping-bag mr-1"></i> Add';
        btn.classList.remove('loading');
    });
}

function toggleWishlist(btn) {
    if (!IS_AUTH) { window.location.href = '{{ route("login") }}'; return; }
    var productId = btn.dataset.productId;
    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
        body: JSON.stringify({product_id: parseInt(productId)})
    })
    .then(function(r){ return r.json(); })
    .then(function(data){
        if (data.success) {
            var icon = btn.querySelector('i');
            if (data.favorited) {
                btn.classList.add('active');
                icon.className = 'fas fa-heart';
                toast('Added to wishlist', 'success');
            } else {
                btn.classList.remove('active');
                icon.className = 'far fa-heart';
                toast('Removed from wishlist', 'success');
            }
        }
    })
    .catch(function(){ toast('Network error.', 'error'); });
}

document.querySelectorAll('.filter-chip').forEach(function(chip){
    chip.addEventListener('click', function(){
        var filterType = this.dataset.filter;
        var value      = this.dataset.value;
        this.closest('div').querySelectorAll('.filter-chip').forEach(function(c){ c.classList.remove('active'); });
        this.classList.add('active');
        document.getElementById('input-' + filterType).value = value;
        document.getElementById('filterForm').submit();
    });
});

function setSort(val) {
    document.getElementById('input-sort').value = val;
    document.getElementById('filterForm').submit();
}

var searchTimer;
function debounceSearch(val) {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function(){
        document.getElementById('input-search').value = val;
        document.getElementById('filterForm').submit();
    }, 500);
}

function resetFilters() { window.location.href = '{{ route("products") }}'; }

function setView(mode) {
    var container = document.getElementById('products-container');
    var gridBtn   = document.getElementById('gridBtn');
    var listBtn   = document.getElementById('listBtn');
    if (mode === 'list') {
        container.classList.add('list-view');
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    } else {
        container.classList.remove('list-view');
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    }
    localStorage.setItem('productView', mode);
}

(function(){
    var saved = localStorage.getItem('productView');
    if (saved === 'list') setView('list');
})();
</script>
@endpush
