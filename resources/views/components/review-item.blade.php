<div class="col-12 mb-4">
    <div class="border rounded p-4 bg-light">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=667eea&color=fff&size=50" 
                     alt="{{ $review->user->name }}" 
                     class="rounded-circle me-3" 
                     style="width: 50px; height: 50px;">
                <div>
                    <h6 class="mb-1">{{ $review->user->name }}</h6>
                    <small class="text-muted">
                        {{ $review->created_at->format('d.m.Y') }}
                        @if($review->booking)
                            • {{ $review->booking->nights }} gece konakladı
                        @endif
                    </small>
                </div>
            </div>
            <div class="text-end">
                {!! $review->star_rating !!}
            </div>
        </div>
        <p class="mb-0 text-dark">{{ $review->comment }}</p>
    </div>
</div> 