<div
  id="ai-chatbot"
  class="ai-chatbot"
  data-endpoint="{{ route('web.chatbot.ask') }}"
>
  <div class="ai-chatbot__panel" data-chatbot-panel>
    <div class="ai-chatbot__header">
      <div>
        <p class="ai-chatbot__title">Firsty AI</p>
      </div>
      <button
        type="button"
        class="ai-chatbot__close"
        data-chatbot-close
        aria-label="Tutup chatbot"
      >
        ✕
      </button>
    </div>
    <div class="ai-chatbot__messages" data-chatbot-messages></div>
    <div class="ai-chatbot__status" data-chatbot-status></div>
    <form class="ai-chatbot__form" data-chatbot-form>
      <textarea
        class="ai-chatbot__input"
        placeholder="Ketik pertanyaanmu..."
        rows="2"
        data-chatbot-input
        required
      ></textarea>
      <div class="ai-chatbot__actions">
        <div class="ai-chatbot__actions-left">
          @if(!empty($profil?->no_telp_perusahaan))
            @php
              $cleanNumber = preg_replace('/[^0-9]/', '', $profil->no_telp_perusahaan);
              $waNumber = Str::startsWith($cleanNumber, '0') ? '62' . substr($cleanNumber, 1) : $cleanNumber;
            @endphp
            <a
              href="https://wa.me/{{ $waNumber }}"
              target="_blank"
              rel="noopener noreferrer"
              class="ai-chatbot__wa"
            >
              <svg
                viewBox="0 0 32 32"
                class="ai-chatbot__wa-icon"
                aria-hidden="true"
              >
                <path
                  d="M16.004 3.038c-7.157 0-12.969 5.812-12.969 12.969 0 2.287.598 4.506 1.729 6.475l-1.151 4.204 4.309-1.129c1.905 1.041 4.061 1.59 6.231 1.59h.006c7.153 0 12.965-5.812 12.965-12.969 0-3.467-1.35-6.723-3.802-9.176-2.456-2.453-5.714-3.964-9.318-3.964z"
                  fill="#25D366"
                />
                <path
                  d="M23.395 19.793c-.369-.184-2.186-1.075-2.524-1.193-.338-.123-.584-.184-.83.184-.246.369-.953 1.193-1.168 1.439-.215.246-.43.276-.799.092-.369-.184-1.559-.574-2.968-1.831-1.097-.975-1.84-2.181-2.057-2.55-.215-.369-.023-.568.161-.753.161-.161.369-.43.553-.646.184-.215.246-.369.369-.614.123-.246.062-.461-.031-.645-.092-.184-.83-1.999-1.14-2.738-.3-.723-.6-.623-.83-.635l-.707-.012c-.246 0-.645.092-.984.461-.338.369-1.292 1.262-1.292 3.077 0 1.815 1.322 3.568 1.506 3.813.184.246 2.624 4.006 6.356 5.616.889.384 1.58.615 2.12.786.89.284 1.7.244 2.342.148.715-.107 2.186-.893 2.495-1.76.308-.869.308-1.614.215-1.76-.092-.148-.338-.246-.707-.431z"
                  fill="#FAFAFA"
                />
              </svg>
              WhatsApp
            </a>
          @endif
        </div>
        <button type="submit" class="ai-chatbot__send">Kirim</button>
      </div>
    </form>
  </div>
  <button
    class="ai-chatbot__toggle"
    type="button"
    aria-label="Buka chatbot Firsty"
    data-chatbot-toggle
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="1.8"
      class="ai-chatbot__toggle-icon"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-3.916-.793L3 20l1.327-3.32C3.5 15.175 3 13.642 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
      />
      <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 13h5" />
    </svg>
  </button>
</div>

