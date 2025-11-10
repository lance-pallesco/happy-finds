<?php

namespace App\Filament\Public\Resources\Products\Schemas;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $components = [
            Section::make('Product Images')
                ->description('Preview of uploaded product images.')
                ->schema([
                    ViewEntry::make('images')
                        ->view('filament.infolists.components.product-gallery')
                        ->columnSpanFull(),
                    Action::make('contactSeller')
                    ->label('Contact Seller')
                    ->icon('heroicon-s-device-phone-mobile')
                    ->button()
                    ->color('primary')
                    ->modalHeading('Contact the Seller')
                    ->modalDescription('Here are the available contact channels you can use to reach the seller.')
                    ->modalWidth('lg')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                     ->modalContent(function () {
                        $admin = User::with('socialMediaDetail')->first();
                        return view('filament.components.contact-seller', [
                            'contact' => $admin?->socialMediaDetail,
                        ]);
                    }),
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
        ];

            // Fetch the admin (seller) contact info
            $admin = User::with('socialMediaDetail')->first();

            if ($admin && $admin->socialMediaDetail) {
                $contact = $admin->socialMediaDetail;

                $components[] = Section::make('Interested in this product?')
                    ->description('Get in touch with us for inquiries, availability, and order assistance. We’re happy to help you find the perfect product for your needs.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('contact_phone')
                                ->label('Phone')
                                ->default($contact->phone ?? 'N/A')
                                ->icon('heroicon-o-phone')
                                ->copyable(),

                            TextEntry::make('contact_whatsapp')
                                ->label('WhatsApp')
                                ->default($contact->whatsapp ?? 'N/A')
                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                ->copyable(),

                            TextEntry::make('contact_viber')
                                ->label('Viber')
                                ->default($contact->viber ?? 'N/A')
                                ->icon('heroicon-o-device-phone-mobile')
                                ->copyable(),

                            TextEntry::make('contact_instagram')
                                ->label('Instagram')
                                ->default($contact->instagram ?? 'N/A')
                                ->icon('heroicon-o-at-symbol')
                                ->url(fn ($state) => $state ? "https://instagram.com/{$state}" : null, true),
                        ]),
                    ])
                    ->columns(2);
            }
        return $schema->components($components);
    }
}
