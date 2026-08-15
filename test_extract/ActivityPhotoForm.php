<?php

namespace App\Filament\Resources\ActivityPhotos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ActivityPhotoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->image()
                    ->saveUploadedFileUsing(function (\Illuminate\Http\UploadedFile $file): string {
                        $filename = $file->getClientOriginalName();
                        $path = 'activity-photos/' . $filename;
                        \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                        return $path;
                    })
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
