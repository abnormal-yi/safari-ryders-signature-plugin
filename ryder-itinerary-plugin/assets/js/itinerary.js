/* ── ROUTE DATA ── */
// Use dynamic data if available, otherwise fallback to static
var stops = (typeof ryderItineraryData !== 'undefined' && ryderItineraryData.stops) ? ryderItineraryData.stops : [
  { id:'arusha',     type:'city', day:'',          name:'Arusha',                   lat:-3.3869, lng:36.6830, r:0 },
  { id:'tarangire',  type:'park', day:'Day 2',      name:'Tarangire N.P.',            lat:-4.1629, lng:36.0899, r:50000 },
  { id:'ngorongoro', type:'park', day:'Days 3–4',   name:'Ngorongoro Conservation',  lat:-3.1618, lng:35.5877, r:27000 },
  { id:'serengeti',  type:'park', day:'Days 4–5',   name:'Serengeti N.P.',            lat:-2.3333, lng:34.8333, r:92000 }
];

var fullRoute = (typeof ryderItineraryData !== 'undefined' && ryderItineraryData.route) ? ryderItineraryData.route : [
  [-3.3869, 36.6830],  // Arusha
  [-4.1629, 36.0899],  // Tarangire
  [-3.1618, 35.5877],  // Ngorongoro
  [-2.3333, 34.8333],  // Serengeti
  [-3.3869, 36.6830]   // Return Arusha/JRO
];

document.addEventListener('DOMContentLoaded', function() {
  if (!document.getElementById('s-map')) return;

  /* ═══════════ MAIN MAP ═══════════ */
  var map = L.map('s-map', { center: [-3.1, 35.4], zoom: 6, zoomControl: true, scrollWheelZoom: false });
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { subdomains:'abcd', maxZoom:19 }).addTo(map);

  /* Park shading — always visible */
  stops.filter(function(s){ return s.r > 0; }).forEach(function(s) {
    L.circle([s.lat, s.lng], {
      radius: s.r, color:'#A07828', weight:1.5,
      fillColor:'#C49A3C', fillOpacity:0.12, dashArray:'5 5'
    }).addTo(map);
  });

  map.fitBounds([[-4.9, 33.2],[-1.9, 37.8]], { padding:[48,48] });

  /* Permanent park labels */
  stops.filter(function(s){ return s.id !== 'arusha'; }).forEach(function(s) {
    var dir = s.id === 'serengeti' ? 'left' : 'right';
    L.tooltip({ permanent:true, direction:dir, offset:[14,0], className:'pk-lbl' })
     .setContent('<span style="font-size:12px;font-weight:700;color:#7A5C18;white-space:nowrap;text-shadow:0 0 4px #fff,0 0 4px #fff,0 0 4px #fff,0 0 4px #fff;">' + s.name + '</span>')
     .setLatLng([s.lat, s.lng]).addTo(map);
  });

  var mmap = {}, animLine = null, dotMarker = null, raf = null, loopTimer = null;

  function lerp(a,b,t){ return [a[0]+(b[0]-a[0])*t, a[1]+(b[1]-a[1])*t]; }
  function ease(t){ return t<0.5 ? 2*t*t : 1-2*(1-t)*(1-t); }

  function clearAnim() {
    if(animLine){ try{ map.removeLayer(animLine); }catch(e){} animLine=null; }
    if(dotMarker){ try{ map.removeLayer(dotMarker); }catch(e){} dotMarker=null; }
    if(raf){ cancelAnimationFrame(raf); raf=null; }
    if(loopTimer){ clearTimeout(loopTimer); loopTimer=null; }
    Object.keys(mmap).forEach(function(k){ try{ map.removeLayer(mmap[k]); }catch(e){} });
    mmap = {};
  }

  window.runAnimation = function() {
    clearAnim();

    /* Pin markers with staggered pop-in */
    stops.forEach(function(s, i) {
      var isPark = s.type === 'park';
      var bg  = isPark ? '#A07828' : '#3D2E0A';
      var bdr = isPark ? '#C49A3C' : '#6B5520';
      var lbl = isPark ? s.day : 'Arusha';
      var fs  = isPark ? '10px' : '8px';
      var delay = 600 + i*380;
      var icon = L.divIcon({
        html: '<div style="width:44px;height:44px;background:'+bg+';border:2.5px solid '+bdr+';border-radius:50% 50% 50% 4px;transform:rotate(-45deg);box-shadow:0 3px 14px rgba(90,60,0,.28);display:flex;align-items:center;justify-content:center;opacity:0;animation:popIn 0.55s cubic-bezier(.34,1.56,.64,1) '+delay+'ms both;"><span style="transform:rotate(45deg);color:#fff;font-size:'+fs+';font-weight:700;font-family:sans-serif;text-align:center;line-height:1.1;">'+lbl+'</span></div>',
        className:'', iconSize:[44,44], iconAnchor:[22,42], popupAnchor:[0,-44]
      });
      var m = L.marker([s.lat, s.lng], { icon:icon }).addTo(map);
      m.bindPopup(
        '<div style="font-family:sans-serif;min-width:200px;"><div style="background:'+bg+';padding:12px 15px;">'
        + (s.day ? '<div style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.75);margin-bottom:3px;">'+s.day+'</div>' : '')
        + '<div style="font-size:1rem;font-weight:700;color:#fff;">'+s.name+'</div></div>'
        + '<div style="padding:9px 15px;background:#fff;font-size:.83rem;color:#7A6040;font-style:italic;line-height:1.5;">'
        + (isPark ? 'Click a day card to explore.' : 'Safari start & end point.')
        + '</div></div>',
        { maxWidth:240, closeButton:false }
      );
      mmap[s.id] = m;
    });

    /* Animated polyline */
    var line = L.polyline([], { color:'#7A5C18', weight:3, dashArray:'10 8', opacity:.9 }).addTo(map);
    animLine = line;

    /* Travelling dot */
    var dotIcon = L.divIcon({
      html: '<div style="width:14px;height:14px;background:#fff;border:3px solid #A07828;border-radius:50%;animation:pulse 1s ease-in-out infinite;"></div>',
      className:'', iconSize:[14,14], iconAnchor:[7,7]
    });
    var dot = L.marker(fullRoute[0], { icon:dotIcon, zIndexOffset:1000 }).addTo(map);
    dotMarker = dot;

    var duration = 4200, startTs = null, segs = fullRoute.length - 1;

    function step(ts) {
      if(!startTs) startTs = ts;
      var t = Math.min((ts - startTs)/duration, 1), p = ease(t);
      var sp = p*segs, si = Math.min(Math.floor(sp), segs-1), st = sp - si;
      var cur = lerp(fullRoute[si], fullRoute[Math.min(si+1, segs)], st);
      line.setLatLngs(fullRoute.slice(0, si+1).concat([cur]));
      dot.setLatLng(cur);
      if(t < 1) {
        raf = requestAnimationFrame(step);
      } else {
        setTimeout(function(){ if(dotMarker){ try{map.removeLayer(dotMarker);}catch(e){} dotMarker=null; } }, 800);
        loopTimer = setTimeout(window.runAnimation, 3000);
      }
    }
    setTimeout(function(){ raf = requestAnimationFrame(step); }, 600);
  };

  /* Auto-start */
  setTimeout(window.runAnimation, 900);

  /* ═══════════ MINI MAP (itinerary sidebar) ═══════════ */
  if (document.getElementById('mini-map')) {
    var miniMap = L.map('mini-map', { center:[-3.1, 35.4], zoom:5, zoomControl:false, scrollWheelZoom:false, attributionControl:false });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { subdomains:'abcd', maxZoom:19 }).addTo(miniMap);

    stops.filter(function(s){ return s.r > 0; }).forEach(function(s) {
      L.circle([s.lat, s.lng], {
        radius: s.r, color:'#A07828', weight:1,
        fillColor:'#C49A3C', fillOpacity:0.15
      }).addTo(miniMap);
    });

    L.polyline(fullRoute, { color:'#7A5C18', weight:2.5, dashArray:'8 6', opacity:.8 }).addTo(miniMap);
    stops.forEach(function(s) {
      var bg = s.type==='park' ? '#A07828' : '#3D2E0A';
      var icon = L.divIcon({
        html: '<div style="width:10px;height:10px;background:'+bg+';border:2px solid #fff;border-radius:50%;box-shadow:0 1px 4px rgba(0,0,0,.3);"></div>',
        className:'', iconSize:[10,10], iconAnchor:[5,5]
      });
      L.marker([s.lat, s.lng], { icon:icon }).addTo(miniMap);
    });

    miniMap.fitBounds([[-4.9,33.2],[-1.9,37.8]], { padding:[20,20] });

    /* ═══════════ DAY SELECTOR (itinerary section) ═══════════ */
    var dayViews = {
      1: { c:[-3.3869, 36.6830], z:8,  id:'arusha' },
      2: { c:[-4.1629, 36.0899], z:9,  id:'tarangire' },
      3: { c:[-3.1618, 35.5877], z:9,  id:'ngorongoro' },
      4: { c:[-3.0, 35.2],       z:7,  id:'ngorongoro' },
      5: { c:[-2.3333, 34.8333], z:8,  id:'serengeti' },
      6: { c:[-3.1, 35.5],       z:7,  id:'arusha' }
    };

    window.selectDay = function(day) {
      document.querySelectorAll('.day-card').forEach(function(c){ c.classList.remove('active'); });
      var card = document.querySelector('[data-day="'+day+'"]');
      if (card) card.classList.add('active');
      var v = dayViews[day];
      if(v && mmap[v.id]) {
        miniMap.flyTo(v.c, v.z, { duration:0.8 });
        mmap[v.id].openPopup();
      }
    };
  }

  /* FAQ toggle */
  window.toggleFaq = function(btn) {
    var item = btn.closest('.faq-item');
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(function(i){ i.classList.remove('open'); });
    if(!isOpen) item.classList.add('open');
  };
});
