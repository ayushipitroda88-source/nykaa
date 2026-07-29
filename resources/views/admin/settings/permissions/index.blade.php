@extends('layout.admin')

@section('title', 'Permission Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h3 class="mb-0">
                <i class="fas fa-shield-alt me-2"></i>Permission Management
            </h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Permission Management</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-shield-alt fs-4 text-primary"></i>
                <div>
                    <h5 class="card-title mb-0">Role Permissions</h5>
                    <small class="text-muted">Select a role to manage its permissions</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2" style="min-width: 280px;">
                    <label for="roleSelect" class="form-label mb-0 fw-semibold text-nowrap">Select Role:</label>
                    <select id="roleSelect" class="form-select form-select-sm">
                        <option value="">-- Choose a Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" data-slug="{{ $role->slug }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.settings.permissions.sync') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync me-1"></i> Sync Permissions
                </a>
            </div>
        </div>
        <div class="card-body">
            <div id="noRoleSelected" class="text-center py-5">
                <i class="fas fa-hand-pointer fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Select a role from the dropdown above</h5>
                <p class="text-muted mb-0">Permissions will load automatically</p>
            </div>

            <div id="superAdminNotice" class="alert alert-info d-none">
                <div class="d-flex align-items-center">
                    <i class="fas fa-crown fa-2x me-3 text-warning"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Super Admin</h5>
                        <p class="mb-0">Super Admin always has full access to all modules and permissions. Permissions cannot be modified for this role.</p>
                    </div>
                </div>
            </div>

            <div id="permissionsContent" class="d-none">
                <form id="permissionsForm">
                    <input type="hidden" name="role_id" id="roleId">
                    
                    <div id="permissionsCards" class="row g-4">
                        {{-- Permissions will be loaded via AJAX --}}
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2 border-top pt-4">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="button" id="selectAllBtn" class="btn btn-info">
                                    <i class="fas fa-check-double me-1"></i> Select All
                                </button>
                                <button type="button" id="deselectAllBtn" class="btn btn-warning">
                                    <i class="fas fa-times-circle me-1"></i> Deselect All
                                </button>
                                <button type="submit" id="savePermissionsBtn" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Permissions
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    const noRoleSelected = document.getElementById('noRoleSelected');
    const superAdminNotice = document.getElementById('superAdminNotice');
    const permissionsContent = document.getElementById('permissionsContent');
    const permissionsCards = document.getElementById('permissionsCards');
    const roleIdInput = document.getElementById('roleId');
    const permissionsForm = document.getElementById('permissionsForm');
    const saveBtn = document.getElementById('savePermissionsBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');

    // Load permissions when role is selected
    roleSelect.addEventListener('change', function() {
        const roleId = this.value;
        
        if (!roleId) {
            noRoleSelected.classList.remove('d-none');
            superAdminNotice.classList.add('d-none');
            permissionsContent.classList.add('d-none');
            return;
        }

        loadPermissions(roleId);
    });

    function loadPermissions(roleId) {
        // Show loading state
        permissionsCards.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading permissions...</p>
            </div>
        `;
        noRoleSelected.classList.add('d-none');
        permissionsContent.classList.remove('d-none');

        fetch(`/admin/settings/permissions/role/${roleId}`)
            .then(response => response.json())
            .then(data => {
                roleIdInput.value = roleId;

                if (data.is_super_admin) {
                    superAdminNotice.classList.remove('d-none');
                    renderSuperAdminPermissions(data.permissions);
                    saveBtn.disabled = true;
                    selectAllBtn.disabled = true;
                    deselectAllBtn.disabled = true;
                } else {
                    superAdminNotice.classList.add('d-none');
                    renderPermissions(data.permissions, data.assigned_slugs);
                    saveBtn.disabled = false;
                    selectAllBtn.disabled = false;
                    deselectAllBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading permissions:', error);
                permissionsCards.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load permissions. Please try again.
                        </div>
                    </div>
                `;
            });
    }

    function renderSuperAdminPermissions(modules) {
        let html = '';
        Object.values(modules).forEach(module => {
            const moduleSlug = module.slug;
            const icon = getModuleIcon(module.module);
            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-primary border-opacity-25">
                        <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
                            <h6 class="card-title mb-0">
                                <i class="${icon} me-2"></i>${module.module}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                ${module.actions.map(action => `
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>${capitalize(action)}
                                    </span>
                                `).join('')}
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-crown me-1 text-warning"></i>Full access (Super Admin)
                            </small>
                        </div>
                    </div>
                </div>
            `;
        });
        permissionsCards.innerHTML = html;
    }

    function renderPermissions(modules, assignedSlugs) {
        let html = '';
        Object.values(modules).forEach(module => {
            const moduleSlug = module.slug;
            const icon = getModuleIcon(module.module);
            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="${icon} me-2"></i>${module.module}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                ${module.permissions.map(perm => {
                                    const checked = assignedSlugs.includes(perm.slug) ? 'checked' : '';
                                    return `
                                        <div class="form-check form-check-inline permission-checkbox">
                                            <input class="form-check-input permission-input" 
                                                type="checkbox" 
                                                id="perm_${perm.id}" 
                                                value="${perm.slug}"
                                                name="permissions[]"
                                                ${checked}>
                                            <label class="form-check-label" for="perm_${perm.id}">
                                                ${capitalize(perm.action)}
                                            </label>
                                        </div>
                                    `;
                                }).join('')}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        permissionsCards.innerHTML = html;
    }

    // Select All
    selectAllBtn.addEventListener('click', function() {
        document.querySelectorAll('.permission-input:not(:disabled)').forEach(cb => {
            cb.checked = true;
        });
    });

    // Deselect All
    deselectAllBtn.addEventListener('click', function() {
        document.querySelectorAll('.permission-input:not(:disabled)').forEach(cb => {
            cb.checked = false;
        });
    });

    // Save Permissions
    permissionsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const roleId = roleIdInput.value;
        const checkboxes = document.querySelectorAll('.permission-input:checked');
        const permissions = Array.from(checkboxes).map(cb => cb.value);

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Saving...';

        fetch('{{ route("admin.settings.permissions.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                role_id: parseInt(roleId),
                permissions: permissions,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message);
            } else {
                showToast('error', data.message || 'Failed to save permissions.');
            }
        })
        .catch(error => {
            console.error('Error saving permissions:', error);
            showToast('error', 'An error occurred while saving permissions.');
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save me-1"></i> Save Permissions';
        });
    });

    // Helper functions
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function getModuleIcon(module) {
        const icons = {
            'Dashboard': 'bi bi-speedometer',
            'Products': 'bi bi-box-seam',
            'Variants': 'bi bi-collection',
            'Categories': 'bi bi-folder',
            'Collections': 'bi bi-grid',
            'Brands': 'bi bi-tag',
            'Seller Management': 'bi bi-people',
            'Customer Management': 'bi bi-person-badge',
            'Orders': 'bi bi-cart',
            'Request Center': 'bi bi-clipboard-check',
            'Analytics': 'bi bi-bar-chart',
            'Staff': 'bi bi-person-gear',
            'Settings': 'bi bi-gear',
        };
        return icons[module] || 'bi bi-circle';
    }

    function showToast(type, message) {
        const toastContainer = document.createElement('div');
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        toastContainer.innerHTML = `
            <div class="toast show align-items-center text-white ${bgClass} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${iconClass} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        document.body.appendChild(toastContainer);
        
        setTimeout(() => {
            toastContainer.remove();
        }, 5000);
    }
});
</script>
@endpush