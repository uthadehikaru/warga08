<?php

namespace App\Livewire;

use App\Models\Jumantik;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class JumantikForm extends Component
{
    use WithFileUploads;

    public $step = 1;

    #[Validate('image|max:15024')]
    public $photo;

    public $form = [];

    public function mount()
    {
        $this->form = [
            'rt' => '',
            'name' => '',
            'phone' => '',
            'address' => '',
            'has_jentik' => '',
        ];
    }

    private function valid()
    {
        $params = [
            'form.rt' => 'required|numeric',
            'form.name' => 'required|min:3|max:255',
            'form.phone' => 'required|numeric',
            'form.address' => 'required|min:3|max:255',
            'form.has_jentik' => 'required|in:ya,tidak',
        ];

        if ($this->step >= 1) {
            $params['photo'] = 'required|image|max:15024';
        }

        return $this->validate($params);
    }

    public function previous()
    {
        $this->resetErrorBag();
        $this->step--;
    }

    public function next()
    {
        $this->valid();
        $this->resetErrorBag();
        $this->step++;
    }

    public function submit()
    {
        $data = $this->valid();
        $jumantik = $data['form'];
        $jumantik['has_jentik'] = $jumantik['has_jentik'] === 'ya';
        $jumantik['photo'] = $this->photo->store('jumantik', 'public');

        $jumantik = Jumantik::create($jumantik);
        $this->redirect(route('jumantik.show', $jumantik->id));
    }

    public function render()
    {
        $data['rt'] = User::rt()->orderBy('rt')->get();

        return view('livewire.jumantik.form', $data)
            ->extends('layouts.web');
    }
}
