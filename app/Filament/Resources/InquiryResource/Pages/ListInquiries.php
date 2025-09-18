<?php

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms;

class ListInquiries extends ListRecords
{
    protected static string $resource = InquiryResource::class;

    protected function getHeaderActions(): array
    {
       return [];
    }
}
