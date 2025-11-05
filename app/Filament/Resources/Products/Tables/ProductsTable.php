<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Flex;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ViewColumn::make('image')
                        ->alignCenter()
                        ->view('filament.infolists.components.product-card'),
                ]),
            ])  
            ->paginated(false)
            ->contentGrid([
                'md' => 2,
                'xl' => 5,
            ])
            ->toolbarActions([
                Action::make('copyCatalogLink')
                    ->label('Copy Page Link')
                    ->icon('heroicon-o-link')
                    ->color('primary')
                    ->extraAttributes([
                        'x-data' => '{}',
                        'x-on:click' => "
                            const currentUrl = window.location.href;
                            navigator.clipboard.writeText(currentUrl);
                            \$toast.open({ message: 'Link copied to clipboard!', type: 'success' });
                        ",
                    ]),
                    Action::make('showQr')
                        ->label('Show Catalog QR')
                        ->icon('heroicon-o-qr-code')
                        ->color('success')
                        ->modalHeading('Public Catalog QR Code')
                        ->modalContent(fn () => view('filament.components.catalog-qr-modal', [
                            'link' => url('/catalog'),
                        ])),
            ]);
    }
}
