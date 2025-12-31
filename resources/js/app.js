import './bootstrap';
import 'bootstrap';

// Initialize third-party libraries if needed
// For example: import 'alpinejs';

// Main JS functionality
document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
        });
    }
    
    // Booking form
    initBookingForm();
    
    // Villa image gallery
    initVillaGallery();
    
    // Filter form for villa listings
    initVillaFilters();
    
    // Admin dashboard charts
    initDashboardCharts();

    // Initialize all tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Initialize all popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

    // Favorite villa functionality
    const favoriteButtons = document.querySelectorAll('.favorite-button');
    
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const villaId = this.dataset.villaId;
            const icon = this.querySelector('i');
            
            fetch(`/villas/${villaId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.classList.add('text-danger');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.remove('text-danger');
                    icon.classList.add('far');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Date range picker for booking
    const checkInInput = document.querySelector('#check_in');
    const checkOutInput = document.querySelector('#check_out');
    
    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const minCheckOutDate = new Date(checkInDate);
            minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);
            
            checkOutInput.min = minCheckOutDate.toISOString().split('T')[0];
            
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = minCheckOutDate.toISOString().split('T')[0];
            }
        });
    }

    // Image gallery
    const mainImage = document.querySelector('.villa-gallery-main img');
    const thumbnails = document.querySelectorAll('.villa-gallery-thumbs img');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.dataset.full;
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.animate-fade-in');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });
    
    animateElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        observer.observe(element);
    });

    initAvailabilityCalendar();
});

function initBookingForm() {
    const bookingForm = document.getElementById('booking-form');
    if (!bookingForm) return;
    
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const guestsInput = document.getElementById('guests');
    const priceElement = document.getElementById('total-price');
    const pricePerNight = parseInt(bookingForm.dataset.pricePerNight || 0);
    
    if (checkInInput && checkOutInput) {
        // Set min dates
        const today = new Date();
        checkInInput.min = formatDate(today);
        
        checkInInput.addEventListener('change', () => {
            if (checkInInput.value) {
                const nextDay = new Date(checkInInput.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutInput.min = formatDate(nextDay);
                
                // Reset checkout if it's before check-in
                if (checkOutInput.value && new Date(checkOutInput.value) <= new Date(checkInInput.value)) {
                    checkOutInput.value = formatDate(nextDay);
                }
                
                // Calculate price
                calculatePrice();
            }
        });
        
        checkOutInput.addEventListener('change', () => {
            // Calculate price
            calculatePrice();
        });
        
        if (guestsInput) {
            guestsInput.addEventListener('change', () => {
                calculatePrice();
            });
        }
    }
    
    function calculatePrice() {
        if (!checkInInput.value || !checkOutInput.value || !priceElement) return;
        
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);
        
        const nights = Math.round((checkOut - checkIn) / (1000 * 60 * 60 * 24));
        
        if (nights > 0) {
            const totalPrice = nights * pricePerNight;
            priceElement.textContent = new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(totalPrice);
            
            // Update hidden total price input if exists
            const totalPriceInput = document.getElementById('total_price');
            if (totalPriceInput) {
                totalPriceInput.value = totalPrice;
            }
        }
    }
}

function initVillaGallery() {
    const galleryThumbs = document.querySelectorAll('.gallery-thumb');
    const mainImage = document.querySelector('.gallery-main-image');
    
    if (!galleryThumbs.length || !mainImage) return;
    
    galleryThumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            // Update main image
            mainImage.src = thumb.src;
            
            // Update active state
            galleryThumbs.forEach(t => t.classList.remove('ring-2', 'ring-indigo-500'));
            thumb.classList.add('ring-2', 'ring-indigo-500');
        });
    });
}

function initVillaFilters() {
    const filterForm = document.getElementById('villa-filter-form');
    if (!filterForm) return;
    
    // Range sliders for price
    const priceMin = document.getElementById('price_min');
    const priceMax = document.getElementById('price_max');
    const priceMinValue = document.getElementById('price_min_value');
    const priceMaxValue = document.getElementById('price_max_value');
    
    if (priceMin && priceMax && priceMinValue && priceMaxValue) {
        priceMin.addEventListener('input', () => {
            // Ensure min price doesn't exceed max price
            if (parseInt(priceMin.value) > parseInt(priceMax.value)) {
                priceMin.value = priceMax.value;
            }
            
            priceMinValue.textContent = new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(priceMin.value);
        });
        
        priceMax.addEventListener('input', () => {
            // Ensure max price isn't less than min price
            if (parseInt(priceMax.value) < parseInt(priceMin.value)) {
                priceMax.value = priceMin.value;
            }
            
            priceMaxValue.textContent = new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(priceMax.value);
        });
    }
    
    // Auto-submit on select changes
    const autoSubmitSelects = document.querySelectorAll('.auto-submit');
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', () => {
            filterForm.submit();
        });
    });
    
    // Clear filters button
    const clearFiltersBtn = document.getElementById('clear-filters');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Reset all form inputs
            const inputs = filterForm.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else if (input.type === 'range') {
                    input.value = input.defaultValue;
                    // Trigger input event to update displayed values
                    const event = new Event('input');
                    input.dispatchEvent(event);
                } else {
                    input.value = '';
                }
            });
            
            // Submit the form
            filterForm.submit();
        });
    }
}

function initDashboardCharts() {
    // Check if we're on a page with charts
    const bookingsChart = document.getElementById('bookings-chart');
    const revenueChart = document.getElementById('revenue-chart');
    const locationsChart = document.getElementById('locations-chart');
    
    if (!bookingsChart && !revenueChart && !locationsChart) return;
    
    // We're using a simple implementation since we don't have a charting library
    // In a real app, you might use Chart.js or another library
    
    // Bookings chart
    if (bookingsChart && bookingsChart.dataset.bookings) {
        try {
            const bookingsData = JSON.parse(bookingsChart.dataset.bookings);
            const monthNames = ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara'];
            
            let html = '<div class="flex h-64 items-end space-x-2">';
            
            // Find max value for scaling
            const maxBookings = Math.max(...Object.values(bookingsData));
            
            for (let i = 1; i <= 12; i++) {
                const value = bookingsData[i] || 0;
                const height = maxBookings > 0 ? Math.max(5, (value / maxBookings) * 100) : 5;
                
                html += `
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs mb-1">${value}</div>
                        <div class="w-full bg-indigo-500 rounded-t" style="height: ${height}%"></div>
                        <div class="text-xs mt-1">${monthNames[i-1]}</div>
                    </div>
                `;
            }
            
            html += '</div>';
            bookingsChart.innerHTML = html;
        } catch (error) {
            console.error('Error parsing bookings chart data:', error);
        }
    }
    
    // Revenue chart
    if (revenueChart && revenueChart.dataset.revenue) {
        try {
            const revenueData = JSON.parse(revenueChart.dataset.revenue);
            const monthNames = ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara'];
            
            let html = '<div class="flex h-64 items-end space-x-2">';
            
            // Find max value for scaling
            const maxRevenue = Math.max(...Object.values(revenueData));
            
            for (let i = 1; i <= 12; i++) {
                const value = revenueData[i] || 0;
                const height = maxRevenue > 0 ? Math.max(5, (value / maxRevenue) * 100) : 5;
                const formattedValue = new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY', maximumFractionDigits: 0 }).format(value);
                
                html += `
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-xs mb-1">${formattedValue}</div>
                        <div class="w-full bg-purple-500 rounded-t" style="height: ${height}%"></div>
                        <div class="text-xs mt-1">${monthNames[i-1]}</div>
                    </div>
                `;
            }
            
            html += '</div>';
            revenueChart.innerHTML = html;
        } catch (error) {
            console.error('Error parsing revenue chart data:', error);
        }
    }
    
    // Locations chart
    if (locationsChart && locationsChart.dataset.locations) {
        try {
            const locationsData = JSON.parse(locationsChart.dataset.locations);
            
            let html = '';
            
            locationsData.forEach(location => {
                html += `
                    <div class="mb-4">
                        <div class="flex justify-between mb-1">
                            <span>${location.name}</span>
                            <span>${location.count} villa</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-pink-500 h-2.5 rounded-full" style="width: ${location.percentage}%"></div>
                        </div>
                    </div>
                `;
            });
            
            locationsChart.innerHTML = html;
        } catch (error) {
            console.error('Error parsing locations chart data:', error);
        }
    }
}

function initAvailabilityCalendar() {
    const calendar = document.getElementById('availability-calendar');
    if (!calendar) return;

    let month = parseInt(calendar.dataset.month);
    let year = parseInt(calendar.dataset.year);
    const villaSlug = calendar.dataset.villaSlug;

    function loadCalendar(m, y) {
        // Ayın ilk ve son gününü bul
        const startDate = `${y}-${String(m+1).padStart(2, '0')}-01`;
        const endDate = new Date(y, m + 1, 0);
        const endDateStr = `${y}-${String(m+1).padStart(2, '0')}-${String(endDate.getDate()).padStart(2, '0')}`;
        fetch(`/villas/${villaSlug}/availability?start_date=${startDate}&end_date=${endDateStr}`)
            .then(res => res.json())
            .then(data => {
                renderCalendar(calendar, m, y, data.bookedDates);
            });
    }

    function renderCalendar(calendar, month, year, bookedDates) {
        const monthNames = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
        calendar.querySelector('#calendar-month-year').textContent = `${monthNames[month]} ${year}`;
        const tbody = calendar.querySelector('#calendar-days');
        tbody.innerHTML = '';
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const today = new Date();
        let row = document.createElement('tr');
        let dayOfWeek = (firstDay.getDay() + 6) % 7; // Pazartesi=0
        for (let i = 0; i < dayOfWeek; i++) {
            row.appendChild(document.createElement('td'));
        }
        for (let day = 1; day <= lastDay.getDate(); day++) {
            if (row.children.length === 7) {
                tbody.appendChild(row);
                row = document.createElement('tr');
            }
            const cell = document.createElement('td');
            const dateStr = `${year}-${String(month+1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            cell.textContent = day;
            // Geçmiş gün
            const isPast = new Date(year, month, day) < new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
            if (isToday) {
                cell.classList.add('bg-primary', 'text-white');
            } else if (isPast) {
                cell.classList.add('bg-secondary', 'text-white');
            } else if (bookedDates.includes(dateStr)) {
                cell.classList.add('bg-danger', 'text-white');
            } else {
                cell.classList.add('bg-success', 'text-white');
            }
            row.appendChild(cell);
        }
        if (row.children.length) tbody.appendChild(row);
    }

    // Ay değiştir
    calendar.querySelector('#prev-month').addEventListener('click', () => {
        month--;
        if (month < 0) {
            month = 11;
            year--;
        }
        loadCalendar(month, year);
    });
    calendar.querySelector('#next-month').addEventListener('click', () => {
        month++;
        if (month > 11) {
            month = 0;
            year++;
        }
        loadCalendar(month, year);
    });
    loadCalendar(month, year);
}
