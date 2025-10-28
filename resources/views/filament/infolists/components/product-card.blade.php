@php
    $record = $getRecord();
    $firstImage = optional($record->images->first())->path;
    $image = $firstImage ? asset('storage/' . $firstImage) : asset('images/placeholder.png');

    $price = (float) ($record->price ?? 0);
    $sale = $record->sale_price ?? null;
    $discountPct = ($sale && $price) ? round((1 - ($sale / $price)) * 100) : null;
    $inStock = (optional($record)->stock ?? 0) > 0;
@endphp

<div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all border border-gray-100 overflow-hidden group focus-within:outline-none">
    {{-- Image / left column --}}
    <div class="w-full md:w-40 lg:w-48 flex-shrink-0 bg-gray-50 p-3 flex items-center justify-center">
        <img
            src="{{ $image }}"
            alt="{{ $record->name ?? 'Product image' }}"
            loading="lazy"
            class="w-full h-28 md:h-32 lg:h-36 object-contain transition-transform duration-300"
        >

        {{-- Discount badge --}}
        @if($discountPct)
            <span class="absolute md:relative top-3 left-3 text-xs font-semibold px-2 py-0.5 rounded-full bg-red-600 text-white">
                -{{ $discountPct }}%
            </span>
        @endif
    </div>

    {{-- Details / right column --}}
    <div class="p-3 md:p-4 flex-1 flex flex-col">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <h3 class="text-sm md:text-base font-semibold text-gray-900 mb-1 line-clamp-2">
                    {{ $record->name }}
                </h3>

                <p class="text-xs md:text-sm text-gray-500 mb-2 line-clamp-2">
                    {{ \Illuminate\Support\Str::limit($record->description ?? '', 80) }}
                </p>

                <div class="flex items-center gap-2">
                    @if($sale)
                        <div class="text-sm md:text-lg font-bold text-emerald-600">₱{{ number_format($sale, 2) }}</div>
                        <div class="text-xs md:text-sm text-gray-400 line-through">₱{{ number_format($price, 2) }}</div>
                    @else
                        <div class="text-sm md:text-lg font-bold text-emerald-600">₱{{ number_format($price, 2) }}</div>
                    @endif

                    {{-- Rating --}}
                    @if(isset($record->rating) && $record->rating)
                        <div class="flex items-center text-yellow-400 text-xs md:text-sm ml-2" title="Rating: {{ number_format($record->rating,1) }}">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($record->rating))
                                    <svg class="w-3 h-3 md:w-4 md:h-4 fill-current" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.953L10 0l2.949 5.957 6.561.953-4.755 4.635 1.123 6.545z"/></svg>
                                @elseif($i - $record->rating < 1)
                                    <svg class="w-3 h-3 md:w-4 md:h-4 fill-current" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.561-.953L10 0l2.949 5.957 6.561.953-4.755 4.635 1.123 6.545z" opacity="0.5"/></svg>
                                @else
                                    <svg class="w-3 h-3 md:w-4 md:h-4 stroke-current text-gray-300" fill="none" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @endif
                            @endfor
                            <span class="ml-1 text-xs text-gray-500">{{ number_format($record->rating, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Status badge --}}
            @if($record->status)
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ match($record->status) {
                        'available' => 'bg-green-600 text-white',
                        'out_of_stock' => 'bg-red-500 text-white',
                        'inactive' => 'bg-yellow-400 text-gray-900',
                        'archived' => 'bg-gray-400 text-white',
                        default => 'bg-gray-300 text-gray-800',
                    } }}">
                    {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                </span>
            @endif
        </div>

        <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
            <span>SKU: {{ $record->sku ?? '—' }}</span>
            <span class="{{ $inStock ? 'text-green-600' : 'text-red-500' }}">
                {{ $inStock ? 'In stock' : 'Out of stock' }}
            </span>
        </div>

        {{-- Actions: visible on all devices, stacked on mobile --}}
        <div class="mt-3 flex gap-2">
            <a
                href="#"
                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-white border border-gray-200 rounded-md text-sm text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                aria-label="Quick view {{ $record->name }}"
            >
                Quick view
            </a>

            <button
                type="button"
                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-emerald-600 text-sm rounded-md text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50"
                aria-label="Add {{ $record->name }} to cart"
                @if(! $inStock) disabled @endif
            >
                Add to cart
            </button>
        </div>
    </div>
</div>