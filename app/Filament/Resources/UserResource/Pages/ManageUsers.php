<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->color('success')
                ->form([
                    FileUpload::make('file')
                        ->required()
                        ->acceptedFileTypes(['text/csv'])
                        ->disk('public')
                        ->directory('import')
                        ->name('import-'.now()->timestamp.'.csv')
                        ->maxSize(1024)
                ])
                ->action(function (array $data) {
                    $file = storage_path('app/public/' . $data['file']);
                    
                    if (($handle = fopen($file, "r")) !== false) {
                        // Get headers from first row
                        $headers = fgetcsv($handle);
                        
                        // Convert headers to lowercase and trim
                        $headers = array_map(fn($header) => strtolower(trim($header)), $headers);
                        
                        while (($row = fgetcsv($handle)) !== false) {
                            $userData = array_combine($headers, $row);
                            
                            // Ensure required fields are present
                            if (!isset($userData['nik'])) {
                                continue; // Skip this row if no email
                            }
                            
                            // Hash password if present
                            if (isset($userData['password'])) {
                                $userData['password'] = Hash::make($userData['password']);
                            } else {
                                $userData['password'] = Hash::make('password123'); // Default password
                            }
                            $userData['role'] = 'warga';
                            $userData['email'] = $userData['nik'].'@warga08.test';
                            
                            // Create or update user
                            \App\Models\User::updateOrCreate(
                                ['nik' => $userData['nik']],
                                $userData
                            );
                        }
                        fclose($handle);
                        
                        // Delete the temporary file
                        unlink($file);
                        
                        Notification::make()
                            ->title('Users imported successfully')
                            ->success()
                            ->send();
                    }
                })
        ];
    }
}
