/**
 * Firstudio Main JavaScript
 * Best practices implementation for navigation and UI interactions
 */
(function () {
  'use strict';

  // Constants
  const CONSTANTS = {
    CAROUSEL_GAP: 24,
    DEFAULT_SCROLL_AMOUNT: 380,
    CHEVRON_ROTATION_OPEN: '180deg',
    CHEVRON_ROTATION_CLOSE: '0deg',
  };

  // Selectors
  const SELECTORS = {
    servicesMenu: '#services-menu',
    servicesButton: '[data-services-button]',
    servicesPanel: '[data-services-panel]',
    servicesChevron: '[data-chevron]',
    mobileToggle: '#mobile-toggle',
    mobileMenu: '#mobile-menu',
    mobileServicesBtn: '[data-mobile-services]',
    mobileServicesPanel: '[data-mobile-services-panel]',
    articleCarousel: '#article-carousel',
    articleNext: '[data-article-next]',
    articlePrev: '[data-article-prev]',
    focusCard: '.focus-card',
    faqButton: '.faq-button',
    faqContent: '.faq-content',
    filterBtn: '.filter-btn',
    portfolioGrid: '#portfolio-grid',
    portfolioItem: '#portfolio-grid article[data-category]',
    emptyState: '#empty-state',
    flipWord: '.flip-word',
  };

  /**
   * Navigation Menu Handler
   * Handles desktop and mobile navigation menu interactions
   */
  class NavigationMenu {
    constructor() {
      this.servicesMenu = null;
      this.servicesButton = null;
      this.servicesPanel = null;
      this.servicesChevron = null;
      this.mobileToggle = null;
      this.mobileMenu = null;
      this.mobileServicesBtn = null;
      this.mobileServicesPanel = null;
      this.isServicesMenuOpen = false;
      this.outsideClickHandler = null;

      this.init();
    }

    init() {
      this.servicesMenu = document.querySelector(SELECTORS.servicesMenu);
      if (!this.servicesMenu) {
        return;
      }

      this.servicesButton = this.servicesMenu.querySelector(SELECTORS.servicesButton);
      this.servicesPanel = this.servicesMenu.querySelector(SELECTORS.servicesPanel);
      this.servicesChevron = this.servicesButton?.querySelector(SELECTORS.servicesChevron);

      this.mobileToggle = document.querySelector(SELECTORS.mobileToggle);
      this.mobileMenu = document.querySelector(SELECTORS.mobileMenu);
      this.mobileServicesBtn = document.querySelector(SELECTORS.mobileServicesBtn);
      this.mobileServicesPanel = document.querySelector(SELECTORS.mobileServicesPanel);

      this.attachEventListeners();
    }

    attachEventListeners() {
      // Desktop services menu
      if (this.servicesButton && this.servicesPanel) {
        this.servicesButton.addEventListener('click', this.handleServicesMenuToggle.bind(this));
        this.outsideClickHandler = this.handleOutsideClick.bind(this);
      }

      // Mobile menu toggle
      if (this.mobileToggle && this.mobileMenu) {
        this.mobileToggle.addEventListener('click', this.handleMobileMenuToggle.bind(this));
      }

      // Mobile services submenu
      if (this.mobileServicesBtn && this.mobileServicesPanel) {
        this.mobileServicesBtn.addEventListener('click', this.handleMobileServicesToggle.bind(this));
      }
    }

    handleServicesMenuToggle(event) {
      if (!event || !this.servicesPanel || !this.servicesButton) {
        return;
      }

      event.preventDefault();
      event.stopPropagation();

      // Toggle state
      this.isServicesMenuOpen = !this.isServicesMenuOpen;

      // Update panel state immediately
      this.servicesPanel.setAttribute('data-open', this.isServicesMenuOpen.toString());
      this.servicesButton.setAttribute('aria-expanded', this.isServicesMenuOpen.toString());

      // Rotate chevron icon
      this.rotateChevron(this.isServicesMenuOpen);

      // Handle outside click listener
      if (this.isServicesMenuOpen) {
        // Use setTimeout to prevent immediate trigger of outside click
        setTimeout(() => {
          document.addEventListener('click', this.outsideClickHandler, true);
        }, 10);
      } else {
        document.removeEventListener('click', this.outsideClickHandler, true);
      }
    }

    handleOutsideClick(event) {
      if (!this.servicesMenu || !this.servicesPanel || !this.servicesButton) {
        return;
      }

      // Don't close if clicking inside the menu
      if (this.servicesMenu.contains(event.target)) {
        return;
      }

      this.closeServicesMenu();
    }

    closeServicesMenu() {
      if (!this.servicesPanel || !this.servicesButton) {
        return;
      }

      this.isServicesMenuOpen = false;
      this.servicesPanel.setAttribute('data-open', 'false');
      this.servicesButton.setAttribute('aria-expanded', 'false');
      this.rotateChevron(false);
      document.removeEventListener('click', this.outsideClickHandler, true);
    }

    rotateChevron(isOpen) {
      if (!this.servicesChevron) {
        return;
      }

      this.servicesChevron.style.transform = isOpen
        ? `rotate(${CONSTANTS.CHEVRON_ROTATION_OPEN})`
        : `rotate(${CONSTANTS.CHEVRON_ROTATION_CLOSE})`;
    }

    handleMobileMenuToggle() {
      if (!this.mobileMenu) {
        return;
      }

      const isHidden = this.mobileMenu.hasAttribute('hidden');

      if (isHidden) {
        this.mobileMenu.removeAttribute('hidden');
      } else {
        this.mobileMenu.setAttribute('hidden', '');
        if (this.mobileServicesPanel) {
          this.mobileServicesPanel.setAttribute('hidden', '');
        }
      }
    }

    handleMobileServicesToggle() {
      if (!this.mobileServicesPanel) {
        return;
      }

      const isHidden = this.mobileServicesPanel.hasAttribute('hidden');

      if (isHidden) {
        this.mobileServicesPanel.removeAttribute('hidden');
      } else {
        this.mobileServicesPanel.setAttribute('hidden', '');
      }
    }

    destroy() {
      if (this.outsideClickHandler) {
        document.removeEventListener('click', this.outsideClickHandler, true);
      }
    }
  }

  /**
   * FAQ Accordion Handler
   */
  class FAQAccordion {
    constructor() {
      this.faqButtons = document.querySelectorAll(SELECTORS.faqButton);
      this.init();
    }

    init() {
      if (this.faqButtons.length === 0) {
        return;
      }

      this.faqButtons.forEach((button) => {
        button.addEventListener('click', () => {
          const content = button.nextElementSibling;
          const icon = button.querySelector('svg');
          const isHidden = content.classList.contains('hidden');

          // Close all other FAQs
          document.querySelectorAll(SELECTORS.faqContent).forEach((item) => {
            if (item !== content) {
              item.classList.add('hidden');
            }
          });
          document.querySelectorAll(`${SELECTORS.faqButton} svg`).forEach((item) => {
            if (item !== icon) {
              item.style.transform = 'rotate(0deg)';
            }
          });

          // Toggle current FAQ
          if (isHidden) {
            content.classList.remove('hidden');
            if (icon) {
              icon.style.transform = 'rotate(180deg)';
            }
          } else {
            content.classList.add('hidden');
            if (icon) {
              icon.style.transform = 'rotate(0deg)';
            }
          }
        });
      });
    }
  }

  /**
   * Article Carousel Handler
   */
  class ArticleCarousel {
    constructor() {
      this.carousel = null;
      this.nextButton = null;
      this.prevButton = null;
      this.init();
    }

    init() {
      this.carousel = document.querySelector(SELECTORS.articleCarousel);
      this.nextButton = document.querySelector(SELECTORS.articleNext);
      this.prevButton = document.querySelector(SELECTORS.articlePrev);

      if (!this.carousel) {
        return;
      }

      this.attachEventListeners();
    }

    attachEventListeners() {
      if (this.nextButton) {
        this.nextButton.addEventListener('click', this.handleNextClick.bind(this));
      }

      if (this.prevButton) {
        this.prevButton.addEventListener('click', this.handlePrevClick.bind(this));
      }
    }

    getScrollAmount() {
      if (!this.carousel) {
        return CONSTANTS.DEFAULT_SCROLL_AMOUNT;
      }

      const focusCard = this.carousel.querySelector(SELECTORS.focusCard);
      if (!focusCard) {
        return CONSTANTS.DEFAULT_SCROLL_AMOUNT;
      }

      return focusCard.clientWidth || CONSTANTS.DEFAULT_SCROLL_AMOUNT;
    }

    handleNextClick() {
      if (!this.carousel) {
        return;
      }

      const scrollAmount = this.getScrollAmount() + CONSTANTS.CAROUSEL_GAP;
      this.carousel.scrollBy({
        left: scrollAmount,
        behavior: 'smooth',
      });
    }

    handlePrevClick() {
      if (!this.carousel) {
        return;
      }

      const scrollAmount = this.getScrollAmount() + CONSTANTS.CAROUSEL_GAP;
      this.carousel.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth',
      });
    }
  }

  /**
   * Portfolio Filter Handler
   */
  class PortfolioFilter {
    constructor() {
      this.filterButtons = document.querySelectorAll(SELECTORS.filterBtn);
      this.portfolioItems = document.querySelectorAll(SELECTORS.portfolioItem);
      this.emptyState = document.querySelector(SELECTORS.emptyState);
      this.portfolioGrid = document.querySelector(SELECTORS.portfolioGrid);
      this.init();
    }

    init() {
      if (this.filterButtons.length === 0 || this.portfolioItems.length === 0) {
        return;
      }

      // Initialize all portfolio items to be visible
      this.portfolioItems.forEach((item) => {
        item.style.display = '';
        item.style.opacity = '1';
        item.style.transform = 'scale(1)';
      });

      this.attachEventListeners();
    }

    attachEventListeners() {
      this.filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
          const filter = button.dataset.filter;

          // Update active button
          this.filterButtons.forEach((btn) => {
            btn.classList.remove('active', 'btn-primary');
            btn.classList.add('btn-outline');
          });
          button.classList.remove('btn-outline');
          button.classList.add('active', 'btn-primary');

          // Filter portfolio items
          this.filterItems(filter);
        });
      });
    }

    filterItems(filter) {
      const visibleItems = [];

      // Collect visible items
      this.portfolioItems.forEach((item) => {
        const matchesFilter = filter === 'all' || item.dataset.category === filter;
        if (matchesFilter) {
          visibleItems.push(item);
        }
      });

      // Hide items that don't match
      this.portfolioItems.forEach((item) => {
        const matchesFilter = filter === 'all' || item.dataset.category === filter;

        if (!matchesFilter) {
          item.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out';
          item.style.opacity = '0';
          item.style.transform = 'scale(0.95)';
          setTimeout(() => {
            item.style.display = 'none';
          }, 300);
        }
      });

      // Show matching items with fade-in animation
      visibleItems.forEach((item, index) => {
        if (item.style.display === 'none') {
          item.style.display = '';
          item.style.opacity = '0';
          item.style.transform = 'scale(0.95)';
        }

        item.style.transition = 'opacity 0.4s ease-in-out, transform 0.4s ease-in-out';
        setTimeout(() => {
          item.style.opacity = '1';
          item.style.transform = 'scale(1)';
        }, index * 50);
      });

      // Show/hide empty state
      setTimeout(() => {
        if (visibleItems.length === 0) {
          this.emptyState?.classList.remove('hidden');
          this.portfolioGrid?.classList.add('hidden');
        } else {
          this.emptyState?.classList.add('hidden');
          this.portfolioGrid?.classList.remove('hidden');
        }
      }, Math.max(400, visibleItems.length * 50 + 100));
    }
  }

  /**
   * Flip Words Animation Handler
   */
  class FlipWordsAnimation {
    constructor() {
      this.words = ['Kami', 'Website', 'Mobile App', 'IT Solutions', 'Terbaik'];
      this.currentIndex = 0;
      this.flipWordElement = document.querySelector(SELECTORS.flipWord);
      this.animationInterval = null;
      this.init();
    }

    init() {
      if (!this.flipWordElement) {
        return;
      }

      this.startAnimation();
    }

    animateWord() {
      if (!this.flipWordElement) {
        return;
      }

      // Exit animation
      this.flipWordElement.style.transition = 'all 0.3s ease-out';
      this.flipWordElement.style.opacity = '0';
      this.flipWordElement.style.transform = 'translateY(-40px) translateX(40px) scale(2)';
      this.flipWordElement.style.filter = 'blur(8px)';

      setTimeout(() => {
        // Change word
        this.currentIndex = (this.currentIndex + 1) % this.words.length;
        this.flipWordElement.textContent = this.words[this.currentIndex];

        // Reset position
        this.flipWordElement.style.transition = 'none';
        this.flipWordElement.style.opacity = '0';
        this.flipWordElement.style.transform = 'translateY(10px)';
        this.flipWordElement.style.filter = 'blur(8px)';

        // Force reflow
        void this.flipWordElement.offsetHeight;

        // Enter animation
        this.flipWordElement.style.transition = 'all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
        this.flipWordElement.style.opacity = '1';
        this.flipWordElement.style.transform = 'translateY(0) translateX(0) scale(1)';
        this.flipWordElement.style.filter = 'blur(0px)';
      }, 300);
    }

    startAnimation() {
      this.animationInterval = setInterval(() => {
        this.animateWord();
      }, 3000);
    }

    stopAnimation() {
      if (this.animationInterval) {
        clearInterval(this.animationInterval);
        this.animationInterval = null;
      }
    }
  }

  /**
   * Main Application Controller
   */
  class App {
    constructor() {
      this.navigationMenu = null;
      this.faqAccordion = null;
      this.articleCarousel = null;
      this.portfolioFilter = null;
      this.flipWordsAnimation = null;
    }

    init() {
      try {
        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
        } else {
          this.initializeComponents();
        }
      } catch (error) {
        console.error('Error initializing application:', error);
      }
    }

    initializeComponents() {
      try {
        this.navigationMenu = new NavigationMenu();
        this.faqAccordion = new FAQAccordion();
        this.articleCarousel = new ArticleCarousel();
        this.portfolioFilter = new PortfolioFilter();
        this.flipWordsAnimation = new FlipWordsAnimation();
      } catch (error) {
        console.error('Error initializing components:', error);
      }
    }

    destroy() {
      if (this.navigationMenu) {
        this.navigationMenu.destroy();
      }
      if (this.flipWordsAnimation) {
        this.flipWordsAnimation.stopAnimation();
      }
    }
  }

  // Initialize application
  const app = new App();
  app.init();

  // Expose app instance for debugging (optional)
  if (typeof window !== 'undefined') {
    window.FirstudioApp = app;
  }
})();

(function () {
  'use strict';

  const root = document.getElementById('ai-chatbot');
  if (!root) {
    return;
  }

  const STORAGE_KEY = 'firsty_chat_session';

  const getSessionToken = () => {
    try {
      const existing = localStorage.getItem(STORAGE_KEY);
      if (existing) {
        return existing;
      }
      const generated = `fst-${crypto.randomUUID()}`;
      localStorage.setItem(STORAGE_KEY, generated);
      return generated;
    } catch (_) {
      return `fst-${Date.now()}-${Math.random().toString(16).slice(2)}`;
    }
  };

  const sessionToken = getSessionToken();

  const toggleButton = root.querySelector('[data-chatbot-toggle]');
  const panel = root.querySelector('[data-chatbot-panel]');
  const closeButton = root.querySelector('[data-chatbot-close]');
  const form = root.querySelector('[data-chatbot-form]');
  const textarea = root.querySelector('[data-chatbot-input]');
  const messagesWrapper = root.querySelector('[data-chatbot-messages]');
  const statusBar = root.querySelector('[data-chatbot-status]');
  const endpoint = root.getAttribute('data-endpoint');
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  if (!endpoint || !csrf || !form || !textarea || !messagesWrapper) {
    root.remove();
    return;
  }

  let isOpen = false;
  let isLoading = false;
  let adminPollTimer = null;

  const history = [
    {
      role: 'system',
      content: 'You are Firsty, an AI concierge for Firstudio (a digital agency in Indonesia). Respond in friendly, concise Indonesian (maksimal 6 kalimat). Berikan solusi praktis dan tawarkan bantuan tim Firstudio bila perlu.',
    },
    {
      role: 'assistant',
      content: 'Halo! Saya Firsty, asisten AI Firstudio. Tanyakan apa saja tentang layanan atau kebutuhan digitalmu.',
    },
  ];

  function setStatus(text) {
    if (!statusBar) {
      return;
    }
    statusBar.textContent = text;
    statusBar.classList.toggle('is-visible', Boolean(text));
  }

  async function sendMessage(message) {
    if (!message || isLoading) {
      return;
    }

    appendMessage('user', message);
    history.push({ role: 'user', content: message });
    textarea.value = '';
    setStatus('Firsty sedang mengetik balasan ...');
    isLoading = true;

    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
          session_token: sessionToken,
          messages: getRecentHistory(),
          latest_message: message,
          check_admin_only: false,
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.error || 'Terjadi kesalahan pada AI');
      }

      if (Array.isArray(data.admin_messages) && data.admin_messages.length) {
        handleAdminMessages(data.admin_messages);
        return;
      }

      if (!data.reply) {
        throw new Error(data.error || 'Terjadi kesalahan pada AI');
      }

      appendMessage('assistant', data.reply);
      history.push({ role: 'assistant', content: data.reply });
    } catch (error) {
      console.error(error);
      appendMessage('assistant', 'Maaf, saya mengalami kendala. Coba lagi sebentar ya atau hubungi tim Firstudio lewat formulir kontak.');
    } finally {
      isLoading = false;
      setStatus('');
    }
  }

  function handleAdminMessages(messages) {
    messages.forEach((adminMessage) => {
      appendMessage('assistant', `(Balasan Admin) ${adminMessage.content}`);
      history.push({ role: 'assistant', content: adminMessage.content });
    });
  }

  async function syncAdminMessages() {
    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
          session_token: sessionToken,
          messages: [],
          latest_message: null,
          check_admin_only: true,
        }),
      });

      if (!response.ok) {
        return;
      }

      const data = await response.json();
      if (Array.isArray(data.admin_messages) && data.admin_messages.length) {
        handleAdminMessages(data.admin_messages);
      }
    } catch (error) {
      console.error('syncAdminMessages error', error);
    }
  }

  function setOpen(state) {
    isOpen = state;
    root.classList.toggle('ai-chatbot--open', state);
    if (state) {
      textarea.focus();
      syncAdminMessages();
      startAdminPolling();
    } else {
      stopAdminPolling();
      textarea.blur();
    }
  }

  function startAdminPolling() {
    if (adminPollTimer) {
      return;
    }
    adminPollTimer = setInterval(() => {
      if (!isLoading) {
        syncAdminMessages();
      }
    }, 7000);
  }

  function stopAdminPolling() {
    if (adminPollTimer) {
      clearInterval(adminPollTimer);
      adminPollTimer = null;
    }
  }

  function createMessageElement(role, text) {
    const wrapper = document.createElement('div');
    wrapper.className = `ai-chatbot__message ai-chatbot__message--${role}`;

    const avatar = document.createElement('div');
    avatar.className = 'ai-chatbot__avatar';
    avatar.textContent = role === 'assistant' ? 'AI' : role === 'admin' ? 'ADM' : 'Kamu';

    const bubble = document.createElement('div');
    bubble.className = 'ai-chatbot__bubble';

    text.split(/\n/).forEach((line, index, arr) => {
      const span = document.createElement('span');
      span.textContent = line;
      bubble.appendChild(span);
      if (index < arr.length - 1) {
        bubble.appendChild(document.createElement('br'));
      }
    });

    wrapper.appendChild(avatar);
    wrapper.appendChild(bubble);
    return wrapper;
  }

  function appendMessage(role, text) {
    const messageEl = createMessageElement(role, text);
    messagesWrapper.appendChild(messageEl);
    messagesWrapper.scrollTo({
      top: messagesWrapper.scrollHeight,
      behavior: 'smooth',
    });
  }

  appendMessage('assistant', history[1].content);

  function getRecentHistory() {
    const preserved = history.slice(-8);
    const systemMessage = history[0];
    return [systemMessage, ...preserved.filter((msg) => msg.role !== 'system')];
  }

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    const value = textarea.value.trim();
    if (value.length === 0 || isLoading) {
      return;
    }
    sendMessage(value);
  });

  textarea.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: false }));
    }
  });

  toggleButton?.addEventListener('click', () => {
    setOpen(!isOpen);
  });

  closeButton?.addEventListener('click', () => setOpen(false));

  syncAdminMessages();
})();
