@php
    $currentRoute = Route::currentRouteName();
    $isActive = function($route) use ($currentRoute) {
        return in_array($currentRoute, (array) $route) ? 'nav-active' : '';
    };
@endphp

<header class="navbar">
      <nav
        class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4"
        aria-label="Navigasi utama"
      >
        <a href="{{ route('web.beranda.index') }}" class="flex items-center text-2xl font-semibold tracking-tight" aria-label="Firstudio - Beranda">
          <img src="{{ asset('web/assets/logo.png') }}" alt="Firstudio Logo - Digital Agency Profesional" class="h-14 w-auto" width="56" height="56" />
          <span class="text-white">Firstudio</span>
        </a>

        <div class="hidden items-center gap-8 md:flex">
          <a href="{{ route('web.beranda.index') }}" class="{{ $isActive('web.beranda.index') }} text-sm font-medium text-white/80 hover:text-white"
            >Home</a
          >
          <a href="{{ route('web.about.index') }}" class="{{ $isActive('web.about.index') }} text-sm font-medium text-white/80 hover:text-white"
            >About Us</a
          >
          <div class="relative" id="services-menu">
            <button
              class="relative top-[1px] flex items-center gap-1 text-sm font-medium text-white/80 transition hover:text-white {{ $isActive(['web.layanan.website', 'web.layanan.mobile', 'web.layanan.company', 'web.layanan.itconsul']) }}"
              data-services-button
              aria-expanded="false"
            >
              Services
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                class="h-4 w-4 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                data-chevron
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="m6 9 6 6 6-6"
                />
              </svg>
            </button>

            <div
              class="nav-services-panel pointer-events-none absolute left-1/2 top-12 w-80 -translate-x-1/2 p-3 opacity-0 transition-all duration-200 data-[open=true]:pointer-events-auto data-[open=true]:opacity-100 data-[open=true]:translate-y-0 translate-y-[-10px] z-[110]"
              data-services-panel
              data-open="false"
            >
              <ul class="space-y-2">
                <li>
                  <a
                    href="{{ route('web.layanan.website') }}"
                    class="nav-services-item group flex items-start gap-4 p-4 transition"
                  >
                    <div
                      class="nav-services-icon flex h-10 w-10 flex-shrink-0 items-center justify-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5"
                      >
                        <path
                          d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"
                        />
                        <path
                          d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"
                        />
                      </svg>
                    </div>
                    <div class="flex-1">
                      <p class="nav-services-title text-sm font-semibold">
                        Pembuatan Website & App
                      </p>
                      <p class="nav-services-desc text-xs">
                        Website responsif dan mudah dikelola
                      </p>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('web.layanan.mobile') }}"
                    class="nav-services-item group flex items-start gap-4 p-4 transition"
                  >
                    <div
                      class="nav-services-icon flex h-10 w-10 flex-shrink-0 items-center justify-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5"
                      >
                        <path
                          d="M10.5 18.75a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M8.625.75A3.375 3.375 0 005.25 4.125v15.75a3.375 3.375 0 003.375 3.375h6.75a3.375 3.375 0 003.375-3.375V4.125A3.375 3.375 0 0015.375.75h-6.75zM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 017.5 19.875V4.125z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </div>
                    <div class="flex-1">
                      <p class="nav-services-title text-sm font-semibold">
                        Mobile App Development
                      </p>
                      <p class="nav-services-desc text-xs">
                        Aplikasi native dan cross-platform
                      </p>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('web.layanan.company') }}"
                    class="nav-services-item group flex items-start gap-4 p-4 transition"
                  >
                    <div
                      class="nav-services-icon flex h-10 w-10 flex-shrink-0 items-center justify-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zm-3.873 8.703a4.126 4.126 0 017.746 0 .75.75 0 01-.351.92 7.47 7.47 0 01-3.522.877 7.47 7.47 0 01-3.522-.877.75.75 0 01-.351-.92zM15 8.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15zM14.25 12a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H15a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </div>
                    <div class="flex-1">
                      <p class="nav-services-title text-sm font-semibold">
                        Company Profile
                      </p>
                      <p class="nav-services-desc text-xs">
                        Tampilkan identitas bisnis secara profesional
                      </p>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('web.layanan.itconsul') }}"
                    class="nav-services-item group flex items-start gap-4 p-4 transition"
                  >
                    <div
                      class="nav-services-icon flex h-10 w-10 flex-shrink-0 items-center justify-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                          clip-rule="evenodd"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </div>
                    <div class="flex-1">
                      <p class="nav-services-title text-sm font-semibold">
                        IT Consultation
                      </p>
                      <p class="nav-services-desc text-xs">
                        Solusi teknologi untuk efisiensi bisnis
                      </p>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('web.layanan.itoutsourcing') }}"
                    class="nav-services-item group flex items-start gap-4 p-4 transition"
                  >
                    <div
                      class="nav-services-icon flex h-10 w-10 flex-shrink-0 items-center justify-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-5 w-5"
                      >
                        <path
                          d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c1.68 0 3.282.515 4.75 1.407A.75.75 0 0024 19.5V5.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3c-1.995 0-3.823.707-5.25 1.886v15.75z"
                        />
                      </svg>
                    </div>
                    <div class="flex-1">
                      <p class="nav-services-title text-sm font-semibold">
                        IT Outsourcing
                      </p>
                      <p class="nav-services-desc text-xs">
                        Tim developer profesional & dedicated
                      </p>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <a href="{{ route('web.produk.index') }}" class="{{ $isActive('web.produk.index') }} text-sm font-medium text-white/80 hover:text-white"
            >Portofolio</a
          >
          <a href="{{ route('web.artikel.index') }}" class="{{ $isActive('web.artikel.index') }} text-sm font-medium text-white/80 hover:text-white"
            >Articles</a
          >
          <a href="{{ route('web.contact.index') }}" class="{{ $isActive('web.contact.index') }} text-sm font-medium text-white/80 hover:text-white"
            >Contact</a
          >
        </div>

        <button class="md:hidden" id="mobile-toggle" aria-label="Buka navigasi">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-6 w-6 text-white"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </nav>

      <div
        id="mobile-menu"
        class="border-t border-white/10 bg-black px-6 py-4 text-sm text-white/80 md:hidden"
        hidden
      >
        <a href="{{ route('web.beranda.index') }}" class="{{ $isActive('web.beranda.index') }} block py-2">Home</a>
        <a href="{{ route('web.about.index') }}" class="{{ $isActive('web.about.index') }} block py-2">About Us</a>
        <button
          class="flex w-full items-center justify-between py-2"
          data-mobile-services
        >
          <span>Services</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m6 9 6 6 6-6"
            />
          </svg>
        </button>
        <div
          class="space-y-3 border-l border-white/10 pl-4 text-xs"
          hidden
          data-mobile-services-panel
        >
          <a href="{{ route('web.layanan.website') }}" class="block py-2">Pembuatan Website & App</a>
          <a href="{{ route('web.layanan.mobile') }}" class="block py-2">Mobile App Development</a>
          <a href="{{ route('web.layanan.company') }}" class="block py-2">Company Profile</a>
          <a href="{{ route('web.layanan.itconsul') }}" class="block py-2">IT Consultation</a>
          <a href="{{ route('web.layanan.itoutsourcing') }}" class="block py-2">IT Outsourcing</a>
        </div>
        <a href="{{ route('web.produk.index') }}" class="block py-2">Portofolio</a>
        <a href="{{ route('web.artikel.index') }}" class="block py-2">Articles</a>
        <a href="{{ route('web.contact.index') }}" class="block py-2">Contact</a>
      </div>
</header>
