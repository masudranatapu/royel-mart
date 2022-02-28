<section class="breadcrumb-section">
    <div class="container-fluid">
        <div class="category-breadcrumb">
            <div class="category-wrapper">
                <h4 class="dropdown-title">categories<i class="bi bi-chevron-down"></i></h4>
                <div class="category-area">
                    <div class="scroll-btn">
                        <span class="prev hide">
                            <i class="bi bi-chevron-up"></i>
                        </span>
                        <span class="next">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </div>
                    <button class="close-menu">
                        <i class="bi bi-x"></i>
                    </button>
                    <h3 class="mobile-title">categories</h3>
                    @php
                        $categories = App\Models\Category::where('status', 1)->latest()->get();
                    @endphp
                    <ul class="category-list">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('category', $category->slug) }}">
                                <img src="{{ asset($category->name) }}">
                                <span>{{ $category->name }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="breadcrumb-area">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="javascript:;">{{$title}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End Breadcrumb -->