<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
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
                ->headerActions([
                    Action::make('copyCatalogLink')
                        ->label('Copy Link')
                        ->icon('heroicon-o-link')
                        ->color('info')
                        ->action(function () {
                            // You can optionally log or do something here
                            Notification::make()
                            ->title('Link copied!')
                            ->success()
                            ->send();
                        })
                        ->extraAttributes([
                            'x-on:click.prevent' => "
                                navigator.clipboard.writeText(window.location.href).then(() => {
                                    \$wire.mountAction('copyCatalogLink')
                                })
                            ",
                        ]),
                Action::make('showQr')
                    ->label('Show QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->modalHeading('Public Catalog QR Code')
                    ->modalContent(fn () => view('filament.components.catalog-qr-modal', [
                        'link' => url('/admin/products'),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
            ]);
    }
}
