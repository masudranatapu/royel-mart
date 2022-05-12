<div class="sidebar-area">
    <aside class="sidebar">
        <div class="inner-sidebar">
            <div class="single-widget">
                <h3 class="widget-title">filters</h3>
                <div class="price-filter">
                    <span class="label">price</span>
                    <div class="prices-wrapper">
                        <div class="single-price">
                            <div class="price">
                                <span>0</span><span>-</span><span>1000</span>
                            </div>
                            <a href="javascript:;" class="price-range price-filter-de-active" id="price_filter_0_1000" data-price="0-1000" onclick="filterByPrice(this)">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        <div class="single-price">
                            <div class="price">
                                <span>1000</span><span>-</span><span>5000</span>
                            </div>

                            <a href="javascript:;" class="price-range price-filter-de-active" id="price_filter_1000_5000" data-price="1000-5000" onclick="filterByPrice(this)">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        <div class="single-price">
                            <div class="price">
                                <span>5000</span><span>-</span><span>10000</span>
                            </div>

                            <a href="javascript:;" class="price-range price-filter-de-active" id="price_filter_5000_10000" data-price="5000-10000" onclick="filterByPrice(this)">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        <div class="single-price">
                            <div class="price">
                                <span>10000</span><span>-</span><span>10000+</span>
                            </div>

                            <a href="javascript:;" class="price-range price-filter-de-active" id="price_filter_10000_10000000000000" data-price="10000-10000000000000" onclick="filterByPrice(this)">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($brands->count() > 0)
                <div class="single-widget">
                    <h3 class="widget-title">brand</h3>
                    <div class="filter-list-wrapper exerp-menu">
                        <ul class="filter-list">
                            @foreach($brands as $brand)
                                @php
                                    $brand = App\Models\Brand::find($brand->brand_id);
                                @endphp
                                @if ($brand)
                                    <li class="filter-brand" id="filter_brand_{{ $brand->id }}">
                                        <a href="javascript:;" onclick="filterByBrand({{ $brand->id }})">{{ $brand->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($colors->count() > 0)
                <div class="single-widget">
                    <h3 class="widget-title">Color</h3>
                    <div class="color-filter exerp-menu">
                        <ul class="colors">
                            @foreach ($colors as $key=>$color)
                                <li class="filter-color" id="filter_color_{{ $color->id }}">
                                    <a href="javascript:;" class="black" style="background-color: {{ $color->code }};" onclick="filterByColor({{ $color->id }})"></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($sizes->count() > 0)
                <div class="single-widget">
                    <h3 class="widget-title">size</h3>
                    <div class="filter-size">
                        <ul class="filter-list">
                            @foreach ($sizes as $key=>$size)
                                <li class="filter-size" id="filter_size_{{ $size->id }}"><a href="javascript:;" onclick="filterBySize({{ $size->id }})">{{ $size->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($units->count() > 0)
                <div class="single-widget">
                    <h3 class="widget-title">Unit</h3>
                    <div class="filter-size">
                        <ul class="filter-list">
                            @foreach ($units as $key=>$unit)
                                @php
                                    $unit = App\Models\Unit::find($unit->unit_id);
                                @endphp
                                @if ($unit)
                                    <li class="filter-unit" id="filter_unit_{{ $unit->id }}">
                                        <a href="javascript:;" onclick="filterByUnit({{ $unit->id }})">{{ $unit->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if($latestproducts->count() > 0)
                <div class="single-widget">
                    <h3 class="widget-title">Latest Products</h3>
                    <div class="latest-products">
                        <ul>
                            @foreach($latestproducts as $product)
                                <li>
                                    <figure>
                                        <a href="{{ route('productdetails', $product->slug) }}">
                                            <img loading="eager|lazy" src=" @if(file_exists($product->thumbnail)) {{asset($product->thumbnail)}} @else {{ asset('media/general-image/no-photo.jpg') }} @endif" alt="{{ $product->name }}">
                                        </a>
                                    </figure>
                                    <div class="content">
                                        <div class="reviews">
                                            <div class="reviews-inner">
                                                <div class="reviewed" style="width: 80%">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="blanked">
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                            <span class="count-reviews">(4)</span>
                                        </div>
                                        <h3 class="product-name">
                                            <a href="{{ route('productdetails', $product->slug) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="price-cart">
                                            <span class="price">৳ {{$product->sale_price}}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </aside>
</div>
