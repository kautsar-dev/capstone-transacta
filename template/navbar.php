<div class="topbar flex items-center justify-between px-4 py-2">
<!-- Hamburger button -->
<button
  class="md:hidden text-gray-800 focus:outline-none"
  type="button"
  data-bs-toggle="collapse"
  data-bs-target="#sidebar"
  aria-controls="sidebar"
  aria-expanded="false"
  aria-label="Toggle navigation"
>
  <i class="fas fa-bars text-2xl"></i>
</button>


  <!-- Search Input -->
  <form class="search-input flex-grow mx-4 max-w-xl" role="search" aria-label="Pencarian dashboard">
    <div class="relative w-full">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 5 1.5-1.5-5-5Z"/>
      </svg>
      <input
        type="search"
        id="search"
        placeholder="Cari"
        class="pl-10 pr-10 py-2 rounded-md border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-green-400"
        aria-describedby="clearSearch"
        aria-label="Input cari"
      />
      <button
        type="button"
        aria-label="Bersihkan pencarian"
        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-500"
        id="clearSearch"
        title="Bersihkan Pencarian"
        aria-hidden="true"
        tabindex="-1"
      >&times;</button>
    </div>
  </form>

  <!-- Icons & Avatar -->
  <div class="topbar-icons flex items-center gap-4" aria-label="Notifikasi dan Profil pengguna">
    <button type="button" aria-label="Notifikasi baru" title="Notifikasi" class="text-gray-800 text-xl">
      <svg xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" viewBox="0 0 24 24" class="w-6 h-6"><path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22ZM19 16v-5c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C6.63 5.36 5 7.92 5 11v5l-1 1v1h16v-1l-1-1Z"/></svg>
    </button>
    <img src="../asset/image/supplier.svg" class="w-8 h-8" alt="Logo"/>
  </div>
</div>

