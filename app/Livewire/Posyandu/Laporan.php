<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthHistory;
use App\Models\User;
use Livewire\Component;

class Laporan extends Component
{
    public $type;
    public $startDate;
    public $endDate;
    public $data = [];

    public function mount($type)
    {
        $this->type = $type;
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function search()
    {
        $healthHistories = HealthHistory::where('type', $this->type)
            ->whereBetween('check_date', [$this->startDate, $this->endDate])
            ->oldest('check_date')
            ->get();

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

        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.posyandu.laporan')
        ->extends('layouts.posyandu')
        ->section('content');
    }
}
