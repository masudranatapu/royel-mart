<div class="pcoded-inner-navbar main-menu">
    <ul class="pcoded-item pcoded-left-item">
        <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <span class="pcoded-micon">
                    <i class="feather icon-home"></i>
                </span>
                <span class="pcoded-mtext">Dashboard</span>
            </a>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/category') || Request::is('admin/category-banner') || Request::is('admin/category-ads') ? 'pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-sidebar"></i>
                </span>
                <span class="pcoded-mtext">Category</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/category') ? 'active' : '' }}">
                    <a href="{{ route('admin.category.index') }}">
                        <span class="pcoded-mtext">Category</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/category-banner')? 'active' : '' }}">
                    <a href="{{ route('admin.category-banner.index') }}">
                        <span class="pcoded-mtext">Category Banner</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/category-ads')? 'active' : '' }}">
                    <a href="{{ route('admin.category-ads.index') }}">
                        <span class="pcoded-mtext">Category Ads</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="{{ Request::is('admin/brand') ? 'active' : '' }}">
            <a href="{{ route('admin.brand.index') }}">
                <span class="pcoded-micon">
                    <i class="feather icon-menu"></i>
                </span>
                <span class="pcoded-mtext">Brand</span>
            </a>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/unit') || Request::is('admin/sub-unit') ? 'pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-layers"></i>
                </span>
                <span class="pcoded-mtext">Unit</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/unit') ? 'active' : '' }}">
                    <a href="{{route('admin.unit.index')}}">
                        <span class="pcoded-mtext">Unit</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/sub-unit') ? 'active' : '' }}">
                    <a href="{{ route('admin.sub-unit.index') }}">
                        <span class="pcoded-mtext">Sub Unit</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/division') || Request::is('admin/district') ? 'pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-bookmark"></i>
                </span>
                <span class="pcoded-mtext">Location</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/division') ? 'active' : '' }}">
                    <a href="{{ route('admin.division.index') }}">
                        <span class="pcoded-mtext">Division</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/district') ? 'active' : '' }}">
                    <a href="{{ route('admin.district.index') }}">
                        <span class="pcoded-mtext">District</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu {{ Request::is('admin/product') || Request::is('admin/product/create') ? 'pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-message-square"></i>
                </span>
                <span class="pcoded-mtext">Product</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/product/create') ? 'active' : '' }}">
                    <a href="{{ route('admin.product.create') }}">
                        <span class="pcoded-mtext">Add Product</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/product') ? 'active' : '' }}">
                    <a href="{{ route('admin.product.index') }}">
                        <span class="pcoded-mtext">Product list</span>
                    </a>
                </li>
            </ul>
        </li>
        @php
            $pendingOrders = App\Models\Order::where('order_status', 'Pending')->latest()->get();
            $confirmedOrders = App\Models\Order::where('order_status', 'Confirmed')->latest()->get();
            $processingOrders = App\Models\Order::where('order_status', 'Processing')->latest()->get();
            $deliveredOrders = App\Models\Order::where('order_status', 'Delivered')->latest()->get();
            $successedOrders = App\Models\Order::where('order_status', 'Successed')->latest()->get();
            $canceledOrders = App\Models\Order::where('order_status', 'Canceled')->latest()->get();
        @endphp
        <li class="pcoded-hasmenu {{ Request::is('admin/orders') || Request::is('admin/orders-pending') || Request::is('admin/orders-confirmed') || Request::is('admin/orders-processing') ||Request::is('admin/orders-delivered') || Request::is('admin/orders-successed') || Request::is('admin/orders-canceled') ? 'pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-gitlab"></i>
                </span>
                <span class="pcoded-mtext">
                    Order Management
                </span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/orders-pending') ? 'active' : '' }}">
                    <a href="{{route('admin.orders.pending')}}">
                        <span class="pcoded-mtext">
                            Pending Order
                        </span>
                        <span class="pcoded-badge label label-info">
                            {{ $pendingOrders->count() }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/orders-confirmed') ? 'active' : '' }}">
                    <a href="{{route('admin.orders.confirmed')}}">
                        <span class="pcoded-mtext">
                            Confirmed Order
                        </span>
                        <span class="pcoded-badge label label-info">
                            {{ $confirmedOrders->count() }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/orders-processing') ? 'active' : '' }}">
                    <a href="{{route('admin.orders.processing')}}">
                        <span class="pcoded-mtext">
                            Processing Order
                        </span>
                        <span class="pcoded-badge label label-info">
                            {{ $processingOrders->count() }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/orders-delivered') ? 'active' : '' }}">
                    <a href="{{route('admin.orders.delivered')}}">
                        <span class="pcoded-mtext">
                            Delivered Order
                        </span>
                        <span class="pcoded-badge label label-info">
                            {{ $deliveredOrders->count() }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/orders-successed') ? 'active' : '' }}">
                    <a href="{{route('admin.orders.successed')}}">
                        <span class="pcoded-mtext">
                            Successed Order
                        </span>
                        <span class="pcoded-badge label label-info">
                            {{ $successedOrders->count() }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/orders-canceled') ? 'active' : '' }}">
                    <a href="{{route('admin.orders.canceled')}}">
                        <span class="pcoded-mtext">
                            Canceled Order
                        </span>
                        <span class="pcoded-badge label label-info">
                            {{ $canceledOrders->count() }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/orders') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}">
                        <span class="pcoded-mtext">
                            All Orders
                        </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/purchase/create') || Request::is('admin/purchase') || Request::is('admin/sold-product') || Request::is('admin/sold-product-report') ? 'pcoded-trigger' : '' }}"">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-check-circle"></i>
                </span>
                <span class="pcoded-mtext">
                    Stock Management
                </span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/purchase/create') ? 'active' : '' }}">
                    <a href="{{ route('admin.purchase.create') }}">
                        <span class="pcoded-mtext">Add Purchase Product</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/purchase') ? 'active' : '' }}">
                    <a href="{{ route('admin.purchase.index') }}">
                        <span class="pcoded-mtext">Purchase Product List</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/sold-product') ? 'active' : '' }}">
                    <a href="{{ route('admin.sold-product.index') }}">
                        <span class="pcoded-mtext">Sold Product</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/sold-product-report') ? 'active' : '' }}">
                    <a href="{{ route('admin.sold-product.report') }}">
                        <span class="pcoded-mtext">Stock Report</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/message') || Request::is('admin/contact-massage') || Request::is('admin/policy') || Request::is('admin/abouts') || Request::is('admin/website') || Request::is('admin/banner') || Request::is('admin/mission-vision') || Request::is('admin/happy-client') || Request::is('admin/slider') ? 'active pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-globe"></i>
                </span>
                <span class="pcoded-mtext">Website</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/abouts')? 'active' : '' }}">
                    <a href="{{ route('admin.abouts.index') }}">
                        <span class="pcoded-mtext">About</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/slider')? 'active' : '' }}">
                    <a href="{{ route('admin.slider.index') }}">
                        <span class="pcoded-mtext">Slider</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/banner')? 'active' : '' }}">
                    <a href="{{ route('admin.banner.index') }}">
                        <span class="pcoded-mtext">Banner</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/message')? 'active' : '' }}">
                    <a href="{{ route('admin.message.index') }}">
                        <span class="pcoded-mtext">Message</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/policy')? 'active' : '' }}">
                    <a href="{{ route('admin.policy.index') }}">
                        <span class="pcoded-mtext">Policy</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/happy-client')? 'active' : '' }}">
                    <a href="{{ route('admin.happy-client.index') }}">
                        <span class="pcoded-mtext">Happy Client</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/mission-vision')? 'active' : '' }}">
                    <a href="{{ route('admin.mission-vision.index') }}">
                        <span class="pcoded-mtext">Mission Vision</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/contact-massage')? 'active' : '' }}">
                    <a href="{{ route('admin.contact-massage') }}">
                        <span class="pcoded-mtext">Contact Massage</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/website') ? 'active' : '' }}">
                    <a href="{{ route('admin.website.index') }}">
                        <span class="pcoded-mtext">Website Setting</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>