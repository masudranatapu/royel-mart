<section class="breadcrumb-section">
    <div class="container-fluid">
        <div class="category-breadcrumb">
            <div class="category-wrapper">
                <h4 class="dropdown-title">categories<i class="bi bi-chevron-down"></i></h4>
                <div class="category-area checknav">
                    <ul class="category-list">
                        @include('layouts.frontend.partial.breadcrumb_category')
                    </ul>
                </div>
            </div>
            <div class="breadcrumb-area">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ language_convert('Home') }}</a></li>

                    {{-- {{ category_breadcrumb_title($p_cat_id) }} --}}
                    @php
                        $check_cat = App\Models\Category::find($p_cat_id);
                    @endphp
                    @if ($check_cat)
                        @if ($check_cat->parent_id != NULL)
                            @php
                                $b_cat = App\Models\Category::find($check_cat->parent_id);
                            @endphp
                            @if ($b_cat)
                                <li><a href="{{ route('category', $b_cat->slug) }}">{{ language_convert($b_cat->name) }}</a></li>
                            @endif
                        @endif
                        @if ($check_cat->child_id != NULL)
                            @php
                                $b_cat = App\Models\Category::find($check_cat->child_id);
                            @endphp
                            @if ($b_cat)
                                <li><a href="{{ route('category', $b_cat->slug) }}">{{ language_convert($b_cat->name) }}</a></li>
                            @endif
                        @endif
                    @endif
                    <li>{{ language_convert($title) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
