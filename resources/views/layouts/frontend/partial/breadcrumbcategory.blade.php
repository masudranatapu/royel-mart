<section class="breadcrumb-section">
    <div class="container-fluid">
        <div class="category-breadcrumb">
            <div class="category-wrapper">
                <h4 class="dropdown-title">categories<i class="bi bi-chevron-down"></i></h4>
                <div class="category-area checknav">
                    @php
                        $categories = App\Models\Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->orderBy('serial_number', 'asc')->limit(18)->get();
                    @endphp
                    <ul class="category-list">
                        @foreach($categories as $category)
                            @if($category->id == 1)
                            @else
                                <li>
                                    <a href="{{ route('category', $category->slug) }}">
                                        <img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @php
                                        $parentcategories = App\Models\Category::where('parent_id', $category->id)->where('child_id', NULL)->orderBy('parent_serial', 'asc')->get();
                                    @endphp
                                    @if($parentcategories->count() > 0)
                                        <ul>
                                            @foreach($parentcategories as $parentcategory)
                                                <li>
                                                    <a href="{{ route('category', $parentcategory->slug) }}">
                                                        {{ $parentcategory->name }}
                                                    </a>
                                                    @php
                                                        $childcategories = App\Models\Category::where('child_id', $parentcategory->id)->orderBy('child_serial', 'asc')->get();
                                                    @endphp
                                                    @if($childcategories->count() > 0)
                                                        <ul>
                                                            @foreach($childcategories as $childcategory)
                                                                <li>
                                                                    <a href="{{ route('category', $childcategory->slug) }}">
                                                                        {{ $childcategory->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="breadcrumb-area">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
