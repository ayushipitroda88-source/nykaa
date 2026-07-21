@extends('layout.seller')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        @if($seller->status === 'pending')
            {{-- Pending Status --}}
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <span class="display-1 text-warning">
                            <i class="fas fa-clock"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-3">Application Under Review</h3>
                    <div class="mb-4">
                        <span class="badge bg-warning text-dark fs-6 px-4 py-2">
                            <i class="fas fa-hourglass-half me-1"></i> Pending Approval
                        </span>
                    </div>
                    <p class="text-muted mb-4">
                        Thank you for registering as a seller. Your application is currently being reviewed by our team.
                        You will be notified once your account has been approved.
                    </p>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        This process typically takes 24-48 hours. We appreciate your patience.
                    </div>
                </div>
            </div>

        @elseif($seller->status === 'rejected')
            {{-- Rejected Status with Resubmit Option --}}
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <span class="display-1 text-danger">
                            <i class="fas fa-times-circle"></i>
                        </span>
                        <h3 class="fw-bold mt-3 text-danger">Registration Rejected</h3>
                        <div class="mb-3">
                            <span class="badge bg-danger fs-6 px-4 py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i> Rejected
                            </span>
                        </div>
                    </div>

                    @if($seller->rejection_reason)
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading fw-bold mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>Reason for Rejection:
                            </h6>
                            <p class="mb-0" style="white-space: pre-line;">{{ $seller->rejection_reason }}</p>
                        </div>
                    @endif

                    <div class="alert alert-warning mt-3" role="alert">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>How to proceed:</strong> Please review the rejection reason above, update the required information, and resubmit your application for re-review.
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('seller.verification.resubmit') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-redo me-2"></i> Resubmit Application
                        </a>
                        <a href="{{ route('seller.logout') }}" class="btn btn-outline-secondary"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        @elseif($seller->status === 'suspended')
            {{-- Suspended Status --}}
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <span class="display-1 text-dark">
                            <i class="fas fa-ban"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-3 text-dark">Account Suspended</h3>
                    <div class="mb-4">
                        <span class="badge bg-dark fs-6 px-4 py-2">
                            <i class="fas fa-ban me-1"></i> Suspended
                        </span>
                    </div>

                    @if($seller->suspension_reason)
                        <div class="alert alert-secondary text-start" role="alert">
                            <h6 class="alert-heading fw-bold mb-2">
                                <i class="fas fa-info-circle me-2"></i>Suspension Reason:
                            </h6>
                            <p class="mb-0" style="white-space: pre-line;">{{ $seller->suspension_reason }}</p>
                        </div>
                    @else
                        <p class="text-muted mb-4">
                            Your seller account has been suspended. Please contact the admin for more information.
                        </p>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('seller.logout') }}" class="btn btn-outline-secondary"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection