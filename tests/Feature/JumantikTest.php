<?php

use App\Filament\Resources\JumantikResource\Pages\ListJumantiks;
use App\Livewire\JumantikForm;
use App\Models\Jumantik;
use App\Models\User;
use App\Notifications\JumantikCreated;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

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
        ->assertSee('Foto')
        ->assertSee('compressJumantikPhoto', false)
        ->assertSee('Mengompres foto', false);
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

it('compresses large jumantik photos before storing them', function () {
    $photo = UploadedFile::fake()->image('jentik.png', 2400, 1800);

    Livewire::test(JumantikForm::class)
        ->set('form.rt', 1)
        ->set('form.name', 'Siti Aminah')
        ->set('form.phone', '081234567890')
        ->set('form.address', 'Jl. Haji Kelik No. 10')
        ->set('form.has_jentik', 'ya')
        ->set('photo', $photo)
        ->call('next')
        ->call('submit')
        ->assertHasNoErrors();

    $jumantik = Jumantik::first();
    [$width, $height, $type] = getimagesize(Storage::disk('public')->path($jumantik->photo));

    expect($width)->toBe(1600)
        ->and($height)->toBe(1200)
        ->and($type)->toBe(IMAGETYPE_JPEG)
        ->and($jumantik->photo)->toEndWith('.jpg');
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
        'has_jentik' => true,
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
        ->assertSee('badge-error', false)
        ->assertSee('border-error', false)
        ->assertDontSee('NIK');
});

it('does not mark jumantik reports without jentik in red', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Budi Santoso',
        'has_jentik' => false,
    ]);

    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Ditemukan jentik : Tidak', false)
        ->assertDontSee('badge-error', false);
});

it('lets rw pengurus filter jumantik reports by rt', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Warga RT 1',
        'created_at' => now(),
    ]);
    Jumantik::factory()->count(16)->create([
        'rt' => 2,
        'name' => 'Warga RT 2',
        'created_at' => now()->subMinute(),
    ]);

    $rw = User::rw()->first();
    $rtTwo = User::rt()->where('rt', 2)->first();

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Tampilkan data per RT')
        ->assertSee('Semua RT')
        ->assertSee('RT. 2 - '.$rtTwo->name, false)
        ->assertSee('Warga RT 1')
        ->assertSee('Warga RT 2')
        ->assertSee('Total data')
        ->assertSee('stat-value text-info">17', false);

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['rt' => 2]))
        ->assertOk()
        ->assertSee('Laporan Mandiri Jumantik - RT. 2')
        ->assertSee('value="2" selected', false)
        ->assertSee('Warga RT 2')
        ->assertDontSee('Warga RT 1')
        ->assertSee('rt=2', false)
        ->assertSee('stat-value text-info">16', false)
        ->assertSee('stat-desc">RT. 2', false);

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['rt' => 3]))
        ->assertOk()
        ->assertSee('Belum ada laporan untuk RT. 3')
        ->assertSee('stat-value text-info">0', false);

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['rt' => 99]))
        ->assertOk()
        ->assertSee('Warga RT 1')
        ->assertSee('Warga RT 2')
        ->assertDontSee('RT. 99');
});

it('shows jentik totals and filters the list when a total is selected', function () {
    Jumantik::factory()->count(2)->create([
        'rt' => 1,
        'name' => 'Ada Jentik',
        'has_jentik' => true,
    ]);
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Tanpa Jentik',
        'has_jentik' => false,
    ]);
    Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Jentik RT 2',
        'has_jentik' => true,
    ]);

    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Ditemukan jentik')
        ->assertSee('Tidak ditemukan')
        ->assertSee('stat-value text-info">4', false)
        ->assertSee('stat-value text-error">3', false)
        ->assertSee('stat-value">1', false)
        ->assertSee(route('pengurus.jumantik.index', ['jentik' => 'ya']), false)
        ->assertSee(route('pengurus.jumantik.index', ['jentik' => 'tidak']), false)
        ->assertSee('Ada Jentik')
        ->assertSee('Tanpa Jentik')
        ->assertSee('Jentik RT 2');

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['jentik' => 'ya']))
        ->assertOk()
        ->assertSee('Ada Jentik')
        ->assertSee('Jentik RT 2')
        ->assertDontSee('Tanpa Jentik')
        ->assertSee('stat-value text-info">4', false)
        ->assertSee('stat-value text-error">3', false)
        ->assertSee('sedang ditampilkan')
        ->assertSee('name="jentik" value="ya"', false);

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['jentik' => 'tidak']))
        ->assertOk()
        ->assertSee('Tanpa Jentik')
        ->assertDontSee('Ada Jentik')
        ->assertDontSee('Jentik RT 2');

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['rt' => 2, 'jentik' => 'ya']))
        ->assertOk()
        ->assertSee('Jentik RT 2')
        ->assertDontSee('Ada Jentik')
        ->assertDontSee('Tanpa Jentik')
        ->assertSee('stat-value text-info">1', false)
        ->assertSee('stat-value text-error">1', false)
        ->assertSee('stat-value">0', false)
        ->assertSee(route('pengurus.jumantik.index', ['rt' => 2]), false);

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index', ['jentik' => 'semua']))
        ->assertOk()
        ->assertSee('Ada Jentik')
        ->assertSee('Tanpa Jentik');
});

it('filters an rt pengurus jumantik list by jentik within their rt', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Jentik RT 1',
        'has_jentik' => true,
    ]);
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Bersih RT 1',
        'has_jentik' => false,
    ]);
    Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Jentik RT 2',
        'has_jentik' => true,
    ]);

    $rt = User::rt()->where('rt', 1)->first();

    $this->actingAs($rt)
        ->get(route('pengurus.jumantik.index', ['jentik' => 'ya']))
        ->assertOk()
        ->assertSee('Jentik RT 1')
        ->assertDontSee('Bersih RT 1')
        ->assertDontSee('Jentik RT 2')
        ->assertSee('stat-value text-info">2', false)
        ->assertSee('stat-value text-error">1', false)
        ->assertSee('stat-value">1', false);
});

it('lets admin filter the jumantik table by rt', function () {
    $rtOne = Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Warga RT 1',
    ]);
    $rtTwo = Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Warga RT 2',
    ]);

    $this->actingAs(User::where('role', 'admin')->first());

    livewire(ListJumantiks::class)
        ->assertCanSeeTableRecords([$rtOne, $rtTwo])
        ->filterTable('rt', '2')
        ->assertCanSeeTableRecords([$rtTwo])
        ->assertCanNotSeeTableRecords([$rtOne]);
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
        ->get(route('pengurus.jumantik.index', ['rt' => 2]))
        ->assertOk()
        ->assertSee('Warga RT 1')
        ->assertDontSee('Warga RT 2')
        ->assertDontSee('Tampilkan data per RT')
        ->assertDontSee('Semua RT')
        ->assertSee('Total data')
        ->assertSee('stat-value text-info">1', false)
        ->assertSee('stat-desc">RT. 1', false);
});

it('lets pengurus delete a jumantik report', function () {
    Storage::disk('public')->put('jumantik/sample.jpg', 'fake');

    $report = Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Siti Aminah',
        'photo' => 'jumantik/sample.jpg',
    ]);

    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Hapus');

    $this->actingAs($rw)
        ->delete(route('pengurus.jumantik.destroy', $report->id))
        ->assertRedirect(route('pengurus.jumantik.index'));

    expect(Jumantik::count())->toBe(0);
    Storage::disk('public')->assertMissing('jumantik/sample.jpg');
});

it('does not let rt pengurus delete jumantik reports from another rt', function () {
    $report = Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Warga RT 2',
    ]);

    $rt = User::rt()->where('rt', 1)->first();

    $this->actingAs($rt)
        ->delete(route('pengurus.jumantik.destroy', $report->id))
        ->assertForbidden();

    expect(Jumantik::find($report->id))->not->toBeNull();
});
