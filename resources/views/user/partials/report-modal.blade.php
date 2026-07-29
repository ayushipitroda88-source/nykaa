<div class="modal fade" id="reportModal-{{ $reviewId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-flag-fill me-2"></i> Report Review</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('user.reviews.report', $reviewId) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Please select a reason why you are reporting this review. Moderators will review the content.</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                        <select name="reason" class="form-select border-2" required>
                            <option value="" disabled selected>-- Select Reason --</option>
                            <option value="spam">Spam</option>
                            <option value="fake_review">Fake Review</option>
                            <option value="abusive_language">Abusive Language</option>
                            <option value="misleading_information">Misleading Information</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Additional Details <small class="text-muted">(Optional)</small></label>
                        <textarea name="details" class="form-control border-2" rows="3" placeholder="Provide extra information to help our moderation team..."></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4 rounded-pill fw-bold">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
