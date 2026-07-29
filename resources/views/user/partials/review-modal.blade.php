<div class="modal fade" id="reviewModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #fc2779, #e01e69);">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-star-fill text-warning me-2"></i> 
                    {{ isset($review) && $review ? 'Edit Your Review' : 'Write a Product Review' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ isset($review) && $review ? route('user.reviews.update', $review->id) : route('user.reviews.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($review) && $review)
                    @method('PUT')
                @else
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                @endif

                <div class="modal-body p-4">
                    <!-- Product Header -->
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-4">
                        @if($product->image)
                            <img src="{{ asset('uploads/' . $product->image) }}" width="65" height="65" class="rounded object-fit-cover">
                        @endif
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $product->title }}</h6>
                            <span class="badge bg-success"><i class="bi bi-patch-check-fill me-1"></i> Verified Purchase</span>
                        </div>
                    </div>

                    <!-- Overall Star Rating -->
                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold d-block text-dark">Overall Rating <span class="text-danger">*</span></label>
                        <div class="star-rating-select justify-content-center">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" 
                                       id="star-{{ $product->id }}-{{ $i }}" 
                                       name="rating" 
                                       value="{{ $i }}" 
                                       {{ (isset($review) && $review->rating == $i) || (!isset($review) && $i == 5) ? 'checked' : '' }} 
                                       required>
                                <label for="star-{{ $product->id }}-{{ $i }}" title="{{ $i }} Stars">&#9733;</label>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="text-danger small mt-1 text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Title -->
                    <div class="mb-3">
                        <label for="title-{{ $product->id }}" class="form-label fw-bold text-dark">Review Title <span class="text-muted">(Optional)</span></label>
                        <input type="text" 
                               class="form-control form-control-lg border-2 @error('title') is-invalid @enderror" 
                               id="title-{{ $product->id }}" 
                               name="title" 
                               placeholder="Summarize your experience (e.g., Amazing quality & fast delivery!)" 
                               value="{{ old('title', $review->title ?? '') }}" 
                               maxlength="150">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Description -->
                    <div class="mb-3">
                        <label for="desc-{{ $product->id }}" class="form-label fw-bold text-dark">Review Message <span class="text-danger">*</span></label>
                        <textarea class="form-control border-2 @error('description') is-invalid @enderror" 
                                  id="desc-{{ $product->id }}" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Write your experience (minimum 10, maximum 1000 characters)..." 
                                  required 
                                  minlength="10" 
                                  maxlength="1000">{{ old('description', $review->description ?? '') }}</textarea>
                        <div class="form-text text-muted d-flex justify-content-between">
                            <span>Minimum 10 characters</span>
                            <span id="char-count-{{ $product->id }}">0/1000</span>
                        </div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Images -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark d-block">
                            Upload Review Images <small class="text-muted">(Optional, Maximum 5 images)</small>
                        </label>
                        <input type="file" 
                               name="images[]" 
                               class="form-control border-2 @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                               multiple 
                               accept="image/jpeg,image/png,image/webp" 
                               id="images-{{ $product->id }}"
                               onchange="previewReviewImages(this, 'image-preview-container-{{ $product->id }}')">
                        
                        <div id="image-preview-container-{{ $product->id }}" class="d-flex gap-2 flex-wrap mt-3">
                            @if(isset($review) && $review->images->count())
                                @foreach($review->images as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('uploads/' . $img->image_path) }}" class="rounded border" width="70" height="70" style="object-fit:cover;">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @error('images')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white fw-bold px-4 rounded-pill" style="background:#fc2779;">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.star-rating-select {
    display: flex;
    flex-direction: row-reverse;
    font-size: 36px;
    line-height: 1;
}
.star-rating-select input { display: none; }
.star-rating-select label {
    color: #e0e0e0;
    cursor: pointer;
    padding: 0 4px;
    transition: color 0.2s ease, transform 0.2s ease;
}
.star-rating-select label:hover,
.star-rating-select label:hover ~ label,
.star-rating-select input:checked ~ label {
    color: #ffb400;
}
.star-rating-select label:hover {
    transform: scale(1.15);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const descTextarea = document.getElementById("desc-{{ $product->id }}");
    const charCount = document.getElementById("char-count-{{ $product->id }}");
    
    if (descTextarea && charCount) {
        const updateCount = () => {
            charCount.textContent = `${descTextarea.value.length}/1000`;
        };
        descTextarea.addEventListener("input", updateCount);
        updateCount(); // Initial count
    }
});

function previewReviewImages(input, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    if (input.files) {
        const filesAmount = Math.min(input.files.length, 5);
        for (let i = 0; i < filesAmount; i++) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'rounded border shadow-sm';
                img.style.width = '70px';
                img.style.height = '70px';
                img.style.objectFit = 'cover';
                container.appendChild(img);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}
</script>
