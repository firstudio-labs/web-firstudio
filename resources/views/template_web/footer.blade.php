<!-- Footer -->
<footer
      id="footer"
      class="footer bg-black px-6 py-16 text-white"
    >
      <div class="mx-auto w-full max-w-6xl">
        <div class="grid gap-12 md:grid-cols-4">
          <!-- Column 1: Newsletter -->
          <div class="space-y-6 md:col-span-1">
            <h3 class="font-primary text-2xl font-bold text-white">
              Stay Connected
            </h3>
            <p class="text-sm text-gray-400">
              Join our newsletter for the latest updates and exclusive offers.
            </p>
            <div class="relative">
              <input
                type="email"
                placeholder="Enter your email"
                class="w-full rounded-lg border border-white/20 dark:border-gray-900/20 bg-white/5 px-4 py-3 pr-12 text-sm text-white placeholder-gray-500 focus:border-white/40 focus:outline-none focus:ring-2 focus:ring-white/20"
              />
              <button
                class="absolute right-2 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-md bg-white text-black transition hover:bg-gray-200"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  class="h-4 w-4"
                >
                  <path
                    d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z"
                  />
                </svg>
              </button>
            </div>
          </div>

          <!-- Column 2: Quick Links -->
          <div class="space-y-4">
            <h4 class="text-base font-semibold text-white">Quick Links</h4>
            <ul class="space-y-3 text-sm">
              <li>
                <a
                  href="{{ route('web.beranda.index') }}"
                  class="footer-link text-gray-400 transition hover:text-white"
                  >Home</a
                >
              </li>
              <li>
                <a
                  href="{{ route('web.about.index') }}"
                  class="footer-link text-gray-400 transition hover:text-white"
                  >About Us</a
                >
              </li>
              <li>
                <a
                  href="{{ route('web.produk.index') }}"
                  class="footer-link text-gray-400 transition hover:text-white"
                  >Portofolio</a
                >
              </li>
              <li>
                <a
                  href="{{ route('web.contact.index') }}"
                  class="footer-link text-gray-400 transition hover:text-white"
                  >Contact</a
                >
              </li>
            </ul>
          </div>

          <!-- Column 3: Contact Us -->
          <div class="space-y-4">
            <h4 class="text-base font-semibold text-white">Contact Us</h4>
            <ul class="space-y-3 text-sm text-gray-400">
              <li>Address: {{ $profil->alamat_perusahaan }}</li>
              <li>
                <a
                  href="tel:{{ $profil->no_telp_perusahaan }}"
                  class="footer-link text-gray-400 transition hover:text-white"
                  >Phone: {{ $profil->no_telp_perusahaan }}</a
                >
              </li>
              <li>
                <a
                  href="mailto:{{ $profil->email_perusahaan }}"
                  class="footer-link text-gray-400 transition hover:text-white"
                  >Email: {{ $profil->email_perusahaan }}</a
                >
              </li>
            </ul>
          </div>

          <!-- Column 4: Follow Us -->
          <div class="space-y-4">
            <h4 class="text-base font-semibold text-white">Follow Us</h4>
            <div class="flex items-center gap-3">
              <a
                href="facebook.com/{{ $profil->facebook_perusahaan }}"
                class="social-icon flex h-10 w-10 items-center justify-center rounded-full border border-white/20 dark:border-gray-900/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
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
              <a
                href="https://linkedin.com/in/{{ $profil->linkedin_perusahaan }}"
                class="social-icon flex h-10 w-10 items-center justify-center rounded-full border border-white/20 dark:border-gray-900/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
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
              <a
                href="https://instagram.com/{{ $profil->instagram_perusahaan }}"
                class="social-icon flex h-10 w-10 items-center justify-center rounded-full border border-white/20 dark:border-gray-900/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="h-5 w-5"
                >
                  <path
                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                  />
                </svg>
              </a>
              <a
                href="https://linkedin.com/in/{{ $profil->linkedin_perusahaan }}"
                class="social-icon flex h-10 w-10 items-center justify-center rounded-full border border-white/20 dark:border-gray-900/20 text-gray-400 transition hover:border-white hover:bg-white hover:text-black"
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
            </div>
          </div>
        </div>

        <!-- Bottom Footer -->
        <div
          class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-sm text-gray-400 md:flex-row"
        >
          <p>© <script>document.write(new Date().getFullYear());</script> {{ $profil->nama_perusahaan }}. All rights reserved.</p>
          <div class="flex gap-6">
            <a href="#" class="footer-link text-gray-400 transition hover:text-white"
              >Privacy Policy</a
            >
            <a href="#" class="footer-link text-gray-400 transition hover:text-white"
              >Terms of Service</a
            >
            <a href="#" class="footer-link text-gray-400 transition hover:text-white"
              >Cookie Settings</a
            >
          </div>
        </div>
      </div>
    </footer>