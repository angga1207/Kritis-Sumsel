# Blueprint: Kanal Berita Online "Kritis Sumsel"

> Referensi desain & animasi: [tagDiv Newspaper Free (News Pro demo)](https://demo.tagdiv.com/newspaper_free_news_pro/)
> Dokumen ini adalah **blueprint perencanaan**. Implementasi kode dilakukan pada tahap berikutnya.

---

## 1. Ringkasan Proyek

| Item | Keterangan |
|---|---|
| Nama Proyek | Kritis Sumsel (Kanal Berita Online) |
| Framework | Laravel (versi terbaru — 11.x/12.x, cek versi stabil saat implementasi) |
| Database | PostgreSQL (`user: postgres`, `password: (kosong)`) |
| Interaktivitas | Livewire 3.x |
| Notifikasi/Alert | SweetAlert2 |
| Rich Text Editor | Quill.js |
| Searchable Select | Tom Select |
| Styling | Tailwind CSS |
| Layout Grid Berita | Masonry (via library `masonry-layout` + `imagesloaded`) |
| Animasi Scroll | AOS (Animate On Scroll) |
| Warna Primary | Biru Donker (Navy) — `#0A1F44` / `#0B2545` sebagai basis |
| Gaya UI | Modern, interaktif, editorial/majalah digital (ala tagDiv Newspaper) |

---

## 2. Referensi Desain (tagDiv Newspaper - News Pro)

Elemen kunci yang akan diadaptasi:

- **Header**: Logo kiri, menu horizontal sticky, search icon, breaking news ticker.
- **Hero/Featured Slider**: Carousel besar berita utama dengan overlay gradient + judul besar.
- **Grid Berita Kategori**: Blok kategori (mis. "Politik", "Ekonomi", "Olahraga") dengan layout grid 1 besar + beberapa kecil (list style).
- **Trending/Popular Sidebar**: Widget "Berita Terpopuler" dengan angka ranking besar.
- **Card Berita**: Thumbnail, kategori badge, judul, meta (penulis, tanggal, jumlah komentar/view).
- **Infinite scroll / Load more** pada halaman kategori & pencarian.
- **Grid Masonry**: Section berita (kategori, arsip, hasil pencarian) memakai layout masonry (kolom bertumpuk rapi ala Pinterest/tagDiv), bukan grid kaku, agar variasi tinggi thumbnail tetap rapi.
- **Animasi**: Hover zoom pada thumbnail, fade-in saat scroll menggunakan **AOS**, transisi warna pada link/button, skeleton loading saat Livewire fetch data.
- **Footer**: Multi-kolom (tentang, kategori, sosial media, newsletter signup).
- **Dark navy accent** menggantikan warna asli tagDiv (biasanya merah/orange) → disesuaikan dengan primary biru donker + aksen kuning/emas atau putih untuk kontras CTA.

---

## 3. Tech Stack Detail

- **Backend**: Laravel (terbaru), PHP 8.3+
- **Frontend Interaktif**: Livewire 3 (component-based, wire:navigate untuk SPA-like transition)
- **Database**: PostgreSQL 
  - Koneksi: `pgsql`, host `127.0.0.1`, port `5432`, database `kritis_sumsel`, username `postgres`, password kosong
- **CSS Framework**: Tailwind CSS (dengan konfigurasi custom warna & font)
- **Build Tool**: Vite
- **Package Tambahan**:
  - `sweetalert2` (via npm) — konfirmasi hapus, notifikasi sukses/error, toast
  - `quill` (via npm) — editor konten artikel (WYSIWYG)
  - `tom-select` (via npm) — dropdown searchable (kategori, tag, penulis, relasi berita)
  - `livewire/livewire`
  - `masonry-layout` + `imagesloaded` (via npm) — grid berita bertumpuk (masonry) ala tagDiv, dipakai di section kategori, arsip, dan hasil pencarian
  - `aos` (Animate On Scroll, via npm) — animasi fade/slide saat elemen masuk viewport (hero, card, section title)

---

## 4. Struktur Role & Autentikasi

| Role | Hak Akses |
|---|---|
| **Super Admin** | Full akses (kelola user, kategori, artikel, komentar, pengaturan situs) |
| **Editor** | Kelola & publish artikel semua penulis, kelola kategori/tag |
| **Penulis (Author/Jurnalis)** | Tulis, edit artikel milik sendiri (draft → submit review) |
| **Pembaca (Public)** | Baca artikel, komentar (jika login), like/bookmark |

Autentikasi: Laravel Breeze/Fortify + Livewire stack (atau native auth scaffolding), dengan middleware role (spatie/laravel-permission direkomendasikan untuk implementasi).

---

## 5. Struktur Database (ERD Konsep)

### Tabel Utama

**users**
- id, name, email, password, role_id (atau pivot via spatie/permission), avatar, bio, is_active, remember_token, timestamps

**roles** *(jika tidak pakai spatie/permission)*
- id, name (super_admin, editor, author), timestamps

**categories**
- id, name, slug, description, icon, parent_id (nullable, untuk sub-kategori), color (hex, untuk badge warna kategori), order, is_active, timestamps

**tags**
- id, name, slug, timestamps

**articles**
- id, user_id (author), category_id, title, slug, excerpt, content (longtext/HTML dari Quill), featured_image, status (draft/pending/published/archived), is_featured (boolean, untuk hero slider), is_breaking (boolean, untuk ticker), views_count, published_at, meta_title, meta_description, timestamps, soft_deletes

**article_tag** (pivot)
- article_id, tag_id

**comments**
- id, article_id, user_id (nullable jika guest), parent_id (nested reply), name (jika guest), email (jika guest), content, status (pending/approved/spam), timestamps

**likes / bookmarks**
- id, user_id, article_id, type (like/bookmark), timestamps

**media** *(jika perlu galeri/multi gambar per artikel)*
- id, article_id, path, type, order, timestamps

**settings**
- id, key, value (untuk pengaturan situs: logo, social links, dll — bisa key-value JSON)

**newsletter_subscribers**
- id, email, is_verified, timestamps

**article_views** *(opsional, untuk analitik lebih detail daripada hanya counter)*
- id, article_id, ip_address, user_agent, viewed_at

### Relasi Kunci
- `User` hasMany `Article`
- `Category` hasMany `Article`, hasMany `Category` (self-referencing untuk sub-kategori)
- `Article` belongsToMany `Tag`, hasMany `Comment`, morphMany atau hasMany `Like`
- `Comment` belongsTo `Article`, self-referencing untuk `parent_id` (reply)

---

## 6. Struktur Halaman (Frontend Publik)

1. **Homepage (`/`)**
   - Hero slider (artikel featured) — Livewire component `HeroSlider` (transisi fade + AOS saat pertama masuk viewport)
   - Breaking news ticker — Livewire `BreakingNewsTicker` (polling/auto refresh)
   - Section per kategori (1 card besar + grid **masonry** untuk sisanya) — Livewire `CategorySection`, tiap card AOS fade-in bertahap (staggered)
   - Sidebar: Trending/Popular (ranking), Tag cloud, Newsletter signup
   - Section "Video" atau "Editor's Pick" (opsional, sesuai tagDiv)

2. **Halaman Kategori (`/kategori/{slug}`)**
   - Header kategori dengan deskripsi
   - Grid artikel **masonry** (re-layout otomatis setelah gambar load / setelah Livewire fetch data baru) + filter (Tom Select untuk sub-kategori/tag)
   - Infinite scroll / pagination Livewire — item baru masuk dengan animasi AOS + masonry re-layout

3. **Halaman Detail Artikel (`/artikel/{slug}`)**
   - Konten artikel (render HTML dari Quill, sanitized)
   - Meta info (penulis, tanggal, kategori, view count, share buttons)
   - Related articles (berdasarkan kategori/tag)
   - Komentar (Livewire `CommentSection` — nested reply, like comment)
   - Sidebar trending

4. **Halaman Pencarian (`/cari?q=...`)**
   - Livewire real-time search dengan debounce
   - Filter kategori (Tom Select)

5. **Halaman Statis**: Tentang Kami, Kontak, Kebijakan Privasi, Redaksi

6. **Halaman Author (`/penulis/{username}`)**
   - Profil singkat + daftar artikel penulis

---

## 7. Struktur Halaman (Dashboard Admin/Editor/Penulis)

Menggunakan layout terpisah (`layouts.admin`), sidebar navigasi, dominan warna navy + putih.

1. **Dashboard Overview**
   - Statistik: total artikel, total views, komentar pending, user baru (chart menggunakan Chart.js/ApexCharts — opsional)

2. **Manajemen Artikel**
   - List artikel (Livewire table: search, filter status/kategori via Tom Select, sort, pagination)
   - Form Create/Edit Artikel:
     - Input judul (auto-generate slug)
     - **Quill editor** untuk konten
     - **Tom Select** untuk kategori (single) & tag (multiple, dengan create-on-the-fly)
     - Upload featured image (preview langsung)
     - Toggle `is_featured`, `is_breaking`
     - Tombol Simpan Draft / Ajukan Review / Publish
     - **SweetAlert2** untuk konfirmasi publish/hapus & notifikasi sukses/gagal

3. **Manajemen Kategori & Tag**
   - CRUD dengan modal Livewire (bukan pindah halaman) + SweetAlert2 konfirmasi delete

4. **Manajemen Komentar**
   - Moderasi (approve/reject/spam) dengan SweetAlert2 konfirmasi

5. **Manajemen User** (Super Admin only)
   - CRUD user, assign role via Tom Select

6. **Pengaturan Situs**
   - Logo, social media links, meta SEO default, kode analytics

---

## 8. Desain Sistem (Design System)

### Palet Warna
```
--color-primary: #0B2545;        /* Biru Donker (Navy) — utama */
--color-primary-dark: #061530;   /* Navy lebih gelap (hover/header) */
--color-primary-light: #13315C;  /* Navy terang (card hover, border) */
--color-accent: #F4B400;         /* Kuning/emas — CTA, badge breaking news */
--color-secondary: #E8ECF3;      /* Abu-biru terang — background section */
--color-text: #1A1A1A;
--color-text-muted: #6B7280;
--color-white: #FFFFFF;
--color-danger: #DC2626;         /* breaking news / hapus */
--color-success: #16A34A;
```

### Tipografi
- Heading: font tegas/serif-modern (mis. "Merriweather" atau "Playfair Display") untuk kesan editorial — sesuai gaya tagDiv Newspaper.
- Body: sans-serif modern (mis. "Inter" atau "Poppins") untuk keterbacaan.
- Load via Google Fonts, konfigurasi di `tailwind.config.js`.

### Komponen UI Reusable (Blade/Livewire)
- `<x-news-card>` — card artikel (varian: horizontal, vertical, compact list)
- `<x-category-badge>` — badge warna sesuai kategori
- `<x-section-title>` — judul section dengan garis aksen (ciri khas tagDiv)
- `<x-hero-slider>` 
- `<x-breaking-ticker>`
- `<x-pagination>` (custom Livewire pagination view, styled Tailwind)
- `<x-skeleton-card>` — loading state saat Livewire fetch

### Animasi & Interaksi
- Transisi hover pada card (scale + shadow) — `transition-transform duration-300 hover:scale-105`
- **Fade-in/slide on scroll pakai AOS** (`data-aos="fade-up"`, dsb.) pada card, section title, dan hero
- **Grid berita pakai Masonry** (`masonry-layout` + `imagesloaded`): kolom bertumpuk rapi menyesuaikan tinggi thumbnail, di-reinit/`layout()` ulang tiap kali Livewire menambah item (infinite scroll) atau gambar baru selesai load
- Sticky header dengan efek shrink saat scroll
- Skeleton loading Livewire (`wire:loading`) menggantikan spinner biasa
- SweetAlert2 toast di pojok kanan atas untuk notifikasi sukses (auto-dismiss)
- Smooth page transition dengan `wire:navigate` (Livewire SPA mode) — AOS & Masonry di-refresh pada event `livewire:navigated`

---

## 9. Alur Instalasi & Konfigurasi (Ringkasan untuk Tahap Implementasi)

1. `laravel new kritis-sumsel`
2. Konfigurasi `.env` → `DB_CONNECTION=pgsql`, `DB_HOST=127.0.0.1`, `DB_PORT=5432`, `DB_DATABASE=kritis_sumsel`, `DB_USERNAME=postgres`, `DB_PASSWORD=`
3. Install Livewire: `composer require livewire/livewire`
4. Install Tailwind CSS (via Vite) + konfigurasi tema warna custom
5. `npm install sweetalert2 quill tom-select masonry-layout imagesloaded aos`
6. Install `spatie/laravel-permission` untuk role management
7. Setup Breeze (Livewire stack) untuk autentikasi
8. Buat migration & seeder (kategori default, super admin, artikel dummy)
9. Buat komponen Blade layout: `layouts.app` (publik), `layouts.admin` (dashboard)
10. Implementasi bertahap: Auth → Dashboard CRUD (Kategori/Tag/Artikel) → Frontend Publik → Komentar & Interaksi → Polish animasi

---

## 10. Struktur Folder (Konsep, Standar Laravel + Livewire)

```
app/
  Livewire/
    Frontend/
      HeroSlider.php
      BreakingTicker.php
      CategorySection.php
      ArticleList.php
      CommentSection.php
      SearchArticles.php
    Admin/
      ArticleManager.php
      ArticleForm.php
      CategoryManager.php
      TagManager.php
      CommentModeration.php
      UserManager.php
  Models/
    User.php, Article.php, Category.php, Tag.php, Comment.php, Like.php, Setting.php
resources/
  views/
    layouts/
      app.blade.php
      admin.blade.php
    livewire/
      frontend/...
      admin/...
    components/
      news-card.blade.php
      category-badge.blade.php
      ...
  js/
    app.js (import Alpine/Livewire, Quill init, Tom Select init, SweetAlert2 helper)
    aos-init.js (inisialisasi & refresh AOS, termasuk hook `livewire:navigated`/`livewire:updated`)
    masonry-init.js (inisialisasi Masonry + imagesloaded, `wire:ignore` pada container, re-`layout()` setiap Livewire menambah item)
  css/
    app.css (Tailwind directives + custom base styles)
database/
  migrations/
  seeders/
```

---

## 11. Catatan Teknis Penting

- **Sanitasi konten Quill**: gunakan `mews/purifier` atau HTMLPurifier untuk membersihkan output HTML sebelum disimpan/ditampilkan (mencegah XSS).
- **Slug generation**: gunakan package `spatie/laravel-sluggable` atau custom observer pada model `Article`/`Category`.
- **Image handling**: gunakan `Intervention Image` untuk resize/optimize featured image otomatis (thumbnail, medium, large).
- **SEO**: meta tag dinamis per artikel (Open Graph, Twitter Card) untuk keperluan share sosial media (khas kanal berita).
- **Performance**: cache query kategori & trending articles (Laravel Cache), lazy load gambar (`loading="lazy"`).
- **Livewire + Tom Select/Quill/Masonry/AOS**: semua library JS eksternal ini memanipulasi DOM di luar kendali Livewire, sehingga container-nya wajib diberi `wire:ignore` (atau `wire:ignore.self`) dan di-reinisialisasi/di-refresh secara manual pada event `livewire:navigated` (untuk `wire:navigate`) maupun `livewire:updated`/hook Livewire component (mis. `updated()` di komponen `CategorySection`/`ArticleList` memicu `Masonry.layout()` & `AOS.refresh()` setelah item baru dirender) agar tidak konflik dengan DOM diffing Livewire.

---

## 12. Tahap Implementasi Berikutnya (Belum Dikerjakan)

- [ ] Setup project Laravel + konfigurasi database PostgreSQL
- [ ] Install & konfigurasi semua dependency (Tailwind, Livewire, SweetAlert2, Quill, Tom Select)
- [ ] Migration & seeder database
- [ ] Layout dasar (publik & admin) sesuai desain tagDiv Newspaper
- [ ] Modul autentikasi & role
- [ ] Modul CRUD Artikel (dengan Quill + Tom Select)
- [ ] Modul CRUD Kategori/Tag
- [ ] Frontend homepage, kategori, detail artikel
- [ ] Modul komentar & interaksi (like/bookmark)
- [ ] Polish animasi & responsivitas
- [ ] Testing & optimasi performa
