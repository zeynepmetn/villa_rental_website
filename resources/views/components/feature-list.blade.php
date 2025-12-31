<ul class="list-unstyled row">
    @foreach($features as $feature)
    <li class="col-md-4 col-sm-6 mb-3">
        <div class="d-flex align-items-center">
            <div class="feature-icon me-2">
                <i class="fas fa-{{ $feature->icon }} text-primary"></i>
            </div>
            <div class="feature-text">
                {{ $feature->name }}
            </div>
        </div>
    </li>
    @endforeach
</ul>
