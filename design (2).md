# Design Specification
## Website Firstudio — Improvement Plan

**Version:** 1.0  
**Status:** Draft  
**Last Updated:** 2026-06-03  
**Linked PRD:** `prd.md`

---

## 1. Design Principles

1. **Consistency** — Language, spacing, icon sizes, and typography must be uniform across all pages.
2. **Clarity** — Avoid redundant information (e.g., text duplicated in both image and adjacent section).
3. **Interactivity** — Key UI elements should respond to user interaction with smooth transitions.
4. **Scannability** — Portfolio cards and service sections should be easy to scan at a glance.

---

## 2. Global Design Changes

### 2.1 Language Consistency

**Scope:** Navbar, Navlinks, Footer, Body Content

**Design Decision:**  
Pick **one** of the following approaches before implementation begins:

| Approach | Description |
|----------|-------------|
| **Single Language** | All UI text is written in one language (Bahasa Indonesia recommended for local audience, English for international) |
| **Multilingual Toggle** | A language switcher in the navbar allows users to toggle between Bahasa Indonesia and English |

**Multilingual Toggle — UI Spec (if applicable):**

```
[ ID | EN ]   ← Toggle placed in the top-right of the navbar
```

- **Placement:** Navbar, far right, same row as other navlinks
- **Style:** Pill-shaped toggle or text link with separator (e.g., `ID | EN`)
- **Behavior:** Clicking changes all visible text; preference stored in `localStorage`
- **Default:** Bahasa Indonesia

---

## 3. Home Page

### 3.1 "Our Services" Section — Image Treatment

**Current state:** Service images contain an embedded illustration + title text overlay.  
**Target state:** Images contain only the illustration. Titles live in the adjacent text block only.

**Design Spec:**

| Property | Spec |
|----------|------|
| Image content | Illustration only (no text, no title overlay) |
| Aspect ratio | Maintain original aspect ratio |
| Title placement | Adjacent text block (already present — no change needed) |

**Implementation note for AI agent:**  
> Remove any `<figcaption>`, `<p>`, or `<span>` elements rendered inside or overlapping the service image container. Do not alter the illustration asset itself.

---

### 3.2 "Article" Section — Arrow Icon Standardization

**Current state:** Arrow icons are inconsistent in size and vertical alignment.

**Design Spec:**

| Property | Spec |
|----------|------|
| Icon size | `20px × 20px` (or match the design system's icon unit) |
| Alignment | `vertical-align: middle` or `align-items: center` in flex container |
| Icon source | Keep existing icon; apply uniform `width` and `height` |

**CSS Reference:**

```css
.article-arrow-icon {
  width: 20px;
  height: 20px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
```

---

### 3.3 "Customer Testimonial" Section

**Current state:** No section heading; testimonials are incomplete or contain errors.

**Design Spec:**

| Element | Spec |
|---------|------|
| Section heading | Add heading text: `"Apa Kata Klien Kami"` / `"What Our Clients Say"` |
| Heading style | Match existing section heading typography (H2 or equivalent) |
| Testimonial card | Name, role/company, star rating (optional), full review text |
| Content | Complete, proofread content — no truncation |

**Testimonial Card Structure:**

```
┌───────────────────────────────────────┐
│  ⭐⭐⭐⭐⭐                             │
│                                       │
│  "Full testimonial text goes here.    │
│   Complete sentences, no typos."      │
│                                       │
│  — Client Name                        │
│    Role, Company                      │
└───────────────────────────────────────┘
```

---

## 4. Services Page

### 4.1 FAQ Section — Hover Effect

**Current state:** FAQ items are static with no hover feedback.

**Design Spec:**

| Property | Spec |
|----------|------|
| Trigger | `hover` on each FAQ item row |
| Effect | Background color transition + subtle border or shadow |
| Duration | `200ms–300ms` ease-in-out |
| Cursor | `pointer` |

**CSS Reference:**

```css
.faq-item {
  cursor: pointer;
  border-radius: 8px;
  transition: background-color 0.25s ease, box-shadow 0.25s ease;
}

.faq-item:hover {
  background-color: rgba(0, 0, 0, 0.04); /* adjust to brand color */
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}
```

---

## 5. Portfolio Page

### 5.1 Project Card Redesign

**Current state:** Cards show service type + title + truncated description.  
**Target state:** Cards show service type + title only, with a CTA for full detail.

**Card Design Spec:**

```
┌─────────────────────────────────┐
│  [Project Image / Thumbnail]    │
│                                 │
│  Web Design          ← tag/badge│
│  Project Title Here             │
│                                 │
│  [ Detail →  ]      ← CTA link  │
└─────────────────────────────────┘
```

| Element | Spec |
|---------|------|
| Service type | Small badge/tag, top or bottom of image |
| Project title | H3 or equivalent, bold |
| Description | **Hidden from card view** |
| CTA label | `"Detail"` or `"Selengkapnya"` |
| CTA style | Text link with arrow icon, or ghost button |

---

### 5.2 Option A — Modal Detail View

**Trigger:** Click on `"Detail"` / `"Selengkapnya"` CTA

**Modal Design Spec:**

```
┌──────────────────────────────────────┐
│  Project Title Here            [✕]   │
├──────────────────────────────────────┤
│  [Project Image]                     │
│                                      │
│  Service Type: Web Design            │
│                                      │
│  Full description text here.         │
│  Complete and untruncated.           │
│                                      │
│  [ Kunjungi Website → ]              │
└──────────────────────────────────────┘
```

| Property | Spec |
|----------|------|
| Overlay | Semi-transparent dark backdrop (`rgba(0,0,0,0.5)`) |
| Close button | Top-right `✕` icon |
| Close trigger | Click backdrop or press `Escape` |
| Max width | `600px` (centered) |
| Animation | Fade in + slight scale up (`200ms`) |
| CTA | Primary button — `"Kunjungi Website"` / `"Visit Website"` |

---

### 5.3 Option B — Card Hover + Dedicated Project Page

**Hover Effect on Card:**

| Property | Spec |
|----------|------|
| Effect | Image scales up slightly + overlay appears |
| Scale | `transform: scale(1.03)` |
| Overlay | Semi-transparent with `"Lihat Detail"` label |
| Duration | `300ms` ease |

**CSS Reference:**

```css
.portfolio-card {
  overflow: hidden;
  transition: transform 0.3s ease;
}

.portfolio-card:hover {
  transform: scale(1.03);
}

.portfolio-card-overlay {
  opacity: 0;
  transition: opacity 0.3s ease;
}

.portfolio-card:hover .portfolio-card-overlay {
  opacity: 1;
}
```

**Project Detail Page Layout:**

```
[Full-width project image / banner]

Project Title
Service Type Tag

Full project description paragraph(s).

[ Arahkan ke Website → ]
```

| Element | Spec |
|---------|------|
| Layout | Single column, max-width `800px`, centered |
| CTA label | `"Arahkan ke Website"` / `"Visit Website"` |
| CTA style | Primary button, links to live project URL |
| Back navigation | Breadcrumb or back arrow to Portfolio page |

---

## 6. Component Decisions Summary

| Component | Decision Needed | Options |
|-----------|----------------|---------|
| Language | Single or multilingual? | Single (ID/EN) or Toggle |
| Portfolio detail | Modal or page? | Option A (modal) or Option B (page + hover) |

---

## 7. Notes for AI Agent

- **Do not** remove or replace illustration assets; only adjust surrounding markup.
- When implementing the multilingual toggle, use `localStorage` or a state management solution — do not rely on page reload.
- For the modal (Option A), trap keyboard focus inside the modal when open for accessibility.
- Arrow icon size should reference the existing design token if one exists; use `20px` as a safe fallback.
- All hover transitions should respect `prefers-reduced-motion` media query:

```css
@media (prefers-reduced-motion: reduce) {
  * {
    transition: none !important;
    animation: none !important;
  }
}
```
