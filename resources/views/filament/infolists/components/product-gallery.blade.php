@vite(['resources/js/app.js'])
<div 
    x-data 
    x-init="
        if (typeof Swiper !== 'undefined') {
            new Swiper($el.querySelector('.swiper'), {
                loop: true,
                spaceBetween: 20,
                slidesPerView: 1,
                navigation: {
                    nextEl: $el.querySelector('.swiper-button-next'),
                    prevEl: $el.querySelector('.swiper-button-prev'),
                },
                pagination: {
                    el: $el.querySelector('.swiper-pagination'),
                    clickable: true,
                },
            });
        } else {
            console.error('Swiper not loaded — check JS import.');
        }
    "
    class="w-full max-w-4xl mx-auto relative"
>
    <div class="swiper">
        <div class="swiper-wrapper">
            @forelse ($getState() as $image)
                <div class="swiper-slide">
                    <img 
                        src="{{ asset('storage/' . $image['path']) }}" 
                        alt="Product Image"
                        class="w-full h-[400px] object-cover rounded-2xl shadow-md"
                    />
                </div>
            @empty
                <div class="swiper-slide flex items-center justify-center h-[400px] text-gray-400">
                    No images uploaded yet.
                </div>
            @endforelse
        </div>

        <!-- Navigation -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- Pagination -->
        <div class="swiper-pagination mt-2"></div>
    </div>
</div>
