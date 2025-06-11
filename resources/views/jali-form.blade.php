@extends('layouts.web')
@section('title', 'Jali-Jali -')
@section('content')
<section id="contact" class="py-10">
      <div class="container mx-auto px-4">
        <!-- Success Alert -->
        <div id="success-alert" class="hidden mb-4">
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline"> Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.</span>
            <button id="close-alert" class="absolute top-0 bottom-0 right-0 px-4 py-3">
              <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="text-center mb-10">
          <div>
            <h1 class="text-3xl font-bold"><span class="text-green-500">Jali</span> Jali</h1>
            <h2 class="text-xl font-bold">Jemput Antar Lansia</h2>
            <p class="text-center">Posyandu Siklus Hidup Melati RW 08</p>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="w-full md:w-1/2 lg:w-2/5">
            <form name='jali-jali-contact-form'>
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="name" poppins-describedby="name" name="nama" placeholder="Masukkan nama lengkap">
              </div>
              <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="alamat" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="alamat" poppins-describedby="alamat" name="alamat" placeholder="Masukkan alamat lengkap">
              </div>
              <div class="mb-4">
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="telepon" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="telepon" poppins-describedby="telepon" name="telepon" placeholder="Contoh: 08123456789">
              </div>
              <div class="mb-4">
                <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Pesan Jemput Antar Lansia</label>
                <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" id="pesan" rows="3" name="pesan" placeholder="Tuliskan detail permintaan jemput antar lansia"></textarea>
              </div>
              <button type="submit" id="submit-button" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">Kirim Pesan</button>
            </form>
            <p class="text-sm font-semibold mt-6 text-center">Posyandu ILP Melati RW 08<br>Buka : Hari Selasa Minggu Ke 2 setiap Bulan, pada Jam 8.00-11.00 WIB</p>
          </div>
        </div>
      </div>
    </section>
@endsection

@push('scripts')
<script>
  const scriptURL = 'https://script.google.com/macros/s/AKfycbxKHMrUOe_aqGplf0svJP8xAS-WWTZ8ChOHUs7qESc-jifDvSIpXis-1Q0eKl7goc_o3Q/exec'
  const form = document.forms['jali-jali-contact-form']
  const successAlert = document.getElementById('success-alert')
  const closeAlert = document.getElementById('close-alert')
  const submitButton = document.getElementById('submit-button')

  form.addEventListener('submit', async e => {
    e.preventDefault()
    
    // Disable button and change text
    submitButton.disabled = true
    submitButton.classList.add('opacity-75', 'cursor-not-allowed')
    submitButton.textContent = 'Mengirim...'
    
    try {
      const formData = new FormData(form)
      const response = await fetch(scriptURL, {
        method: 'POST',
        body: formData,
        redirect: 'follow', // This is important for handling Google's 302 redirect
        mode: 'cors'
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const data = await response.json()
      
      if (data.result === 'success') {
        // Show success message
        successAlert.classList.remove('hidden')
        // Reset form
        form.reset()
        // Hide success message after 5 seconds
        setTimeout(() => {
          successAlert.classList.add('hidden')
        }, 5000)
      } else {
        throw new Error(data.error || 'Unknown error occurred')
      }
    } catch (error) {
      console.error('Error!', error.message)
      alert('Maaf, terjadi kesalahan. Silakan coba lagi.')
    } finally {
      // Re-enable button and restore original text
      submitButton.disabled = false
      submitButton.classList.remove('opacity-75', 'cursor-not-allowed')
      submitButton.textContent = 'Kirim Pesan'
    }
  })

  // Close button functionality
  closeAlert.addEventListener('click', () => {
    successAlert.classList.add('hidden')
  })
</script>
@endpush