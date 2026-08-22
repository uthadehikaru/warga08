<?php

use App\Livewire\JumantikForm;
use App\Models\Jumantik;
use App\Models\User;
use App\Notifications\JumantikCreated;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(UserSeeder::class);
    Storage::fake('public');
    Notification::fake();
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
        ->assertSee('Laporan Mandiri Jumantik')
        ->assertDontSee('NIK')
        ->assertSee('No. Telepon')
        ->assertSee('Alamat')
        ->assertSee('Apakah ditemukan jentik?')
        ->assertSee('Ya')
        ->assertSee('Tidak')
        ->assertSee('Foto');
});

it('lets a resident submit jumantik information', function () {
    $photo = UploadedFile::fake()->image('jentik.jpg');

    Livewire::test(JumantikForm::class)
        ->set('form.rt', 1)
        ->set('form.name', 'Siti Aminah')
        ->set('form.phone', '081234567890')
        ->set('form.address', 'Jl. Haji Kelik No. 10')
        ->set('form.has_jentik', 'ya')
        ->set('photo', $photo)
        ->call('next')
        ->assertHasNoErrors()
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(Jumantik::count())->toBe(1);

    $jumantik = Jumantik::first();
    expect($jumantik->name)->toBe('Siti Aminah')
        ->and($jumantik->phone)->toBe('081234567890')
        ->and($jumantik->address)->toBe('Jl. Haji Kelik No. 10')
        ->and($jumantik->has_jentik)->toBeTrue()
        ->and($jumantik->rt)->toBe(1)
        ->and($jumantik->nik)->toBeNull();

    Storage::disk('public')->assertExists($jumantik->photo);
});

it('notifies assigned rt after jumantik is submitted and cc rw', function () {
    $photo = UploadedFile::fake()->image('jentik.jpg');
    $rt = User::rt()->where('rt', 1)->first();
    $otherRt = User::rt()->where('rt', 2)->first();
    $rw = User::rw()->first();

    Livewire::test(JumantikForm::class)
        ->set('form.rt', 1)
        ->set('form.name', 'Siti Aminah')
        ->set('form.phone', '081234567890')
        ->set('form.address', 'Jl. Haji Kelik No. 10')
        ->set('form.has_jentik', 'ya')
        ->set('photo', $photo)
        ->call('next')
        ->call('submit');

    Notification::assertSentTo($rt, JumantikCreated::class, function (JumantikCreated $notification) use ($rt, $rw) {
        $mail = $notification->toMail($rt);

        return collect($mail->cc)->contains(fn ($cc) => $cc[0] === $rw->email);
    });
    Notification::assertNotSentTo($rw, JumantikCreated::class);
    Notification::assertNotSentTo($otherRt, JumantikCreated::class);
});

it('requires phone, address, and photo', function () {
    Livewire::test(JumantikForm::class)
        ->call('next')
        ->assertHasErrors(['form.rt', 'form.name', 'form.phone', 'form.address', 'form.has_jentik', 'photo'])
        ->assertHasNoErrors(['form.nik']);
});

it('lets pengurus view jumantik reports on the dashboard', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Siti Aminah',
    ]);

    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->get(route('pengurus.dashboard'))
        ->assertOk()
        ->assertSee('Laporan Mandiri Jumantik')
        ->assertSee('1');

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Laporan Mandiri Jumantik')
        ->assertSee('Siti Aminah')
        ->assertSee('Ditemukan jentik')
        ->assertDontSee('NIK');
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
