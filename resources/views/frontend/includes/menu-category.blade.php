<nav class="navbar" id="main-nav">
    <div class="container">
        <ul class="navbar-nav">
            @foreach(App\Models\Category::with(['subcategories.subsubcategories'])->where('status', 1)->where('featured',1)->get() as $category)
            <li class="nav-item {{ $category->subcategories->count() > 0 ? 'has-child' : '' }}">
                <a class="nav-link" href="{{ route('category.product',$category->slug) }}">
                    {{ $category->name }}
                </a>

                @if($category->subcategories->count() > 0)
                <ul class="drop-down drop-menu-1">
                    @foreach($category->subcategories->take(15) as $subcategory)
                    <li class="nav-item {{ $subcategory->subsubcategories->count() > 0 ? 'has-child' : '' }}">
                       <a class="nav-link" href="{{ route('subcategory.product', [$subcategory->category->slug, $subcategory->slug]) }}">
                            {{ $subcategory->name }}
                        </a>

                        @if($subcategory->subsubcategories->count() > 0)
                        <ul class="drop-down drop-menu-2">
                            @foreach($subcategory->subsubcategories->take(15) as $subsubcategory)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('subsubcategory.product', [$category->slug, $subcategory->slug, $subsubcategory->slug]) }}">
                                        {{ $subsubcategory->name }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                        @endif
                    </li>
                    @endforeach

                    <li>
                        <a href="{{ route('category.product',$category->slug) }}" class="see-all">Show All {{ $category->name }}</a>
                    </li>
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</nav>
