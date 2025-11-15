<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
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
                                ->size('lg')
                                ->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),

                            TextEntry::make('price')
                                ->label('Price')
                                ->weight('medium')
                                ->size('lg')
                                ->money('PHP', true),

                            TextEntry::make('category')
                                ->label('Category')
                                ->placeholder('—')
                                ->icon('heroicon-o-tag')
                                ->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),

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
                            ->placeholder('No description provided.')
                            ->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),

                        Action::make('copyPublicLink')
                            ->label('Copy Public Link')
                            ->icon('heroicon-o-link')
                            ->color('primary')
                            ->button()
                            ->action(function () {
                                Notification::make()
                                    ->title('Link copied!')
                                    ->body('Public product link has been copied to your clipboard.')
                                    ->success()
                                    ->send();
                            })
                            ->extraAttributes(function ($record) {
                                $publicUrl = url("/products/{$record->id}");

                                return [
                                    'x-data' => '{}',
                                    'x-on:click.prevent' => "
                                        navigator.clipboard.writeText('{$publicUrl}');
                                    ",
                                ];
                            }),
                    ]),
            ]);
    }
}
