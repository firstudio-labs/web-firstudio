# Product Requirements Document (PRD)
## Website Firstudio — Improvement Plan

**Version:** 1.0  
**Status:** Draft  
**Last Updated:** 2026-06-03  

---

## 1. Overview

This document outlines the product requirements for improving the Firstudio website based on identified UX and content issues. The goal is to create a more consistent, polished, and user-friendly experience across all pages.

---

## 2. Goals & Success Metrics

| Goal | Success Metric |
|------|---------------|
| Language consistency across the website | 100% of UI text uses one language (or multilingual toggle works correctly) |
| Improved portfolio page UX | Users can view full project descriptions without truncation |
| Smoother FAQ interaction | All FAQ items have hover effects |
| Consistent UI components | Arrow icons are uniform in size and alignment |

---

## 3. Pages & Feature Requirements

### 3.1 Home Page

#### 3.1.1 Language Consistency (Priority: High)

**Problem:**  
The website inconsistently mixes Bahasa Indonesia and English across the navbar, navlinks, footer, and body content. For example, the navbar uses English while navlinks and body content use Bahasa Indonesia.

**Requirements:**
- [ ] Choose a single primary language for all website content (navbar, navlinks, footer, body)
- [ ] **OR** implement a multilingual toggle feature that allows users to switch between Bahasa Indonesia and English
- [ ] All content must be consistent with the selected language setting at all times

**Acceptance Criteria:**
- No language mixing on any single page
- If multilingual: language preference persists across page navigation
- Language toggle (if implemented) is visible and accessible in the navbar

---

#### 3.1.2 "Our Services" Section — Image Content (Priority: Medium)

**Problem:**  
Service images contain both an illustration and a title, while the section beside the image already displays the title — causing redundancy.

**Requirements:**
- [ ] Remove the title text from within service images
- [ ] Images should display illustration only (no embedded title text)

**Acceptance Criteria:**
- Service images contain only the illustration graphic
- Section titles are displayed solely in the adjacent text area

---

#### 3.1.3 "Article" Section — Arrow Icon Alignment (Priority: Low)

**Problem:**  
Arrow icons in the article section are inconsistent in size and are misaligned with each other.

**Requirements:**
- [ ] Standardize all arrow icon sizes to a single defined value
- [ ] Ensure all arrow icons are vertically aligned

**Acceptance Criteria:**
- All arrow icons share identical dimensions
- Icons are visually aligned (vertically centered or baseline-aligned consistently)

---

#### 3.1.4 "Customer Testimonial" Section (Priority: Medium)

**Problem:**  
The testimonial section lacks a section heading and testimonial content is incomplete or contains spelling errors.

**Requirements:**
- [ ] Add a clear section title/heading (e.g., "What Our Clients Say")
- [ ] Ensure each testimonial contains complete, well-written content
- [ ] Review and correct all spelling/grammar in testimonials

**Acceptance Criteria:**
- Section heading is present and visually consistent with other section headings
- Each testimonial is complete (name, role, full review text)
- No spelling or grammatical errors in testimonial content

---

### 3.2 Services Page

#### 3.2.1 FAQ Section — Hover Effect (Priority: Low)

**Problem:**  
FAQ items have no hover interaction, making the section feel static and less engaging.

**Requirements:**
- [ ] Add hover effect to each FAQ question item
- [ ] Hover state should feel smooth and visually polished

**Acceptance Criteria:**
- Hover effect is applied to all FAQ items
- Animation/transition is smooth (e.g., background color change, subtle scale, or border highlight)

---

### 3.3 Portfolio Page

#### 3.3.1 Project Card — Truncated Descriptions (Priority: High)

**Problem:**  
Each project card displays a service type, title, and description — but the description text is cut off.

**Requirements:**
- [ ] Remove the description text from the project card view
- [ ] Each card should display only: service type + project title
- [ ] Add a navlink/CTA button labeled "Detail" or "Selengkapnya" to each card

**Option A — Pop-up Modal:**
- [ ] Clicking the navlink opens a modal/pop-up displaying the full project description
- [ ] Modal includes project title, service type, full description, and a "Visit Website" CTA

**Option B — Dedicated Project Page + Hover Effect:**
- [ ] Add a hover effect when the cursor is over a project card
- [ ] Clicking the navlink navigates to a dedicated project detail page
- [ ] Project detail page includes full description and a "Visit Website" / "Arahkan ke Website" CTA button

**Acceptance Criteria:**
- No truncated text visible on portfolio cards
- Users can access the full project description via a single click
- "Visit Website" CTA links to the actual live project URL
- One approach (A or B) is consistently applied to all portfolio items

---

## 4. Out of Scope

- New page creation (Contact, About redesign, etc.)
- Backend/CMS changes
- Performance optimization
- SEO improvements

---

## 5. Open Questions

1. Which language should be the primary language — Bahasa Indonesia or English?
2. Should multilingual support be implemented immediately or in a future phase?
3. Portfolio detail view: Option A (modal) or Option B (dedicated page + hover)?
4. What is the correct/complete content for the customer testimonials section?

---

## 6. Dependencies

- Design specifications from `design.md`
- Final approved testimonial content from the content/marketing team
- Confirmed URLs for portfolio project links
