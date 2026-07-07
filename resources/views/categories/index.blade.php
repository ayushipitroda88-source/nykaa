    @extends('layout.admin')

    @section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <!-- LEFT SIDE: CREATE FORM -->
            <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm border border-gray-200 sticky top-8">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h2 class="text-lg font-semibold flex items-center gap-2 text-gray-800">
                        <i class="fas fa-plus-circle text-green-500"></i> Create Category
                    </h2>
                </div>
                
                <div class="p-6 space-y-5">
                    <!-- Name Input -->
                <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Category Name <span class="text-red-500">*</span>
        </label>

        <input type="text" id="categoryName" placeholder="e.g. categories"
            class="w-full bg-white border border-gray-200 text-gray-800
            rounded-lg px-4 py-2.5
            focus:ring-2 focus:ring-blue-400 focus:border-blue-400
            outline-none transition-all">
    </div>

                    <!-- Parent Dropdown -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
                        <select id="parentCategory" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                            <option value="">None (Make it a Main Category)</option>
                            @foreach($allCategories as $category)
                                @if($category->parent_id == null)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;↳ {{ $child->name }}</option>
                                        @foreach($child->children as $grandchild)
                                            <option value="{{ $grandchild->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $grandchild->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Leave as "None" to create a top-level category.</p>
                    </div>

                    <!-- Submit Button -->
                    <button id="saveCategoryBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors shadow-sm">
                        Save Category
                    </button>
                </div>
            </div>

            <!-- RIGHT SIDE: TREE VIEW -->
            <div class="w-full lg:w-2/3 bg-white rounded-xl shadow-sm border border-gray-200 min-h-[500px]">
                <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center bg-gray-50 rounded-t-xl">
                    <h2 class="text-lg font-semibold flex items-center gap-2 text-gray-800">
                        <i class="fas fa-sitemap text-blue-500"></i> Category Hierarchy
                    </h2>
                    <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded font-bold">{{ $allCategories->count() }} Total</span>
                </div>
                
                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-6 border-l-4 border-yellow-400 pl-3 bg-yellow-50 py-2 rounded-r-md">
                        <i class="fas fa-mouse-pointer mr-1 text-yellow-600"></i> Click on a category name to edit it
                    </p>

                    <!-- The Tree Structure -->
                    <div class="space-y-1 font-medium text-gray-700">
                        @foreach($categories as $category)
                            @include('categories.tree-node', ['category' => $category])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <!-- Dark Background -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        
        <!-- Modal Content Box -->
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md relative z-10 mx-4 transform transition-all">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-pen-to-square text-blue-500"></i> Rename Category
                </h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                <input type="text" id="editCategoryName" class="w-full border border-gray-300 rounded-lg px-4 py-3 font-medium text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none shadow-inner">
                <input type="hidden" id="editCategoryId">
            </div>

            <!-- Footer / Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-xl flex justify-between items-center">
                <button onclick="deleteCategoryModal()" class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
                
                <div class="flex gap-3">
                    <button onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 bg-gray-100 border border-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button onclick="saveEditCategory()" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <i class="fas fa-check"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('editModal');
        const editInput = document.getElementById('editCategoryName');
        const editIdInput = document.getElementById('editCategoryId');

        function openEditModal(id, name) {
            editIdInput.value = id;
            editInput.value = name;
            editModal.classList.remove('hidden');
            setTimeout(() => {
                editInput.focus();
                editInput.select();
            }, 100);
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
        }

        function saveEditCategory() {
            const id = editIdInput.value;
            const name = editInput.value;

            fetch(`/categories/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ name: name })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    closeEditModal();
                    location.reload();
                }
            });
        }

        function deleteCategoryModal() {
            if(confirm('Are you sure you want to delete this category?')) {
                const id = editIdInput.value;
                
                fetch(`/categories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        closeEditModal();
                        location.reload();
                    }
                });
            }
        }

        document.getElementById('saveCategoryBtn').addEventListener('click', function() {
            const name = document.getElementById('categoryName').value;
            const parentId = document.getElementById('parentCategory').value;

            fetch('/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: name,
                    parent_id: parentId || null
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('categoryName').value = '';
                    document.getElementById('parentCategory').value = '';
                    location.reload();
                }
            });
        });
        
        
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('toggle-btn')) {

        const btn = e.target;
        const targetId = btn.getAttribute('data-target');
        const target = document.getElementById(targetId);

        if (!target) return;

        if (target.classList.contains('hidden')) {
            target.classList.remove('hidden');
            btn.textContent = '-';
        } else {
            target.classList.add('hidden');
            btn.textContent = '+';
        }
    }
});

    </script>
    @endsection