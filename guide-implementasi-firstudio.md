# Guide Implementasi — Firstudio Brand Refactor + GSAP Animations

> Panduan step-by-step. Tinggal copy paste perintahnya.

---

## Bagian 1 — Install GSAP

```bash
cd /home/ubuntu/.hermes/web-firstudio
npm install gsap
```

---

## Bagian 2 — Update Tailwind Config

Buka `tailwind.config.js`, ganti bagian `colors` jadi:

```js
colors: {
    brand: {
        DEFAULT: '#001f54',
        accent: '#337eff',
        light: '#70a5ff',
    },
    surface: '#000000',
    surfaceDim: '#0a0a0a',
    navy: '#001f54',
    'navy-dark': '#000814',
    'navy-surface': '#0a1a2f',
},
```

---

## Bagian 3 — Buat File `resources/css/firstudio.css`

```css
/* =============================================
   Firstudio Design System
   Brand: Navy #001f54 + Blue #337eff
   Fonts: Poppins (headings), Clear Sans (body)
   ============================================= */

:root {
  --navy: #001f54;
  --navy-dark: #000814;
  --navy-surface: #0a1a2f;
  --blue: #337eff;
  --blue-light: #70a5ff;
  --blue-dark: #2563eb;
  --white: #ffffff;
  --slate: #94a3b8;
  --font-primary: 'Poppins', sans-serif;
  --font-secondary: 'Clear Sans', sans-serif;
}

/* Hero Section — Navy Theme */
.hero-glow {
  background: radial-gradient(
    circle,
    rgba(0, 31, 84, 0.4) 0%,
    rgba(0, 31, 84, 0.1) 50%,
    transparent 100%
  );
}

.hero-spotlight {
  background: radial-gradient(
    circle,
    rgba(51, 126, 255, 0.12) 0%,
    rgba(51, 126, 255, 0.03) 50%,
    transparent 100%
  );
}

/* Buttons */
.btn-primary {
  background: linear-gradient(135deg, #337eff, #2563eb);
  box-shadow: 0 10px 25px rgba(51, 126, 255, 0.3);
  border: 1px solid rgba(51, 126, 255, 0.4);
  color: #ffffff;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  box-shadow: 0 15px 35px rgba(51, 126, 255, 0.4);
  transform: translateY(-2px);
}

/* Service Cards — Navy */
.service-card {
  border: 1px solid rgba(51, 126, 255, 0.1);
  background: rgba(10, 26, 47, 0.6);
  backdrop-filter: blur(12px);
  transition: all 0.3s ease;
}

.service-card:hover {
  border-color: rgba(51, 126, 255, 0.4);
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(0, 31, 84, 0.3);
}

/* Brand Stripe */
.brand-stripe {
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #337eff, #70a5ff);
  border-radius: 2px;
}

/* Counter */
.counter {
  font-family: 'Poppins', sans-serif;
  font-weight: 800;
  font-size: 3rem;
  line-height: 1;
  background: linear-gradient(135deg, #337eff, #70a5ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Navy CTA */
.cta-navy-card {
  background: linear-gradient(135deg, #001f54 0%, #002d7a 100%);
  border: 1px solid rgba(51, 126, 255, 0.3);
}

/* Navbar */
.navbar {
  background-color: rgba(0, 8, 20, 0.3);
  backdrop-filter: blur(20px) saturate(180%);
  border-bottom: 1px solid rgba(51, 126, 255, 0.05);
}
```

---

## Bagian 4 — Update `resources/css/app.css`

**1.** Pindahkan import font ke PALING ATAS (sebelum @tailwind):

```css
/* Import Fonts */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
@import url("https://fonts.cdnfonts.com/css/clear-sans");

/* Import Design System */
@import "./firstudio.css";

@tailwind base;
@tailwind components;
@tailwind utilities;
```

**2.** Ganti warna cyan #06b6d4 → blue #337eff di 4 tempat:

| Baris | Sebelum | Sesudah |
|-------|---------|---------|
| nav-link::after | `background-color: #06b6d4;` | `background-color: #337eff;` |
| *:focus-visible | `outline: 2px solid #06b6d4;` | `outline: 2px solid #337eff;` |
| ::selection | `background-color: #06b6d4;` | `background-color: #337eff;` |
| ::-moz-selection | `background-color: #06b6d4;` | `background-color: #337eff;` |

---

## Bagian 5 — Fix Purple → Blue di Service Pages

### `resources/views/page_web/layanan/mobile.blade.php`

| Baris | Sebelum (❌) | Sesudah (✅) |
|-------|-------------|-------------|
| Badge | `border-purple-500/30 bg-purple-500/10 text-purple-400` | `border-blue-500/30 bg-blue-500/10 text-blue-400` |
| Image glow | `from-purple-500/20 to-pink-500/20` | `from-blue-500/20 to-blue-400/20` |

### `resources/views/page_web/layanan/itoutsourcing.blade.php`

| Baris | Sebelum (❌) | Sesudah (✅) |
|-------|-------------|-------------|
| Badge | `border-purple-500/30 bg-purple-500/10 text-purple-400` | `border-blue-500/30 bg-blue-500/10 text-blue-400` |

### `resources/views/page_web/layanan/website.blade.php`

| Baris | Sebelum (❌) | Sesudah (✅) |
|-------|-------------|-------------|
| Image glow | `from-blue-500/20 to-purple-500/20` | `from-blue-500/20 to-blue-400/20` |

---

## Bagian 6 — Fix Purple Focus di Admin Components

### `resources/views/components/input.blade.php`

Ganti `focus:ring-purple-500 focus:border-purple-500` → `focus:ring-blue-500 focus:border-blue-500` (2 tempat)

### `resources/views/components/textarea.blade.php`

Sama, ganti `focus:ring-purple-500 focus:border-purple-500` → `focus:ring-blue-500 focus:border-blue-500`

---

## Bagian 7 — Buat File `resources/js/app.js` (GSAP Animations)

```js
import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    initFirstudioAnimations();
});

/* ══════════════════════════════════════════
   HERO — Sequential Timeline + Floating Glow
   ══════════════════════════════════════════ */
function initHeroAnimation() {
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    tl.fromTo('.hero-glow', 
        { scale: 0, opacity: 0 },
        { scale: 1, opacity: 0.8, duration: 1.5, ease: 'power2.out' }
    )
    .fromTo('.hero-spotlight',
        { scale: 0.5, opacity: 0 },
        { scale: 1, opacity: 1, duration: 1.8, ease: 'power2.out' },
        '-=1.2'
    )
    .from('.hero-heading', { y: 80, opacity: 0, duration: 1 }, '-=0.8')
    .from('.hero-subtitle', { y: 40, opacity: 0, duration: 0.8 }, '-=0.5')
    .from('.hero-cta', { y: 30, opacity: 0, duration: 0.6 }, '-=0.3');
}

function initHeroFloat() {
    gsap.to('.hero-spotlight', {
        y: 25, x: 15,
        duration: 7, repeat: -1, yoyo: true,
        ease: 'sine.inOut',
    });
    gsap.to('.hero-glow', {
        scale: 1.15, opacity: 0.6,
        duration: 5, repeat: -1, yoyo: true,
        ease: 'sine.inOut',
    });
}

/* ══════════════════════════════════════════
   SERVICES — Stagger Cards
   ══════════════════════════════════════════ */
function initServicesAnimation() {
    gsap.from('.service-card', {
        scrollTrigger: { trigger: '.services-section', start: 'top 80%' },
        y: 60, opacity: 0, duration: 0.8, stagger: 0.15,
        ease: 'power3.out',
    });
}

/* ══════════════════════════════════════════
   ABOUT — Left/Right Split
   ══════════════════════════════════════════ */
function initAboutAnimation() {
    const tl = gsap.timeline({
        scrollTrigger: { trigger: '.about-section', start: 'top 80%' },
    });
    tl.from('.brand-stripe', { x: '-100%', duration: 0.8, ease: 'power3.out' })
    .from('.about-text', { x: -60, opacity: 0, duration: 0.8 }, '-=0.5')
    .from('.about-visual', { x: 60, opacity: 0, duration: 0.8 }, '-=0.5');
}

/* ══════════════════════════════════════════
   PORTFOLIO — Zoom In
   ══════════════════════════════════════════ */
function initPortfolioAnimation() {
    gsap.from('.portfolio-card', {
        scrollTrigger: { trigger: '.portfolio-grid', start: 'top 85%' },
        scale: 0.85, opacity: 0,
        duration: 0.6, stagger: 0.1,
        ease: 'back.out(1.7)',
    });
}

/* ══════════════════════════════════════════
   COUNTER — Angka Naik Otomatis
   ══════════════════════════════════════════ */
function initCounterAnimation() {
    gsap.utils.toArray('.counter').forEach(counter => {
        const target = parseInt(counter.dataset.target);
        gsap.from(counter, {
            scrollTrigger: { trigger: counter, start: 'top 85%' },
            textContent: 0, duration: 2, ease: 'power2.out',
            snap: { textContent: 1 },
            onUpdate: function () {
                counter.textContent = Math.ceil(this.targets()[0].textContent);
            },
        });
    });
}

/* ══════════════════════════════════════════
   TESTIMONIALS — Flip 3D
   ══════════════════════════════════════════ */
function initTestimonialsAnimation() {
    gsap.from('.testimonial-card', {
        scrollTrigger: { trigger: '.testimonials-section', start: 'top 80%' },
        rotationY: 90, opacity: 0,
        duration: 0.8, stagger: 0.2,
        ease: 'power2.out',
    });
}

/* ══════════════════════════════════════════
   CTA — Zoom In
   ══════════════════════════════════════════ */
function initCTAAnimation() {
    const tl = gsap.timeline({
        scrollTrigger: { trigger: '.cta-section', start: 'top 85%' },
    });
    tl.from('.cta-card', { scale: 0.9, opacity: 0, duration: 0.8, ease: 'power3.out' })
    .from('.cta-title', { y: 30, opacity: 0, duration: 0.6 }, '-=0.4')
    .from('.cta-button', { y: 20, opacity: 0, duration: 0.5 }, '-=0.2');
}

/* ══════════════════════════════════════════
   NAVBAR — Hide/Show on Scroll
   ══════════════════════════════════════════ */
function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');

    ScrollTrigger.create({
        start: 'top -50',
        onUpdate: (self) => {
            const progress = Math.min(self.progress * 2, 1);
            gsap.to(navbar, {
                backgroundColor: `rgba(0, 24, 58, ${0.3 + progress * 0.6})`,
                backdropFilter: `blur(${10 + progress * 20}px)`,
                duration: 0.2,
            });
        },
    });

    ScrollTrigger.create({
        start: 'top -100',
        onUpdate: (self) => {
            if (self.direction === -1) {
                gsap.to(navbar, { y: 0, duration: 0.3, ease: 'power2.out' });
            } else if (self.direction === 1 && window.scrollY > 150) {
                gsap.to(navbar, { y: -100, duration: 0.3, ease: 'power2.in' });
            }
        },
    });
}

/* ══════════════════════════════════════════
   MASTER INIT
   ══════════════════════════════════════════ */
function initFirstudioAnimations() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    initHeroAnimation();
    initHeroFloat();
    initServicesAnimation();
    initAboutAnimation();
    initPortfolioAnimation();
    initCounterAnimation();
    initTestimonialsAnimation();
    initCTAAnimation();
    initNavbarScroll();
}
```

---

## Bagian 8 — Build

```bash
npm run build
```

---

## Ringkasan File yang Dimodifikasi

| # | File | Action |
|---|------|--------|
| 1 | `tailwind.config.js` | Edit — brand colors |
| 2 | `resources/css/firstudio.css` | **Buat baru** — design system |
| 3 | `resources/css/app.css` | Edit — import order + cyan→blue |
| 4 | `resources/js/app.js` | Edit total — GSAP animations |
| 5 | `mobile.blade.php` | Edit — purple→blue |
| 6 | `website.blade.php` | Edit — purple→blue |
| 7 | `itoutsourcing.blade.php` | Edit — purple→blue |
| 8 | `input.blade.php` | Edit — focus purple→blue |
| 9 | `textarea.blade.php` | Edit — focus purple→blue |
