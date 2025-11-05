<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
@php
    $record = $getRecord();

    // Determine which image to use
    $primaryImage = $record->primaryImage?->path
        ?? ($record->images->count() ? $record->images->first()->path : null);

    $image = $primaryImage
        ? asset('storage/' . ltrim($primaryImage, '/'))
        : asset('images/placeholder.png');
    
    $isDark = filament()->hasDarkMode() && filament()->getTheme() === 'dark';
@endphp

<div class="relative max-w-md pt-0 group transition-all duration-300 hover:shadow-lg rounded-xl">
  <!-- Image wrapper -->
  <div class="relative overflow-hidden">
    <img
      class="w-full h-auto object-cover transition-transform duration-500 ease-in-out group-hover:scale-110"
      src="{{ $image }}"
      alt="Product Image"
    >
  </div>

  <!-- Card body -->
  <div class="p-4 md:p-5 dark:bg-gray-900 rounded-b-xl">
    <h3 class="text-lg font-bold ">
      {{ $record->name }}
    </h3>
    <p class="mt-1 mb-2 text-xs font-medium uppercase text-gray-500">
      {{ $record->category ?? '' }}
    </p>
    <p class="mt-1 text-gray-500 text-justify dark:text-neutral-400">
      {{ \Illuminate\Support\Str::limit(strip_tags($record->description), 100, '...') }}
    </p>
    <div class="mt-6">
      <div class="items-center gap-2 text-base font-semibold px-3 py-1 text-green-800 shadow-sm dark:bg-green-800 dark:text-green-100">
        <span class="uppercase text-xs font-bold text-green-700 dark:text-green-200">Price:</span>
        <span>₱{{ number_format($record->price ?? 0, 2) }}</span>
      </div>
    </div>
  </div>
</div>

</html>
