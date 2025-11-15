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
                                const currentUrl = window.location.href;
                                const publicUrl = currentUrl.replace('/admin', '');
                                navigator.clipboard.writeText(publicUrl).then(() => {
                                    \$wire.mountAction('copyCatalogLink')
                                })
                            ",
                        ]),
                Action::make('showQr')
                    ->label('Show QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->modalHeading('Public Catalog QR Code')
                    ->modalContent(fn () => view('filament.compeonents.catalog-qr-modal', [
                        'link' => url('/products'),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
            ]);
    }
}
