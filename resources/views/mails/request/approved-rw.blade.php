<x-mail::message>
<p>Yth. Bpk/Ibu {{ $request->name }}</p>

<p>Pengajuan surat pengantar anda telah disetujui oleh RW.</p>
<p>Silahkan mengambil berkas yang telah disetujui RW atau abaikan pesan ini jika sudah menerima dokumen tersebut</p>

<x-mail::button url="{{route('request.show', $request->code)}}">
Lihat Pengajuan
</x-mail::button>

<p>Terima kasih.</p>
<p>Pengurus RW 08 Kelapa Dua</p>
</x-mail::message>