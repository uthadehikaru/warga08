<x-mail::message>
<p>Assalaamu'alaikum Warahmatullahi Wabarakaatuh</p>

<p>Pengajuan surat pengantar anda telah disetujui oleh RT.</p>
<p>Silahkan mencetak dokumen surat pengantar yang terlampir atau mendatangi Ketua RT setempat untuk meminta surat pengantar.</p>
<p>Dokumen surat pengantar harus disertai tanda tangan dan stempel Ketua RT setempat.</p>

<x-mail::button url="{{route('request.show', $request->code)}}">
Lihat Pengajuan
</x-mail::button>

<p>Terima kasih.</p>
<p>Pengurus RW 08 Kelapa Dua</p>
</x-mail::message>