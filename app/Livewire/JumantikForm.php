<?php

namespace App\Livewire;

use App\Models\Jumantik;
use App\Models\User;
use App\Notifications\JumantikCreated;
use App\Services\ImageCompressor;
use Illuminate\Support\Facades\Storage;
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
            'latitude' => null,
            'longitude' => null,
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
            'form.latitude' => 'nullable|required_with:form.longitude|numeric|between:-90,90',
            'form.longitude' => 'nullable|required_with:form.latitude|numeric|between:-180,180',
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
        $jumantik['photo'] = $this->storePhoto();
        $jumantik['latitude'] = $this->coordinate($jumantik['latitude'] ?? null);
        $jumantik['longitude'] = $this->coordinate($jumantik['longitude'] ?? null);

        if ($jumantik['latitude'] === null || $jumantik['longitude'] === null) {
            $jumantik['latitude'] = null;
            $jumantik['longitude'] = null;
        }

        $jumantik = Jumantik::create($jumantik);

        $rt = User::rt()->where('rt', $jumantik->rt)->first();
        if ($rt) {
            $rt->notify(new JumantikCreated($jumantik));
        }

        $this->redirect(route('jumantik.show', $jumantik->id));
    }

    private function coordinate(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return round((float) $value, 7);
    }

    private function storePhoto(): string
    {
        $directory = 'jumantik';
        $path = $this->photo->store($directory, 'public');
        $compressed = (new ImageCompressor)->compress(Storage::disk('public')->path($path));

        return $directory.'/'.basename($compressed);
    }

    public function render()
    {
        $data['rt'] = User::rt()->orderBy('rt')->get();

        return view('livewire.jumantik.form', $data)
            ->extends('layouts.web');
    }
}
