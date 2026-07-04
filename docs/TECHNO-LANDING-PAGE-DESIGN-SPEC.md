# Techno Landing Page - Design Specification

**Document Version:** 1.0  
**Date:** 2026-07-03  
**Status:** Approved - Ready for Implementation  
**Author:** Claude (AI Design Assistant)

---

## 1. Design Decisions Summary

### 1.1 Aesthetic Direction
**Choice: Industrial Precision**

Grounded in the world of precision manufacturing and engineering:
- Blueprint grid patterns as decorative elements
- Technical typography with monospace accents for specs
- Clean lines, structured layouts
- Monochromatic palette with bold accent colors

### 1.2 Strategic Priority
**Choice: Brand Awareness → Trust → Conversion**

Rationale:
- B2B automotive = trust-first audience
- Techno is established (since 2003) — not a startup needing to explain everything
- Strong brand awareness naturally leads to conversions

### 1.3 Hero Layout
**Choice: Split Hero**

```
┌──────────────────────────────────────────────────────────┐
│ ┌─────────────────────┐  ┌────────────────────────────┐ │
│ │                     │  │                            │ │
│ │  [Blueprint Grid]   │  │   [Hero Image]             │ │
│ │                     │  │   machinery / factory       │ │
│ │  INDUSTRIAL         │  │                            │ │
│ │  SOLUTIONS          │  │                            │ │
│ │                     │  │                            │ │
│ │  Your Trusted       │  │                            │ │
│ │  Partner Since 2003 │  │                            │ │
│ │                     │  │                            │ │
│ │  [CTA Button]       │  │                            │ │
│ │                     │  │                            │ │
│ │  ISO | IATF | AS9100│  │                            │ │
│ └─────────────────────┘  └────────────────────────────┘ │
└──────────────────────────────────────────────────────────┘
```

### 1.4 Color Palette

| Token | Color Name | Hex Code | Usage |
|-------|------------|----------|-------|
| `--color-primary` | Deep Blue | `#1565C0` | Primary actions, headings, icons |
| `--color-primary-dark` | Darker Blue | `#0D47A1` | Hover states, emphasis |
| `--color-accent` | Bold Red | `#D32F2F` | CTAs, highlights, brand accent |
| `--color-accent-hover` | Darker Red | `#B71C1C` | Hover states |
| `--color-dark` | Rich Black | `#121212` | Dark section backgrounds |
| `--color-dark-secondary` | Dark Gray | `#1E1E1E` | Card backgrounds in dark sections |
| `--color-light` | Off-White | `#FAFAFA` | Light section backgrounds |
| `--color-light-secondary` | Light Gray | `#F5F5F5` | Alternate sections |
| `--color-text-primary` | Near Black | `#212121` | Body text |
| `--color-text-secondary` | Gray | `#6B7280` | Secondary text, captions |
| `--color-border` | Border Gray | `#E5E7EB` | Borders, dividers |
| `--color-white` | Pure White | `#FFFFFF` | Text on dark, cards |

**Source:** Based on company logo colors:
- Blue diamonds → Primary blue
- Red "TECHNO" text → Accent red

### 1.5 Typography

**Choice: Poppins (1 font only)**
- Rationale: Easier maintenance, consistent brand identity
- Weight variations create hierarchy:
  - **Black (900):** Hero headlines
  - **Bold (700):** Section headings, card titles
  - **SemiBold (600):** Subheadings, emphasis
  - **Medium (500):** Labels, buttons
  - **Regular (400):** Body text
  - **Light (300):** Captions, fine print

### 1.6 Section Structure

| Order | Section | Purpose |
|-------|---------|---------|
| 1 | **Hero (Split)** | Brand statement + immediate value prop + CTA |
| 2 | **Stats Bar** | Numbers credibility (20+ tahun, 500+ proyek, 50+ mitra) |
| 3 | **Why Choose Us** | 3-4 key differentiators |
| 4 | **Products/Services** | Grid showcase of capabilities |
| 5 | **Partners & Certifications** | Social proof (logos, ISO badges) |
| 6 | **About Preview** | Company story snippet + link |
| 7 | **CTA Section** | Final conversion push |
| 8 | **Footer** | Contact info, links |

### 1.7 Animations & Interactions

| Element | Animation | Details |
|---------|-----------|---------|
| **Scroll Animations** | AOS - Fade In | Subtle, professional, not overwhelming |
| **Card Hover** | Lift + Shadow | translateY(-4px) + enhanced shadow |
| **Logo Marquee** | Horizontal scroll | Pause on hover, fade edges |
| **Hero Image** | Split layout | Left: blueprint + content, Right: image |

---

## 2. Component Specifications

### 2.1 Design Tokens (CSS Variables)

```css
:root {
    /* Colors */
    --color-primary: #1565C0;
    --color-primary-dark: #0D47A1;
    --color-primary-light: #42A5F5;
    --color-accent: #D32F2F;
    --color-accent-hover: #B71C1C;
    --color-dark: #121212;
    --color-dark-secondary: #1E1E1E;
    --color-light: #FAFAFA;
    --color-light-secondary: #F5F5F5;
    --color-text-primary: #212121;
    --color-text-secondary: #6B7280;
    --color-border: #E5E7EB;
    --color-white: #FFFFFF;

    /* Shadows */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.04);
    --shadow-card: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.05);
    --shadow-card-hover: 0 4px 8px rgba(0, 0, 0, 0.1), 0 12px 24px rgba(0, 0, 0, 0.08);

    /* Transitions */
    --transition-fast: 0.15s ease;
    --transition-base: 0.25s ease;
    --transition-slow: 0.4s ease;

    /* Border Radius */
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;
    --radius-full: 9999px;
}
```

### 2.2 Typography Scale

```css
/* Display - Hero Headlines */
.text-display {
    font-family: 'Poppins', sans-serif;
    font-weight: 900;
    font-size: 4rem;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

/* H1 - Section Titles */
.text-h1 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    line-height: 1.2;
}

/* H2 - Subsection Titles */
.text-h2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    line-height: 1.3;
}

/* H3 - Card Titles */
.text-h3 {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.5rem;
    line-height: 1.4;
}

/* Body */
.text-body {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 1rem;
    line-height: 1.6;
}

/* Caption */
.text-caption {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 0.875rem;
    line-height: 1.5;
}

/* Eyebrow - Section Labels */
.text-eyebrow {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--color-accent);
}
```

### 2.3 Blueprint Grid Pattern

```css
.blueprint-grid {
    position: relative;
}

.blueprint-grid::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(21, 101, 192, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(21, 101, 192, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 1;
}
```

### 2.4 Card Component

```css
.card-elevated {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
    transition:
        transform var(--transition-base),
        box-shadow var(--transition-base);
}

.card-elevated:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-card-hover);
}
```

---

## 3. Page-by-Page Specifications

### 3.1 Index Page (Home)

#### Hero Section
- **Layout:** Split (50/50 or 40/60)
- **Left Side:**
  - Blueprint grid background overlay
  - Eyebrow: "Industrial Solutions Since 2003"
  - Headline: "TECHNO" in Black weight, large
  - Subheadline: Value proposition
  - CTA Button: Red accent color
  - Trust badges: ISO, IATF, AS9100 logos
- **Right Side:**
  - High-quality machinery/industrial image
  - Subtle gradient overlay

#### Stats Bar
- **Background:** Primary blue gradient
- **Layout:** 3-4 stats in a row
- **Content:**
  - 20+ Years Experience
  - 500+ Projects Completed
  - 50+ Global Partners
  - ISO 9001 Certified

#### Why Choose Us
- **Layout:** 3-column grid
- **Cards with icons:**
  - Engineering + Sales (comprehensive solutions)
  - Global Network (international brands, local support)
  - ISO Certified (quality assurance)

#### Products/Services
- **Layout:** Grid (3 columns desktop, 2 tablet, 1 mobile)
- **Card Content:** Icon + Title + Description
- **Hover:** Lift effect

#### Partners & Certifications
- **Layout:** Logo marquee + Certification badges
- **Content:**
  - Client logos (Honda, Astra, etc.)
  - Distributor logos
  - Certification badges (ISO, AS9100D, IATF)

#### About Preview
- **Layout:** 2 columns (text + image) or centered with gradient background
- **Content:** Brief company story
- **CTA:** "Learn More" button

#### CTA Section
- **Background:** Dark with gradient
- **Content:** Compelling headline + CTA button
- **Layout:** Centered, full-width

### 3.2 About Page
- **Hero:** Full-width with blueprint overlay
- **Content Sections:**
  - Company overview
  - Philosophy cards (Customer Satisfaction, Quality, Innovation)
  - Mission/Vision
  - Timeline (company history)

### 3.3 Contact Page
- **Hero:** Consistent with other pages
- **Layout:** 2 columns (Contact info + Form)
- **Contact Cards:** Phone, Email, Address with icons
- **Form:** Name, Email, Phone, Subject dropdown, Message
- **Map:** Embedded Google Maps

### 3.4 Engineering Services Page
- **Hero:** Consistent style
- **Content:** Service cards in grid layout
- **Services:**
  - Jig / Fixtures
  - Assembly S/A Machine
  - Nut Runner Assembly Machine
  - Trimming Assembly Line
  - Preparation Line
  - Aluminum Profile

---

## 4. Implementation Status

| Component | Status | Notes |
|-----------|--------|-------|
| Design Tokens (CSS) | ✅ Completed | Updated variables.scss and app.css |
| Color Palette | ✅ Completed | Blue #1565C0 + Red #D32F2F applied |
| Vuetify Theme | ✅ Completed | Theme updated in vuetify.js |
| Index Hero (Split) | ✅ Completed | Full redesign with split layout |
| Stats Bar | ✅ Completed | Integrated in Index.vue |
| Why Choose Us | ✅ Completed | Integrated in Index.vue |
| Partners Section | ✅ Completed | Colors updated |
| About Page | ✅ Completed | Colors updated, structure enhanced |
| Contact Page | ✅ Completed | Colors updated, structure enhanced |
| Engineering Services | ✅ Completed | Colors updated, typo fixed |
| Products Component | ✅ Completed | Colors updated |
| Footer | ✅ Completed | New design with dark theme + logo |

---

## 5. Files to Modify

### Core Files
- `resources/scss/variables.scss` - Design tokens
- `resources/css/app.css` - Global styles, components
- `resources/js/plugins/vuetify.js` - Theme colors

### Page Files
- `resources/js/pages/landing/Index.vue` - Home page (main redesign)
- `resources/js/pages/landing/About.vue` - About page
- `resources/js/pages/landing/Contact.vue` - Contact page
- `resources/js/pages/landing/EngineeringServices.vue` - Services page

### Component Files
- `resources/js/components/LandingPage/PartnersSection.vue` - Partners
- `resources/js/components/LandingPage/Products.vue` - Products grid

### Layout Files
- `resources/js/layouts/LandingPageLayout.vue` - Navbar, Footer

---

## 6. Notes & Decisions

### Implementation Complete (2026-07-03/04) - Full Redesign

1. **Design Tokens** - Updated variables.scss with new color palette (Blue + Red)
2. **CSS Variables** - Updated app.css with CSS custom properties
3. **Vuetify Theme** - Fixed theme name, Blue #1565C0 + Red #D32F2F
4. **Index.vue** - Complete redesign with:
   - Split Hero layout (content left, image right)
   - Blueprint grid pattern
   - Stats Bar section (4 stats with icons)
   - Why Choose Us section (3 cards)
   - About Preview section
   - CTA Section
5. **PartnersSection.vue** - Colors updated, marquee animation fixed (JS-based)
6. **About.vue** - Colors updated, enhanced structure with timeline
7. **Contact.vue** - Colors updated, form validation, bug fixed (email display)
8. **EngineeringServices.vue** - Colors updated, typo fixed (Alumunium → Aluminum)
9. **Products.vue** - Complete redesign:
   - Eyebrow + Title + Description header
   - Enhanced cards with icons, descriptions
   - Hover effects (scale + overlay)
   - Loading skeleton state
   - Empty state
   - "View All Products" CTA button
   - Center-aligned cards (max-width 320px)
10. **MainFooter.vue** - Complete redesign with dark theme + logo
11. **LoadingDialog.vue** - Fixed `dark` attribute error
12. **TopNavBar.vue** - Fixed `dark` attribute error
13. **vuetify.js** - Fixed defaultTheme name from "techno" to "light"

### Products Pages Redesign (2026-07-04)

14. **Vendor.vue** (`/product`) - Complete redesign:
    - Hero section with blueprint grid pattern
    - Eyebrow + Title + Description
    - Categories chips with active state styling
    - Vendors grid (replaced expansion panels)
    - Vendor cards with hover effects
    - Categories preview badges
    - Loading skeleton states
    - Empty state

15. **Catalog/Index.vue** (`/product/catalog/:type/:vendorId`) - Complete redesign:
    - Breadcrumb navigation
    - Header section with vendor logo
    - Vendor selector dropdown
    - Categories sidebar as card list
    - Product cards with hover effects
    - PDF download badges
    - Loading skeleton states
    - Empty state
    - Consistent color scheme (Blue + Red)

### Build Status
- ✅ Build successful with no errors
- All modules transformed successfully
- No console errors

### Known Issues Fixed
- ✅ Theme error "Cannot read properties of undefined (reading 'dark')"
- ✅ Marquee animation not working - replaced with JS-based animation
- ✅ Contact page email display bug
- ✅ EngineeringServices typo "Alumunium"

---

## 7. Questions & Decisions Log

| Date | Question | Decision |
|------|----------|----------|
| 2026-07-03 | Aesthetic direction | Industrial Precision |
| 2026-07-03 | Strategic priority | Brand Awareness → Trust → Conversion |
| 2026-07-03 | Hero layout | Split (Left content, Right image) |
| 2026-07-03 | Color palette | Based on logo: Blue #1565C0 + Red #D32F2F |
| 2026-07-03 | Typography | Poppins only (1 font for maintainability) |
| 2026-07-03 | Section order | Linear Flow (Hero → Stats → Why Us → Products → Partners → About → CTA) |
| 2026-07-03 | Animations | AOS subtle, Card lift+shadow, Marquee with pause |
| 2026-07-03 | User preference | Proceed with recommendations |

---

**Last Updated:** 2026-07-03  
**Next Step:** Implement all design decisions
