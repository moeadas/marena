// MARÉNA Care Service Worker
const CACHE_NAME = 'marena-care-v1';
const STATIC_ASSETS = [
  '/',
  '/manifest.json',
  '/marena-mark.svg',
  '/marena-logo.svg',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k)))
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  // Skip non-GET requests
  if (event.request.method !== 'GET') return;

  // Skip API requests — always go to network
  if (event.request.url.includes('/api/') || event.request.url.includes('/login') || event.request.url.includes('/logout')) {
    return;
  }

  // Cache-first for static assets
  if (event.request.url.match(/\.(css|js|svg|png|jpg|woff2?)$/)) {
    event.respondWith(
      caches.match(event.request).then((cached) => cached || fetch(event.request))
    );
    return;
  }

  // Network-first for pages
  event.respondWith(
    fetch(event.request)
      .then((response) => {
        const clone = response.clone();
        caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
        return response;
      })
      .catch(() => caches.match(event.request))
  );
});