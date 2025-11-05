<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Tapp\FilamentSocialShare\Actions\SocialShareAction;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Images')
                    ->description('Preview of uploaded product images.')
                    ->schema([
                        ViewEntry::make('images')
                            ->view('filament.infolists.components.product-gallery')
                            ->columnSpanFull()
                    ]),
                Section::make('Product Information')
                    ->description('Essential details about this product.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('name')
                                ->label('Product Name')
                                ->weight('bold')
                                ->size('lg'),

                            TextEntry::make('price')
                                ->label('Price')
                                ->weight('medium')
                                ->size('lg')
                                ->money('PHP', true),

                            TextEntry::make('category')
                                ->label('Category')
                                ->placeholder('—')
                                ->icon('heroicon-o-tag'),

                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->formatStateUsing(fn (string $state): string => match ($state) {
                                    'active', 'available' => 'Available',
                                    'inactive' => 'Inactive',
                                    'out_of_stock' => 'Out of Stock',
                                    'archived' => 'Archived',
                                    default => ucfirst($state),
                                })
                                ->color(fn (string $state): string => match ($state) {
                                    'available' => 'success',
                                    'active' => 'success',
                                    'out_of_stock' => 'danger',
                                    'inactive' => 'warning',
                                    'archived' => 'gray',
                                    default => 'secondary',
                                }),
                        ]),

                        TextEntry::make('description')
                            ->label('Description')
                            ->markdown()
                            ->alignJustify()
                            ->columnSpanFull()
                            ->placeholder('No description provided.'),
                    ]),
                    Section::make('Product Information')
                    ->description('Essential details about this product.')
                    ->schema([
                        SocialShareAction::make()
                            ->label('Share this product')
                            ->facebook()
                            ->email(),
                    ]) 
                    ->columns(1)
            ]);
    }
}
