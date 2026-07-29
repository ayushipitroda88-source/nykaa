<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="./assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Marketplace -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-store"></i>
                        <p>Marketplace <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.approvals') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Product Approvals</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/products') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('collections.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Collections</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Request Center -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Request Center <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.request-center.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>All Requests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.request-center.pending') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Pending <span class="badge bg-warning text-dark ms-1">{{ App\Models\RequestCenterRequest::where('status', 'pending')->count() }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.request-center.approved') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Approved</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.request-center.rejected') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Rejected</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.request-center.history') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Review Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Review Management <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.pending') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Pending Reviews <span class="badge bg-warning text-dark ms-1">{{ App\Models\Review::where('status', 'pending')->count() }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.approved') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Approved Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.rejected') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Rejected Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.reported') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Reported Reviews <span class="badge bg-danger ms-1">{{ App\Models\ReviewReport::where('status', 'pending')->count() }}</span></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Seller Management -->
                <li class="nav-item">
                    <a href="{{ route('admin.sellers.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Seller Management</p>
                    </a>
                </li>

                <!-- Customer Management (placeholder) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Customer Management</p>
                    </a>
                </li>

                <!-- Staff -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Staff <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.staff.dashboard') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.staff.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Staff List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.staff.activity-logs') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Activity Logs</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Analytics -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Analytics <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.analytics.products') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Product Analytics</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.analytics.brands') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Brand Analytics</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.analytics.sellers') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Seller Analytics</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.roles.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Role Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.permissions.index') }}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Permission Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>