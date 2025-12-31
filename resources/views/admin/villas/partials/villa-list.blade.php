@foreach($villas as $villa)
<tr>
    <td>
        <span class="badge badge-primary">#{{ $villa->id }}</span>
    </td>
    <td>
        <img src="{{ $villa->primaryImage->url }}" 
             alt="{{ $villa->title }}" 
             class="img-thumbnail"
             style="width: 80px; height: 60px; object-fit: cover;">
    </td>
    <td>
        <div>
            <a href="{{ route('villas.show', $villa->slug) }}" class="text-primary font-weight-bold" target="_blank">
                {{ $villa->title }}
                <i class="fas fa-external-link-alt fa-xs ml-1"></i>
            </a>
            <br>
            <small class="text-muted">
                <i class="fas fa-map-marker-alt"></i> {{ $villa->location->name }}
            </small>
        </div>
    </td>
    <td>
        <div>
            <span class="font-weight-bold">{{ number_format($villa->price_per_night, 2) }} ₺</span>
            <br>
            <small class="text-muted">Gecelik</small>
        </div>
    </td>
    <td>
        <div>
            <i class="fas fa-bed"></i> {{ $villa->bedrooms }} Yatak Odası
            <br>
            <i class="fas fa-users"></i> {{ $villa->capacity }} Kişilik
        </div>
    </td>
    <td class="text-center">
        <form action="{{ route('admin.villas.status', $villa->slug) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input status-toggle" 
                       id="status_{{ $villa->id }}" 
                       name="is_active" 
                       value="1" 
                       {{ $villa->is_active ? 'checked' : '' }}>
                <label class="custom-control-label" for="status_{{ $villa->id }}">
                    {{ $villa->is_active ? 'Aktif' : 'Pasif' }}
                </label>
            </div>
        </form>
    </td>
    <td class="text-center">
        <form action="{{ route('admin.villas.featured', $villa->slug) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" 
                    class="btn btn-sm btn-star {{ $villa->is_featured ? 'btn-warning' : 'btn-outline-warning' }}"
                    title="{{ $villa->is_featured ? 'Öne çıkarmaktan çıkar' : 'Öne çıkar' }}"
                    style="min-width: 40px;">
                <i class="fas fa-star {{ $villa->is_featured ? 'text-white' : '' }}"></i>
            </button>
        </form>
        @if($villa->is_featured)
            <small class="d-block text-warning mt-1 status-label">
                <i class="fas fa-crown"></i> Öne Çıkan
            </small>
        @endif
    </td>
    <td>
        <div class="btn-group">
            <a href="{{ route('admin.villas.edit', $villa->slug) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.villas.destroy', $villa->slug) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bu villayı silmek istediğinize emin misiniz?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            <a href="{{ route('admin.villas.show', $villa->slug) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach 