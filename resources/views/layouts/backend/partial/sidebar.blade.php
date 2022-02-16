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
        <!-- {{ Request::is('admin/dashboard') ? 'pcoded-trigger' : '' }} -->
        <li class="pcoded-hasmenu {{ Request::is('admin/category') || Request::is('admin/parent-category') || Request::is('admin/child-category') ? 'pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-sidebar"></i>
                </span>
                <span class="pcoded-mtext">Category</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/category') ? 'active' : '' }}">
                    <a href="{{ route('admin.category.index') }}">
                        <span class="pcoded-mtext">Main Category</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/parent-category') ? 'active' : '' }}">
                    <a href="{{ route('admin.parent-category.index') }}">
                        <span class="pcoded-mtext">Parent Category</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/child-category') ? 'active' : '' }}">
                    <a href="{{ route('admin.child-category.index') }}">
                        <span class="pcoded-mtext">Child Category</span>
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
    </ul>
    <ul class="pcoded-item pcoded-left-item">
        <li class="{{ Request::is('admin/product') || Request::is('admin/product/create') ? 'active' : '' }}">
            <a href="{{ route('admin.product.index') }}">
                <span class="pcoded-micon">
                    <i class="feather icon-message-square"></i>
                </span>
                <span class="pcoded-mtext">Product</span>
            </a>
        </li>
        <li class="pcoded-hasmenu ">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-check-circle"></i></span>
                <span class="pcoded-mtext">Task</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="task-list.html">
                        <span class="pcoded-mtext">Task List</span>
                    </a>
                </li>
                <li class="">
                    <a href="task-board.html">
                        <span class="pcoded-mtext">Task Board</span>
                    </a>
                </li>
                <li class="">
                    <a href="task-detail.html">
                        <span class="pcoded-mtext">Task Detail</span>
                    </a>
                </li>
                <li class="">
                    <a href="issue-list.html">
                        <span class="pcoded-mtext">Issue List</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu ">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-bookmark"></i></span>
                <span class="pcoded-mtext">To-Do</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="todo.html">
                        <span class="pcoded-mtext">To-Do</span>
                    </a>
                </li>
                <li class="">
                    <a href="notes.html">
                        <span class="pcoded-mtext">Notes</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/website') || Request::is('admin/banner') || Request::is('admin/mission-vision') || Request::is('admin/happy-client') || Request::is('admin/slider') ? 'active pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-globe"></i>
                </span>
                <span class="pcoded-mtext">Website</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="">
                        <span class="pcoded-mtext">About Us</span>
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
                <li class="{{ Request::is('admin/website') ? 'active' : '' }}">
                    <a href="{{ route('admin.website.index') }}">
                        <span class="pcoded-mtext">Website Setting</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>