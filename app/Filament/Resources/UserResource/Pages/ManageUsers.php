<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
                    $count = 0;
                    $total = 0;
                    
                    if (($handle = fopen($file, "r")) !== false) {
                        // Skip the header row
                        fgetcsv($handle);
                        
                        while (($row = fgetcsv($handle)) !== false) {
                            try {
                                // Map CSV columns to array keys
                                $userData = [
                                    'rt' => $row[0] ?? null,
                                    'nik' => $row[1] ?? null,
                                    'name' => $row[2] ?? null,
                                    'gender' => isset($row[3]) && strtolower($row[3])=="p" ? "w" : "p",
                                    'birth_place' => $row[4] ?? null,
                                    'birth_date' => $row[5] ? date('Y-m-d', strtotime($row[5])) : null,
                                    'religion' => $row[6] ?? null,
                                    'address' => $row[7] ?? null,
                                ];
                                
                                // Ensure required fields are present
                                if (empty($userData['nik'])) {
                                    continue; // Skip this row if no NIK
                                }
                                
                                // Set default password and role
                                $userData['password'] = Hash::make('password123'); // Default password
                                $userData['role'] = 'warga';
                                $userData['email'] = $userData['nik'].'@warga08.test';
                                
                                // Create or update user
                                \App\Models\User::updateOrCreate(
                                    ['nik' => $userData['nik']],
                                    $userData
                                );

                                $count++;
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                            }
                            $total++;
                        }
                        fclose($handle);
                        
                        // Delete the temporary file
                        unlink($file);
                        
                        Notification::make()
                            ->title($count.'/'.$total.' users imported successfully')
                            ->success()
                            ->send();
                    }
                })
        ];
    }
}
