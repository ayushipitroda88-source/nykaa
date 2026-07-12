<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  </li>
                    <li class="nav-item">
                        <a href="{{ url('/upload-product') }}" class="nav-link">
                          <i class="nav-icon fas fa-upload"></i>
                          <p>Upload Product</p>
                         </a>
                      </li>

                      <li class="nav-item">
                          <a href="{{ url('/products') }}" class="nav-link">
                            <i class="nav-icon fas fa-image"></i>
                            <p>View Products</p>
                          </a>
                      </li>

                    <li>
                      <a href="{{ route('collections.index') }}"class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                          Collections
                      </a>
                    </li>
                  </li>
                  <a href="{{ route('categories.index') }}" class="nav-link">
    <i class="nav-icon fas fa-list"></i>
    <p>Categories</p>
</a>
                </ul>
              </li>
        </li>
            
          <li class="nav-item">
    <a href="{{ route('brand') }}" class="nav-link">
        <i class="nav-icon fas fa-tags"></i>
        <p>Brand</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('color.index') }}" class="nav-link">
        <i class="nav-icon fas fa-palette"></i>
        <p>Colors</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('size.index') }}" class="nav-link">
        <i class="nav-icon fas fa-ruler-combined"></i>
        <p>Sizes</p>
    </a>
</li>

  
            
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>