<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;

class LatestInquiries extends BaseWidget
{
    protected int | string | array $columnSpan = 'full'; // full width widget

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inquiry::query()->latest()->limit(10) // fetch latest 10 inquiries
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('mobile')
                    ->label('Mobile')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn (Inquiry $record) => url('admin/inquiries'));
    }
}
