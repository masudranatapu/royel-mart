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
    <div class="pcoded-navigatio-lavel">App</div>
    <ul class="pcoded-item pcoded-left-item">
        <li class=" ">
            <a href="chat.html">
                <span class="pcoded-micon"><i class="feather icon-message-square"></i></span>
                <span class="pcoded-mtext">Chat</span>
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
        <li class="pcoded-hasmenu ">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-image"></i></span>
                <span class="pcoded-mtext">Gallery</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="gallery-grid.html">
                        <span class="pcoded-mtext">Gallery-Grid</span>
                    </a>
                </li>
                <li class="">
                    <a href="gallery-masonry.html">
                        <span class="pcoded-mtext">Masonry Gallery</span>
                    </a>
                </li>
                <li class="">
                    <a href="gallery-advance.html">
                        <span class="pcoded-mtext">Advance Gallery</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu ">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-search"></i><b>S</b></span>
                <span class="pcoded-mtext">Search</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="search-result.html">
                        <span class="pcoded-mtext">Simple Search</span>
                    </a>
                </li>
                <li class="">
                    <a href="search-result2.html">
                        <span class="pcoded-mtext">Grouping Search</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu ">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-award"></i></span>
                <span class="pcoded-mtext">Job Search</span>
                <span class="pcoded-badge label label-danger">NEW</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="job-card-view.html">
                        <span class="pcoded-mtext">Card View</span>
                    </a>
                </li>
                <li class="">
                    <a href="job-details.html">
                        <span class="pcoded-mtext">Job Detailed</span>
                    </a>
                </li>
                <li class="">
                    <a href="job-find.html">
                        <span class="pcoded-mtext">Job Find</span>
                    </a>
                </li>
                <li class="">
                    <a href="job-panel-view.html">
                        <span class="pcoded-mtext">Job Panel View</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="pcoded-hasmenu {{ Request::is('admin/website') ? 'active pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon">
                    <i class="feather icon-globe"></i>
                </span>
                <span class="pcoded-mtext">Website Setting</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin/website') ? 'active' : '' }}">
                    <a href="{{ route('admin.website.index') }}">
                        <span class="pcoded-mtext">Website</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>