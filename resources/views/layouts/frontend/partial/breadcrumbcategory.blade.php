<section class="breadcrumb-section">
    <div class="container-fluid">
        <div class="category-breadcrumb">
            <div class="category-wrapper">
                <h4 class="dropdown-title">categories<i class="bi bi-chevron-down"></i></h4>
                <div class="category-area checknav">
                    @php
                        $categories = App\Models\Category::where('parent_id', NULL)->where('child_id', NULL)->where('is_default', 0)->where('status', 1)->orderBy('serial_number', 'asc')->limit(18)->get();
                    @endphp
                    <ul class="category-list">
                        @foreach($categories as $category)
                            @php
                                $parentcategories = App\Models\Category::where('parent_id', $category->id)->where('child_id', NULL)->orderBy('parent_serial', 'ASC')->get();
                            @endphp
                            <li class="@if($parentcategories->count() > 0) has-sub @endif">
                                <a href="{{ route('category', $category->slug) }}">
                                    <img loading="eager|lazy" src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="Cat">
                                    {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($category->name, $lan, 'en') }}
                                </a>
                                @if($parentcategories->count() > 0)
                                    <ul>
                                        @foreach($parentcategories as $parentcategory)
                                            @php
                                                $childcategories = App\Models\Category::where('child_id', $parentcategory->id)->orderBy('child_serial', 'ASC')->get();
                                            @endphp
                                            <li @if($parentcategories->count() > 0) has-sub @endif>
                                                <a href="{{ route('category', $parentcategory->slug) }}">
                                                    {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($parentcategory->name, $lan, 'en') }}
                                                </a>
                                                @if($childcategories->count() > 0)
                                                    <ul>
                                                        @foreach($childcategories as $childcategory)
                                                            <li>
                                                                <a href="{{ route('category', $childcategory->slug) }}">
                                                                    {{ Stichoza\GoogleTranslate\GoogleTranslate::trans($childcategory->name, $lan, 'en') }}
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
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="breadcrumb-area">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ Stichoza\GoogleTranslate\GoogleTranslate::trans('Home', $lan, 'en') }}</a></li>
                    @php
                        $check_cat = App\Models\Category::find($p_cat_id);
                    @endphp
                    @if ($check_cat)
                        @if ($check_cat->parent_id != NULL)
                            @php
                                $b_cat = App\Models\Category::find($check_cat->parent_id);
                            @endphp
                            @if ($b_cat)
                                <li><a href="{{ route('category', $b_cat->slug) }}">{{ Stichoza\GoogleTranslate\GoogleTranslate::trans($b_cat->name, $lan, 'en') }}</a></li>
                            @endif
                        @endif
                        @if ($check_cat->child_id != NULL)
                            @php
                                $b_cat = App\Models\Category::find($check_cat->child_id);
                            @endphp
                            @if ($b_cat)
                                <li><a href="{{ route('category', $b_cat->slug) }}">{{ Stichoza\GoogleTranslate\GoogleTranslate::trans($b_cat->name, $lan, 'en') }}</a></li>
                            @endif
                        @endif
                    @endif
                    <li>{{ Stichoza\GoogleTranslate\GoogleTranslate::trans($title, $lan, 'en') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
