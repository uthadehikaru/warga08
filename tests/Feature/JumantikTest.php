<?php

use App\Livewire\JumantikForm;
use App\Models\Jumantik;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(UserSeeder::class);
    Storage::fake('public');
});

it('shows jumantik on the public menu', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Jumantik')
        ->assertSee(route('jumantik.create'), false);
});

it('shows the jumantik form', function () {
    $this->get(route('jumantik.create'))
        ->assertOk()
        ->assertSee('Form Jumantik')
        ->assertSee('NIK')
        ->assertSee('No. Telepon')
        ->assertSee('Alamat')
        ->assertSee('Foto');
});

it('lets a resident submit jumantik information', function () {
    $photo = UploadedFile::fake()->image('jentik.jpg');

    Livewire::test(JumantikForm::class)
        ->set('form.rt', 1)
        ->set('form.nik', '3174010101010001')
        ->set('form.name', 'Siti Aminah')
        ->set('form.phone', '081234567890')
        ->set('form.address', 'Jl. Haji Kelik No. 10')
        ->set('photo', $photo)
        ->call('next')
        ->assertHasNoErrors()
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(Jumantik::count())->toBe(1);

    $jumantik = Jumantik::first();
    expect($jumantik->nik)->toBe('3174010101010001')
        ->and($jumantik->name)->toBe('Siti Aminah')
        ->and($jumantik->phone)->toBe('081234567890')
        ->and($jumantik->address)->toBe('Jl. Haji Kelik No. 10')
        ->and($jumantik->rt)->toBe(1);

    Storage::disk('public')->assertExists($jumantik->photo);
});

it('requires nik, phone, address, and photo', function () {
    Livewire::test(JumantikForm::class)
        ->call('next')
        ->assertHasErrors(['form.rt', 'form.nik', 'form.name', 'form.phone', 'form.address', 'photo']);
});

it('lets pengurus view jumantik reports on the dashboard', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Siti Aminah',
        'nik' => '3174010101010001',
    ]);

    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->get(route('pengurus.dashboard'))
        ->assertOk()
        ->assertSee('Laporan Jumantik')
        ->assertSee('1');

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Siti Aminah')
        ->assertSee('3174010101010001');
});

it('lets rt pengurus see only jumantik reports from their rt', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Warga RT 1',
    ]);
    Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Warga RT 2',
    ]);

    $rt = User::rt()->where('rt', 1)->first();

    $this->actingAs($rt)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Warga RT 1')
        ->assertDontSee('Warga RT 2');
});
