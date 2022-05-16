@foreach(main_categories() as $category)
    <li class="@if(parent_categories($category->id)->count() > 0) has-sub @endif">
        <a href="{{ route('category', $category->slug) }}">
            <img loading="eager|lazy" src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="Cat">
            {{ language_convert($category->name) }}
        </a>
        @if(parent_categories($category->id)->count() > 0)
            <ul>
                @foreach(parent_categories($category->id) as $parentcategory)
                    <li @if(parent_categories($category->id)->count() > 0) has-sub @endif>
                        <a href="{{ route('category', $parentcategory->slug) }}">
                            {{ language_convert($parentcategory->name) }}
                        </a>
                        @if(child_categories($parentcategory->id)->count() > 0)
                            <ul>
                                @foreach(child_categories($parentcategory->id) as $childcategory)
                                    <li>
                                        <a href="{{ route('category', $childcategory->slug) }}">
                                            {{ language_convert($childcategory->name) }}
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
