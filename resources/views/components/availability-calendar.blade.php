@php
    $currentMonth = now()->month - 1; // JS için 0 tabanlı
    $currentYear = now()->year;
@endphp
<div class="availability-calendar-container">
    <div class="availability-calendar" 
         id="availability-calendar" 
         data-villa-slug="{{ $villa->slug }}" 
         data-month="{{ $currentMonth }}" 
         data-year="{{ $currentYear }}">
        
        <!-- Calendar Header -->
        <div class="calendar-header">
            <button type="button" class="calendar-nav-btn" id="prev-month">
                <i class="fas fa-chevron-left"></i>
            </button>
            <h4 class="calendar-month-year" id="calendar-month-year"></h4>
            <button type="button" class="calendar-nav-btn" id="next-month">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <!-- Calendar Table -->
        <div class="calendar-table-wrapper">
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th class="calendar-day-header">Pzt</th>
                        <th class="calendar-day-header">Sal</th>
                        <th class="calendar-day-header">Çar</th>
                        <th class="calendar-day-header">Per</th>
                        <th class="calendar-day-header">Cum</th>
                        <th class="calendar-day-header">Cmt</th>
                        <th class="calendar-day-header">Paz</th>
                    </tr>
                </thead>
                <tbody id="calendar-days"></tbody>
            </table>
        </div>
        
        <!-- Calendar Legend -->
        <div class="calendar-legend">
            <div class="legend-item">
                <span class="legend-box legend-past"></span>
                <span class="legend-text">Geçmiş</span>
            </div>
            <div class="legend-item">
                <span class="legend-box legend-booked"></span>
                <span class="legend-text">Dolu</span>
            </div>
            <div class="legend-item">
                <span class="legend-box legend-available"></span>
                <span class="legend-text">Müsait</span>
            </div>
            <div class="legend-item">
                <span class="legend-box legend-today"></span>
                <span class="legend-text">Bugün</span>
            </div>
        </div>
    </div>
</div>
