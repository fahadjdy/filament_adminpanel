<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Category;
use App\Models\Product;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Category', Category::count())
                ->description('All category in the system')
                ->descriptionIcon('heroicon-o-cube')
                ->color('success')
                ->extraAttributes(['class' => 'bg-green-600 text-white rounded-lg shadow-md p-4', 'style' => 'background-color: #e5e5e;'])
                ->url(route('filament.admin.resources.categories.index')),


            Stat::make('Total Products', Product::count())
            ->description('All products in the system')
            ->descriptionIcon('heroicon-o-cube')
            ->color('success')
            ->extraAttributes(['class' => 'bg-blue-600 text-white rounded-lg shadow-md p-4', 'style' => 'background-color: #e5e5e;'])
            ->url(route('filament.admin.resources.products.index')),
        ];
    }
}
