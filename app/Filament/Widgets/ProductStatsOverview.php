<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Total Products', Product::count())
                ->description('All products in catalog')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            
            Stat::make('Available', Product::where('status', 'available')->count())
                ->description('Ready for sale')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([3, 2, 4, 3, 5, 4, 6, 5]),
            
            Stat::make('Out of Stock', Product::where('status', 'out_of_stock')->count())
                ->description('Need restocking')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->chart([1, 2, 1, 3, 2, 1, 2, 3]),
            
            Stat::make('Inactive', Product::where('status', 'inactive')->count())
                ->description('Not currently listed')
                ->descriptionIcon('heroicon-m-pause-circle')
                ->color('warning')
                ->chart([2, 1, 2, 1, 3, 2, 1, 2]),
            
            Stat::make('Archived', Product::where('status', 'archived')->count())
                ->description('Archived products')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('gray')
                ->chart([1, 1, 0, 1, 1, 2, 1, 0]),
        ];
    }
}
