@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section hero-section--slim text-white">
      <div class="mx-auto w-full max-w-6xl">
        <h1 class="hero-heading">
          Contact
          <span class="flip-words-container text-blue-500">
            <span class="flip-word" data-word="Kami">Kami</span>
          </span>
        </h1>
        <p class="hero-subtitle">
          Hubungi kami untuk konsultasi gratis dan diskusikan kebutuhan digital Anda. Tim kami siap membantu mewujudkan visi bisnis Anda.
        </p>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-black px-6 py-20">
      <div class="mx-auto w-full max-w-6xl">
        @if(session('success'))
          <div class="mb-6 rounded-lg bg-green-500/10 border border-green-500/20 p-4 text-green-400">
            {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="mb-6 rounded-lg bg-red-500/10 border border-red-500/20 p-4 text-red-400">
            <ul class="list-disc list-inside">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="grid gap-12 lg:grid-cols-2">
          <!-- Contact Form -->
          <div class="space-y-8">
            <div>
              <h2 class="font-primary text-3xl font-bold text-white mb-4">Kirim Pesan</h2>
              <p class="text-gray-400">Isi formulir di bawah ini dan kami akan menghubungi Anda segera.</p>
            </div>

            <form action="{{ route('web.contact.store') }}" method="POST" class="space-y-6" id="contact-form">
              @csrf
              <div>
                <label for="nama" class="block text-sm font-medium text-white mb-2">
                  Nama Lengkap <span class="text-red-400">*</span>
                </label>
                <input
                  type="text"
                  id="nama"
                  name="nama"
                  required
                  value="{{ old('nama') }}"
                  class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition"
                  placeholder="Masukkan nama lengkap"
                />
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-white mb-2">
                  Email <span class="text-red-400">*</span>
                </label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  required
                  value="{{ old('email') }}"
                  class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition"
                  placeholder="nama@email.com"
                />
              </div>

              <div>
                <label for="no_hp" class="block text-sm font-medium text-white mb-2">
                  Nomor Telepon <span class="text-red-400">*</span>
                </label>
                <input
                  type="tel"
                  id="no_hp"
                  name="no_hp"
                  required
                  value="{{ old('no_hp') }}"
                  class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition"
                  placeholder="08xxxxxxxxxx"
                />
              </div>

              <div>
                <label for="pesan" class="block text-sm font-medium text-white mb-2">
                  Pesan <span class="text-red-400">*</span>
                </label>
                <textarea
                  id="pesan"
                  name="pesan"
                  rows="5"
                  required
                  class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition resize-none"
                  placeholder="Tuliskan pesan Anda di sini...">{{ old('pesan') }}</textarea>
              </div>

              @if(config('services.hcaptcha.site_key'))
                <div>
                  <label class="block text-sm font-medium text-white mb-2">
                    Verifikasi Keamanan <span class="text-red-400">*</span>
                  </label>
                  <div class="h-captcha" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                  @error('h-captcha-response')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                  @enderror
                </div>
              @endif

              <button
                type="submit"
                class="w-full rounded-full bg-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-[0_10px_25px_rgba(59,130,246,0.4)] transition hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-black"
              >
                Kirim Pesan
              </button>
            </form>
          </div>

          <!-- Contact Info -->
          <div class="space-y-8">
            <div>
              <h2 class="font-primary text-3xl font-bold text-white mb-4">Informasi Kontak</h2>
              <p class="text-gray-400">Anda juga bisa menghubungi kami melalui informasi di bawah ini.</p>
            </div>

            <div class="space-y-6">
              <!-- Address -->
              <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="white"
                    class="h-6 w-6"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-white mb-1">Alamat</h3>
                  <p class="text-gray-400">
                    @if($profil && $profil->alamat_perusahaan)
                      {!! nl2br(e($profil->alamat_perusahaan)) !!}
                    @else
                      JL Kauman Barat IV, Palebon<br />
                      Kec. Pedurungan, Kota Semarang<br />
                      Jawa Tengah
                    @endif
                  </p>
                </div>
              </div>

              <!-- Phone -->
              <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="white"
                    class="h-6 w-6"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-white mb-1">Telepon</h3>
                  <a
                    href="tel:{{ $profil && $profil->no_telp_perusahaan ? $profil->no_telp_perusahaan : '+6285770333333' }}"
                    class="text-blue-400 hover:text-blue-300 transition"
                  >
                    {{ $profil && $profil->no_telp_perusahaan ? $profil->no_telp_perusahaan : '+62 857 7033 3333' }}
                  </a>
                </div>
              </div>

              <!-- Email -->
              <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="white"
                    class="h-6 w-6"
                  >
                    <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                    <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-white mb-1">Email</h3>
                  <a
                    href="mailto:{{ $profil && $profil->email_perusahaan ? $profil->email_perusahaan : 'firstudio24@gmail.com' }}"
                    class="text-blue-400 hover:text-blue-300 transition"
                  >
                    {{ $profil && $profil->email_perusahaan ? $profil->email_perusahaan : 'firstudio24@gmail.com' }}
                  </a>
                </div>
              </div>

              <!-- Business Hours -->
              <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="white"
                    class="h-6 w-6"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-white mb-1">Jam Operasional</h3>
                  <p class="text-gray-400">
                    Senin - Jumat: 09:00 - 18:00 WIB<br />
                    Sabtu - Minggu: Tutup
                  </p>
                </div>
              </div>
            </div>

            <!-- Social Media -->
            <div class="pt-6 border-t border-white/10">
              <h3 class="text-lg font-semibold text-white mb-4">Ikuti Kami</h3>
              <div class="flex items-center gap-3">
                @if($profil && $profil->facebook_perusahaan)
                  <a
                    href="https://facebook.com/{{ ltrim(str_replace(['https://facebook.com/', 'http://facebook.com/', 'https://www.facebook.com/', 'http://www.facebook.com/'], '', rtrim($profil->facebook_perusahaan, '/')), '@') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="h-5 w-5"
                    >
                      <path
                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                      />
                    </svg>
                  </a>
                @endif
                @if($profil && $profil->twitter_perusahaan)
                  <a
                    href="https://twitter.com/{{ ltrim(str_replace(['https://twitter.com/', 'http://twitter.com/', 'https://www.twitter.com/', 'http://www.twitter.com/'], '', rtrim($profil->twitter_perusahaan, '/')), '@') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="h-5 w-5"
                    >
                      <path
                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                      />
                    </svg>
                  </a>
                @endif
                @if($profil && $profil->instagram_perusahaan)
                  <a
                    href="https://instagram.com/{{ ltrim(str_replace(['https://instagram.com/', 'http://instagram.com/', 'https://www.instagram.com/', 'http://www.instagram.com/'], '', rtrim($profil->instagram_perusahaan, '/')), '@') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="h-5 w-5"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </a>
                @endif
                @if($profil && $profil->linkedin_perusahaan)
                  <a
                    href="https://linkedin.com/in/{{ ltrim(str_replace(['https://linkedin.com/in/', 'http://linkedin.com/in/', 'https://www.linkedin.com/in/', 'http://www.linkedin.com/in/'], '', rtrim($profil->linkedin_perusahaan, '/')), '@') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="h-5 w-5"
                    >
                      <path
                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                      />
                    </svg>
                  </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('script')
  @if(config('services.hcaptcha.site_key'))
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
  @endif
@endsection
