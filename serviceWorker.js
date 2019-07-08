const staticAssets = [
  "./",
  "./styles/index.css",
  "./styles/chat.css",
  "./scripts/index.js",
  "./scripts/chat.js",
  "./images/arrow.png",
  "./images/camera.png"
];

self.addEventListener("install", async event => {
  const cache = await caches.open("muchat-static");
  cache.addAll(staticAssets);
});

self.addEventListener("fetch", event => {
  const req = event.request;
  const url = new URL(req.url);
  if (event.request.url.indexOf("http") === 0) {
    if (url.origin == location.origin) {
      event.respondWith(cacheFirst(req));
    } else {
      event.respondWith(networkFirst(req));
    }
  }
});

async function cacheFirst(req) {
  const cachedResponse = await caches.match(req);
  return cachedResponse || fetch(req);
}

async function networkFirst(req) {
  const cache = await caches.open("muchat-dynamic");

  try {
    const res = await fetch(req);
    cache.put(req, res.clone());
    return res;
  } catch (error) {
    return await cache.match(req);
  }
}
