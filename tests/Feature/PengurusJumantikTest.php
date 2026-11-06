<?php

use App\Models\Jumantik;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(UserSeeder::class);
});

it('shows the pengurus dropdown for rt and rw', function () {
    $rw = User::rw()->first();
    $rt = User::rt()->where('rt', 1)->first();

    $this->actingAs($rw)
        ->get(route('pengurus.dashboard'))
        ->assertOk()
        ->assertSee('Pengurus')
        ->assertSee('RT/RW')
        ->assertSee(route('pengurus.rt.index'), false)
        ->assertSee(route('pengurus.jumantik-officer.index'), false)
        ->assertSee('Data Jumantik')
        ->assertDontSee('Input data');

    $this->actingAs($rt)
        ->get(route('pengurus.dashboard'))
        ->assertOk()
        ->assertSee('RT/RW')
        ->assertSee(route('pengurus.jumantik-officer.index'), false)
        ->assertSee('Data Jumantik')
        ->assertDontSee('Input data');
});

it('lets rw add a jumantik officer for any rt', function () {
    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik-officer.create'))
        ->assertOk()
        ->assertSee('Tambah Pengurus Jumantik')
        ->assertSee('RT. 8');

    $this->actingAs($rw)
        ->post(route('pengurus.jumantik-officer.store'), [
            'name' => 'Siti Jumantik',
            'email' => 'siti.jumantik@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 1',
            'rt' => 8,
            'password' => 'rahasia',
        ])
        ->assertRedirect(route('pengurus.jumantik-officer.index'));

    $officer = User::where('email', 'siti.jumantik@example.com')->first();

    expect($officer)->not->toBeNull()
        ->and($officer->role)->toBe('jumantik')
        ->and((int) $officer->rt)->toBe(8)
        ->and(Hash::check('rahasia', $officer->password))->toBeTrue();

    $this->actingAs($rw)
        ->get(route('pengurus.jumantik-officer.index'))
        ->assertOk()
        ->assertSee('Siti Jumantik')
        ->assertSee('RT. 8')
        ->assertSee('Ubah data')
        ->assertSee('Hapus');
});

it('lets rw update and delete a jumantik officer', function () {
    $rw = User::rw()->first();
    $officer = User::factory()->create([
        'role' => 'jumantik',
        'rt' => 2,
        'name' => 'Lama',
        'email' => 'lama.jumantik@example.com',
    ]);

    $this->actingAs($rw)
        ->put(route('pengurus.jumantik-officer.update', $officer), [
            'name' => 'Baru',
            'email' => 'baru.jumantik@example.com',
            'phone' => '081111111111',
            'address' => 'Jl. Baru',
            'rt' => 4,
            'password' => 'gantipass',
        ])
        ->assertRedirect(route('pengurus.jumantik-officer.index'));

    $officer->refresh();

    expect($officer->name)->toBe('Baru')
        ->and($officer->email)->toBe('baru.jumantik@example.com')
        ->and((int) $officer->rt)->toBe(4)
        ->and($officer->role)->toBe('jumantik')
        ->and(Hash::check('gantipass', $officer->password))->toBeTrue();

    $this->actingAs($rw)
        ->delete(route('pengurus.jumantik-officer.destroy', $officer))
        ->assertRedirect(route('pengurus.jumantik-officer.index'));

    expect(User::find($officer->id))->toBeNull();
});

it('lets an rt view and add jumantik officers only for their rt', function () {
    $rt = User::rt()->where('rt', 1)->first();
    User::factory()->create([
        'role' => 'jumantik',
        'rt' => 1,
        'name' => 'Jumantik RT 1',
        'email' => 'jumantik.rt1@example.com',
    ]);
    User::factory()->create([
        'role' => 'jumantik',
        'rt' => 2,
        'name' => 'Jumantik RT 2',
        'email' => 'jumantik.rt2@example.com',
    ]);

    $this->actingAs($rt)
        ->get(route('pengurus.jumantik-officer.index'))
        ->assertOk()
        ->assertSee('Jumantik RT 1')
        ->assertDontSee('Jumantik RT 2')
        ->assertDontSee('Ubah data')
        ->assertDontSee('Hapus');

    $this->actingAs($rt)
        ->get(route('pengurus.jumantik-officer.create'))
        ->assertOk()
        ->assertSee('RT. 1')
        ->assertDontSee('name="rt"', false);

    $this->actingAs($rt)
        ->post(route('pengurus.jumantik-officer.store'), [
            'name' => 'Pengurus Baru',
            'email' => 'baru.rt1@example.com',
            'phone' => '082222222222',
            'address' => 'Jl. RT 1',
            'rt' => 5,
            'password' => 'rahasia',
        ])
        ->assertRedirect(route('pengurus.jumantik-officer.index'));

    $created = User::where('email', 'baru.rt1@example.com')->first();

    expect($created->role)->toBe('jumantik')
        ->and((int) $created->rt)->toBe(1);
});

it('does not let an rt edit or delete jumantik officers', function () {
    $rt = User::rt()->where('rt', 1)->first();
    $officer = User::factory()->create([
        'role' => 'jumantik',
        'rt' => 1,
        'name' => 'Jumantik RT 1',
    ]);

    $this->actingAs($rt)
        ->get(route('pengurus.jumantik-officer.edit', $officer))
        ->assertForbidden();

    $this->actingAs($rt)
        ->put(route('pengurus.jumantik-officer.update', $officer), [
            'name' => 'Diganti',
            'email' => $officer->email,
            'phone' => '081234567890',
            'address' => 'Jl. Diganti',
            'rt' => 1,
        ])
        ->assertForbidden();

    $this->actingAs($rt)
        ->delete(route('pengurus.jumantik-officer.destroy', $officer))
        ->assertForbidden();

    expect($officer->refresh()->name)->toBe('Jumantik RT 1');
});

it('lets a jumantik officer open only jumantik data for their rt', function () {
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Laporan RT 1',
        'latitude' => -6.2,
        'longitude' => 106.7,
    ]);
    Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Laporan RT 2',
        'latitude' => -6.3,
        'longitude' => 106.8,
    ]);

    $officer = User::factory()->create([
        'role' => 'jumantik',
        'rt' => 1,
        'name' => 'Petugas RT 1',
    ]);

    $this->actingAs($officer)
        ->get(route('pengurus.dashboard'))
        ->assertOk()
        ->assertSee('Laporan Mandiri Jumantik')
        ->assertSee('Data Jumantik')
        ->assertSee('Input data')
        ->assertSee(route('pengurus.jumantik.create'), false)
        ->assertDontSee('RT/RW')
        ->assertDontSee('Total Pengajuan')
        ->assertDontSee(route('pengurus.warga.index'), false)
        ->assertSee('stat-value text-info">1', false);

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik.index', ['rt' => 2]))
        ->assertOk()
        ->assertSee('Laporan RT 1')
        ->assertSee('Diinput : Mandiri')
        ->assertSee('Input data')
        ->assertDontSee('Laporan RT 2')
        ->assertDontSee('Tampilkan data per RT');

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik.map'))
        ->assertOk()
        ->assertSee('Laporan RT 1')
        ->assertDontSee('Laporan RT 2');

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik-officer.index'))
        ->assertForbidden();

    $this->actingAs($officer)
        ->get(route('pengurus.warga.index'))
        ->assertForbidden();

    $other = Jumantik::where('rt', 2)->first();

    $this->actingAs($officer)
        ->delete(route('pengurus.jumantik.destroy', $other->id))
        ->assertForbidden();

    expect(Jumantik::find($other->id))->not->toBeNull();
});

it('lets a jumantik officer input a report for their rt and shows who entered it', function () {
    Storage::fake('public');
    Notification::fake();

    $officer = User::factory()->create([
        'role' => 'jumantik',
        'rt' => 1,
        'name' => 'Petugas RT 1',
    ]);
    $otherOfficer = User::factory()->create([
        'role' => 'jumantik',
        'rt' => 1,
        'name' => 'Petugas Lain RT 1',
    ]);
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Laporan Mandiri',
        'user_id' => null,
    ]);
    Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Laporan Petugas Lain',
        'user_id' => $otherOfficer->id,
    ]);
    Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Laporan RT Lain',
    ]);

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik.create'))
        ->assertOk()
        ->assertSee('Input Data Jumantik')
        ->assertSee('RT. 1')
        ->assertDontSee('name="rt"', false);

    $this->actingAs(User::rt()->where('rt', 1)->first())
        ->get(route('pengurus.jumantik.create'))
        ->assertForbidden();

    $this->actingAs(User::rw()->first())
        ->post(route('pengurus.jumantik.store'), [
            'name' => 'Tidak Boleh',
            'phone' => '081234567890',
            'address' => 'Jl. RW',
            'has_jentik' => 'tidak',
            'photo' => UploadedFile::fake()->image('jentik.jpg'),
        ])
        ->assertForbidden();

    $this->actingAs($officer)
        ->post(route('pengurus.jumantik.store'), [
            'name' => 'Warga Dicek',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 4',
            'has_jentik' => 'ya',
            'rt' => 8,
            'photo' => UploadedFile::fake()->image('jentik.jpg'),
            'latitude' => -6.2,
            'longitude' => 106.7,
        ])
        ->assertRedirect(route('pengurus.jumantik.index'));

    $report = Jumantik::where('name', 'Warga Dicek')->first();

    expect($report)->not->toBeNull()
        ->and($report->user_id)->toBe($officer->id)
        ->and((int) $report->rt)->toBe(1)
        ->and($report->has_jentik)->toBeTrue()
        ->and($report->inputLabel())->toBe('Diinput : Petugas RT 1');

    Storage::disk('public')->assertExists($report->photo);
    Notification::assertNothingSent();

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik.index'))
        ->assertOk()
        ->assertSee('Warga Dicek')
        ->assertSee('Diinput : Petugas RT 1')
        ->assertSee(route('pengurus.jumantik.edit', $report->id), false)
        ->assertDontSee('badge-ghost', false)
        ->assertSee('Laporan Mandiri')
        ->assertSee('Laporan Petugas Lain')
        ->assertSee('Diinput : Petugas Lain RT 1')
        ->assertDontSee(route('pengurus.jumantik.edit', Jumantik::where('name', 'Laporan Mandiri')->first()->id), false)
        ->assertDontSee(route('pengurus.jumantik.edit', Jumantik::where('name', 'Laporan Petugas Lain')->first()->id), false)
        ->assertSee('Diinput : Mandiri')
        ->assertSee('lg:w-72', false)
        ->assertDontSee('Laporan RT Lain');

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik.map'))
        ->assertOk()
        ->assertSee('Diinput : Petugas RT 1', false);
});

it('lets jumantik edit only their own reports, rt edit their rt, and rw edit every report', function () {
    $officer = User::factory()->create([
        'role' => 'jumantik',
        'rt' => 1,
        'name' => 'Petugas RT 1',
    ]);
    $own = Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Milik Petugas',
        'phone' => '081111111111',
        'address' => 'Jl. Lama',
        'user_id' => $officer->id,
        'photo' => 'jumantik/lama.jpg',
        'has_jentik' => false,
    ]);
    $mandiri = Jumantik::factory()->create([
        'rt' => 1,
        'name' => 'Mandiri RT 1',
        'user_id' => null,
        'phone' => '082222222222',
        'address' => 'Jl. Mandiri',
    ]);
    $otherRt = Jumantik::factory()->create([
        'rt' => 2,
        'name' => 'Laporan RT 2',
        'user_id' => null,
        'phone' => '083333333333',
        'address' => 'Jl. RT 2',
    ]);

    $this->actingAs($officer)
        ->put(route('pengurus.jumantik.update', $own), [
            'name' => 'Milik Petugas Baru',
            'phone' => '081111111111',
            'address' => 'Jl. Baru',
            'has_jentik' => 'ya',
            'rt' => 8,
        ])
        ->assertRedirect(route('pengurus.jumantik.index'));

    $own->refresh();
    expect($own->name)->toBe('Milik Petugas Baru')
        ->and($own->has_jentik)->toBeTrue()
        ->and((int) $own->rt)->toBe(1)
        ->and($own->user_id)->toBe($officer->id)
        ->and($own->photo)->toBe('jumantik/lama.jpg');

    $this->actingAs($officer)
        ->get(route('pengurus.jumantik.edit', $mandiri))
        ->assertForbidden();

    $this->actingAs($officer)
        ->put(route('pengurus.jumantik.update', $otherRt), [
            'name' => 'Diganti',
            'phone' => '083333333333',
            'address' => 'Jl. RT 2',
            'has_jentik' => 'tidak',
        ])
        ->assertForbidden();

    $rt = User::rt()->where('rt', 1)->first();

    $this->actingAs($rt)
        ->get(route('pengurus.jumantik.edit', $mandiri))
        ->assertOk()
        ->assertSee('Ubah Data Jumantik')
        ->assertDontSee('name="rt"', false);

    $this->actingAs($rt)
        ->put(route('pengurus.jumantik.update', $mandiri), [
            'name' => 'Mandiri Diedit RT',
            'phone' => '082222222222',
            'address' => 'Jl. Mandiri',
            'has_jentik' => 'tidak',
            'rt' => 4,
        ])
        ->assertRedirect(route('pengurus.jumantik.index'));

    expect($mandiri->refresh()->name)->toBe('Mandiri Diedit RT')
        ->and($mandiri->user_id)->toBeNull()
        ->and((int) $mandiri->rt)->toBe(1)
        ->and($mandiri->inputLabel())->toBe('Diinput : Mandiri');

    $this->actingAs($rt)
        ->put(route('pengurus.jumantik.update', $otherRt), [
            'name' => 'Tidak Boleh',
            'phone' => '083333333333',
            'address' => 'Jl. RT 2',
            'has_jentik' => 'tidak',
        ])
        ->assertForbidden();

    $rw = User::rw()->first();

    $this->actingAs($rw)
        ->put(route('pengurus.jumantik.update', $otherRt), [
            'name' => 'Diedit RW',
            'phone' => '083333333333',
            'address' => 'Jl. RT 2',
            'has_jentik' => 'ya',
            'rt' => 3,
        ])
        ->assertRedirect(route('pengurus.jumantik.index'));

    expect($otherRt->refresh()->name)->toBe('Diedit RW')
        ->and((int) $otherRt->rt)->toBe(3)
        ->and($otherRt->has_jentik)->toBeTrue();
});
