<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\HealthHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __invoke($type)
    {
        $csvFileName = 'laporan-' . $type . '.csv';
        $csvPath = public_path($csvFileName);
        
        // Create CSV file
        $file = fopen($csvPath, 'w');

        // Get all health histories grouped by month and year
        $healthHistories = HealthHistory::where('type', $type)
            ->oldest('check_date')
            ->get();
        
        // Add headers
        fputcsv($file, ['month_year', 'target_6_14', 'target_15_18', 'present_6_14', 'present_15_18', 'not_present_6_14', 'not_present_15_18']);

        $data = [];

        $users = User::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 6 AND 18')->get();
        $target_6_14 = 0;
        $target_15_18 = 0;
        foreach($users as $user){
            if($user->age >= 6 && $user->age <= 14){
                $target_6_14++;
            }else{
                $target_15_18++;
            }
        }
        // dd($healthHistories->toArray());
        $row = [
            'target_6_14' => 0,
            'target_15_18' => 0,
            'present_6_14' => 0,
            'present_15_18' => 0,
            'not_present_6_14' => 0,
            'not_present_15_18' => 0,
            'imt_sangat_kurus' => 0,
            'imt_kurus' => 0,
            'imt_normal' => 0,
            'imt_gemuk' => 0,
            'imt_obesitas' => 0,
        ];
        $monthYear = null;
        foreach ($healthHistories as $record) {
            if($record->check_date->format('Y-m') != $monthYear){
                $row['target_6_14'] = $target_6_14;
                $row['target_15_18'] = $target_15_18;   
                $row['present_6_14'] = 0;
                $row['present_15_18'] = 0;
                $row['not_present_6_14'] = 0;
                $row['not_present_15_18'] = 0;
                $row['imt_sangat_kurus'] = 0;
                $row['imt_kurus'] = 0;
                $row['imt_normal'] = 0;
                $row['imt_gemuk'] = 0;
                $row['imt_obesitas'] = 0;
                $monthYear = $record->check_date->format('Y-m');
            }

            if($record->age >= 6 && $record->age <= 14){
                $row['present_6_14']++;
            }else{
                $row['present_15_18']++;
            }

            if($record->imt == 'sk'){
                $row['imt_sangat_kurus']++;
            }elseif($record->imt == 'k'){
                $row['imt_kurus']++;
            }elseif($record->imt == 'n'){
                $row['imt_normal']++;
            }elseif($record->imt == 'g'){
                $row['imt_gemuk']++;
            }elseif($record->imt == 'o'){
                $row['imt_obesitas']++;
            }

            $row['not_present_6_14'] = $target_6_14 - $row['present_6_14'];
            $row['not_present_15_18'] = $target_15_18 - $row['present_15_18'];
            $data[$monthYear] = $row;
        }
        // dd($data);

        foreach($data as $key => $value){
            fputcsv($file, [
                $key,
                $value['target_6_14'],
                $value['target_15_18'], 
                $value['present_6_14'],
                $value['present_15_18'],
                $value['not_present_6_14'],
                $value['not_present_15_18'],
                $value['imt_sangat_kurus'],
                $value['imt_kurus'],
                $value['imt_normal'],
                $value['imt_gemuk'],
                $value['imt_obesitas']
                ]);
        }
        
        fclose($file);
        
        // Return CSV download response
        return response()->download($csvPath)->deleteFileAfterSend(true);
    }
} 