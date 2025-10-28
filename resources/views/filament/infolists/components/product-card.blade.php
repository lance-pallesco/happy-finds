<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</head>
@php
    $record = $getRecord();
    $firstImage = optional($record->images->first())->path;
    $image = $firstImage ? asset('storage/' . $firstImage) : asset('images/placeholder.png');

    $price = (float) ($record->price ?? 0);
    $sale = $record->sale_price ?? null;
    $discountPct = ($sale && $price) ? round((1 - ($sale / $price)) * 100) : null;
    $inStock = (optional($record)->stock ?? 0) > 0;
@endphp

<div class="relative max-w-md rounded-xl bg-gradient-to-r from-neutral-600 to-violet-300 pt-0 shadow-lg">
  <div class="flex h-60 items-center justify-center">
    <img
      src={{ $image }}
      alt="Product Image"
      class="w-48 h-48 object-contain"
    />
  </div>

  <button
    x-data="{ liked: false }"
    @click="liked = !liked"
    class="absolute top-4 right-4 rounded-full bg-primary/10 hover:bg-primary/20 p-2"
  >
    <svg x-bind:class="liked ? 'fill-red-500 stroke-red-500' : 'stroke-white'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-8.682a4.5 4.5 0 010-6.364z" />
    </svg>
  </button>

  <div class="p-4 bg-white rounded-b-xl">
    <h2 class="font-bold text-lg">{{ $record->name }}</h2>
    <div class="flex gap-2 text-sm mt-1">
      <span class="border px-2 py-0.5 rounded">EU38</span>
      <span class="border px-2 py-0.5 rounded">Black and White</span>
    </div>
    <p class="mt-2 text-gray-600">
      Crossing hardwood comfort with off-court flair. '80s-Inspired construction, bold details and nothin'-but-net style.
    </p>

    <div class="flex justify-between items-center mt-4">
      <div>
        <p class="text-sm font-medium uppercase">Price</p>
        <p class="text-xl font-semibold">$69.99</p>
      </div>
      <x-filament::button size="lg">Add to Cart</x-filament::button>
    </div>
  </div>
</div>
</html>
