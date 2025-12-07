<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParcelResource\Pages;
use App\Filament\Resources\ParcelResource\RelationManagers;
use App\Models\Parcel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Actions\Action;


class ParcelResource extends Resource
{
    protected static ?string $model = Parcel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tracking_no')
                ->label('Tracking Number')
                ->required()
                ->extraAttributes([
                    'id' => 'tracking_number_input', // penting untuk JS
                    'autocomplete' => 'off',
                ])
                
                ->suffixAction(function () {
                return Action::make('scan')
                ->icon('heroicon-s-qr-code')
                ->extraAttributes([
                'onclick' => "startBarcodeScanner('tracking_number_input')"
            ]);
    }),
                
                TextInput::make('customer_name')
                ->label('Customer Name')
                ->required(),

                //TextInput::make('tracking_no')
                //->label('Tracking Number')
                //->required()
                //->unique(ignoreRecord: true),

                Select::make('storage_no')
                ->label('Storage No.')
                ->options([
                    '1'   => '1',
                    '2'    => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ]),

                DatePicker::make('delivery_date')
                ->label('Delivery Date')
                ->required(),

                DatePicker::make('pickup_date')
                ->label('Pickup Date'),

                Select::make('status')
                ->label('Parcel Status')
                ->options([
                    'pending'   => 'Pending / Processing',
                    'ready'    => 'Ready for Collect',
                    'delivered' => 'Delivered',
                ])
                ->required()
                ->default('pending'),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')->searchable(),
                TextColumn::make('tracking_no')->searchable(),
                TextColumn::make('storage_no'),
                TextColumn::make('delivery_date')->date(),
                TextColumn::make('pickup_date')->date(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'ready',
                        'success' => 'delivered',
                    ])
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'pending'   => 'Pending / Processing',
                    'ready'    => 'Ready for Collect',
                    'delivered' => 'Delivery',
                ]),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParcels::route('/'),
            'create' => Pages\CreateParcel::route('/create'),
            'edit' => Pages\EditParcel::route('/{record}/edit'),
        ];
    }
}
