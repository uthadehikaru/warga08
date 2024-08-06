<x-mail::message>
<p>Assalaamu'alaikum Warahmatullahi Wabarakaatuh</p>

<p>Pengajuan surat pengantar telah disetujui oleh RT dengan data sebagai berikut : </p>
<p>Kode : {{ $request->code }}</p>
<p>No Surat : {{ $request->document_no }}</p>
<p>RT : {{ $request->rt }}</p>
<p>Nama : {{ $request->name }}</p>
<p>Alamat : {{ $request->address }}</p>
<p>Telp : {{ $request->phone }}</p>
<p>Email : {{ $request->email }}</p>
<p>Maksud/Tujuan : {{ $request->description }}</p>

<x-mail::button url="{{route('request.show', $request->code)}}">
Lihat Pengajuan
</x-mail::button>

<p>Terima kasih.</p>
<p>Pengurus RW 08 Kelapa Dua</p>
</x-mail::message>