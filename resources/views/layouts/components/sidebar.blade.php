<div class="col-md-3 flex-shrink-0 p-3">
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="{{ request()->routeIs('admin.index') ? 'true' : 'false'}}">
                Dashboard
            </button>
            <div class="collapse {{ request()->routeIs('admin.index') ? 'show' : ''}}" id="home-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li>
                        <a href="{{ route('dashboard') }}" class="link-body-emphasis d-inline-flex align-items-center text-decoration-none rounded">
                           <i class="fas fa-dashboard me-1"></i> Dashboard
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#category-collapse" aria-expanded="{{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.create') || request()->routeIs('admin.categories.edit') ? 'true' : 'false'}}">
                Profile
            </button>
            <div class="collapse {{ request()->routeIs('user-profiles.index') ? 'show' : ''}}" id="category-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li>
                        <a href="{{ route('user-profiles.index') }}" class="link-body-emphasis d-inline-flex align-items-center text-decoration-none rounded">
                           <i class="fas fa-list me-1"></i> Create/Edit Your Profile
                        </a>
                    </li>                    
                </ul>
            </div>
        </li>
        @if (auth()->user() 
                && auth()->user()->profile->is_creator 
                && auth()->user()->profile->processing_paid)        
        <li class="mb-1">
            <button type="button" 
                    class="btn btn-toggle 
                            d-inline-flex 
                            align-items-center 
                            rounded border-0 
                            collapsed" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#subcategory-collapse" 
                    aria-expanded="{{ request()->routeIs('admin.subcategories.index') || request()->routeIs('admin.subcategories.create') || request()->routeIs('admin.subcategories.edit') ? 'show' : ''}}"
            >
                Creator
            </button>
            <div class="collapse {{ request()->routeIs('admin.subcategories.index') || request()->routeIs('admin.subcategories.create') || request()->routeIs('admin.subcategories.edit') ? 'show' : ''}}" id="subcategory-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li>
                        <a href="{{ route('creator.post.create') }}" class="link-body-emphasis d-inline-flex align-items-center text-decoration-none rounded">
                           <i class="fas fa-layer-group me-1"></i> Create Post
                        </a>
                    </li>                    
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#childcategory-collapse" aria-expanded="{{ request()->routeIs('admin.childcategories.index') || request()->routeIs('admin.childcategories.create') || request()->routeIs('admin.childcategories.edit') ? 'true' : 'false'}}">
                Child categories
            </button>
            <div class="collapse {{ request()->routeIs('admin.childcategories.index') || request()->routeIs('admin.childcategories.create') || request()->routeIs('admin.childcategories.edit') ? 'show' : ''}}" id="childcategory-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li>
                        <a href="#" class="link-body-emphasis d-inline-flex align-items-center text-decoration-none rounded">
                           <i class="fas fa-table me-1"></i> All
                        </a>
                    </li>
                    <li>
                        <a href="#" class="link-body-emphasis d-inline-flex align-items-center text-decoration-none rounded">
                           <i class="fas fa-plus me-1"></i> New Child category
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</div>