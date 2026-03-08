document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.ryder-itinerary-wrapper').forEach(function(wrapper) {
    var stops = JSON.parse(wrapper.getAttribute('data-stops') || '[]');
    var fullRoute = JSON.parse(wrapper.getAttribute('data-route') || '[]');
    var dayViews = JSON.parse(wrapper.getAttribute('data-dayviews') || '{}');

    var mapEl = wrapper.querySelector('#s-map');
    if (!mapEl) return;

    // Ensure unique IDs for maps if there are multiple shortcodes on a page
    var uniqueId = Math.random().toString(36).substr(2, 9);
    mapEl.id = 's-map-' + uniqueId;
    
    var miniMapEl = wrapper.querySelector('#mini-map');
    if (miniMapEl) {
      miniMapEl.id = 'mini-map-' + uniqueId;
    }

    /* ═══════════ MAIN MAP ═══════════ */
    var map = L.map(mapEl.id, { center: [-3.1, 35.4], zoom: 6, zoomControl: true, scrollWheelZoom: false });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { subdomains:'abcd', maxZoom:19 }).addTo(map);

    /* Park shading — always visible */
    stops.filter(function(s){ return s.r > 0; }).forEach(function(s) {
      L.circle([s.lat, s.lng], {
        radius: s.r, color:'#A07828', weight:1.5,
        fillColor:'#C49A3C', fillOpacity:0.12, dashArray:'5 5'
      }).addTo(map);
    });

    var minLat = -3.1, maxLat = -3.1, minLng = 35.4, maxLng = 35.4;
    if (stops.length > 0) {
      // Calculate bounds dynamically based on stops
      var lats = stops.map(function(s) { return s.lat; });
      var lngs = stops.map(function(s) { return s.lng; });
      minLat = Math.min.apply(null, lats) - 0.5;
      maxLat = Math.max.apply(null, lats) + 0.5;
      minLng = Math.min.apply(null, lngs) - 0.5;
      maxLng = Math.max.apply(null, lngs) + 0.5;
      map.fitBounds([[minLat, minLng], [maxLat, maxLng]], { padding:[48,48] });
    }

    /* Permanent park labels */
    stops.filter(function(s){ return s.id !== 'arusha'; }).forEach(function(s) {
      var dir = s.id === 'serengeti' ? 'left' : 'right'; // Simple fallback logic
      L.tooltip({ permanent:true, direction:dir, offset:[14,0], className:'pk-lbl' })
       .setContent('<span style="font-size:12px;font-weight:700;color:#7A5C18;white-space:nowrap;text-shadow:0 0 4px #fff,0 0 4px #fff,0 0 4px #fff,0 0 4px #fff;">' + s.name + '</span>')
       .setLatLng([s.lat, s.lng]).addTo(map);
    });

    var mmap = {}, animMarkers = [], animLine = null, dotMarker = null, raf = null, loopTimer = null;

    function lerp(a,b,t){ return [a[0]+(b[0]-a[0])*t, a[1]+(b[1]-a[1])*t]; }
    function ease(t){ return t<0.5 ? 2*t*t : 1-2*(1-t)*(1-t); }

    function clearAnim() {
      if(animLine){ try{ map.removeLayer(animLine); }catch(e){} animLine=null; }
      if(dotMarker){ try{ map.removeLayer(dotMarker); }catch(e){} dotMarker=null; }
      if(raf){ cancelAnimationFrame(raf); raf=null; }
      if(loopTimer){ clearTimeout(loopTimer); loopTimer=null; }
      animMarkers.forEach(function(m){ try{ map.removeLayer(m); }catch(e){} });
      animMarkers = [];
      mmap = {};
    }

    function runAnimation() {
      clearAnim();

      /* Pin markers with staggered pop-in */
      stops.forEach(function(s, i) {
        var isPark = s.type === 'park';
        var bg  = isPark ? '#A07828' : '#3D2E0A';
        var bdr = isPark ? '#C49A3C' : '#6B5520';
        var lbl = isPark ? s.day : s.name;
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
        animMarkers.push(m);
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
      
      if (fullRoute.length > 0) {
        var dot = L.marker(fullRoute[0], { icon:dotIcon, zIndexOffset:1000 }).addTo(map);
        dotMarker = dot;

        var duration = 4200, startTs = null, segs = fullRoute.length - 1;

        function step(ts) {
          if(!startTs) startTs = ts;
          var t = Math.min((ts - startTs)/duration, 1), p = ease(t);
          var sp = p*segs, si = Math.min(Math.floor(sp), segs-1), st = sp - si;
          
          // Safety check for empty or invalid route
          if(si < 0 || !fullRoute[si] || !fullRoute[Math.min(si+1, segs)]) {
            if(raf) cancelAnimationFrame(raf);
            return;
          }
          
          var cur = lerp(fullRoute[si], fullRoute[Math.min(si+1, segs)], st);
          line.setLatLngs(fullRoute.slice(0, si+1).concat([cur]));
          dot.setLatLng(cur);
          if(t < 1) {
            raf = requestAnimationFrame(step);
          } else {
            setTimeout(function(){ if(dotMarker){ try{map.removeLayer(dotMarker);}catch(e){} dotMarker=null; } }, 800);
            loopTimer = setTimeout(runAnimation, 3000);
          }
        }
        setTimeout(function(){ raf = requestAnimationFrame(step); }, 600);
      }
    }

    /* Bind Replay Button */
    var replayBtn = wrapper.querySelector('.btn-replay');
    if (replayBtn) {
      replayBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        runAnimation();
      });
    }

    /* Auto-start */
    setTimeout(runAnimation, 900);

    /* ═══════════ MINI MAP (itinerary sidebar) ═══════════ */
    var miniMap = null;
    if (miniMapEl) {
      miniMap = L.map(miniMapEl.id, { center:[-3.1, 35.4], zoom:5, zoomControl:false, scrollWheelZoom:false, attributionControl:false });
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

      if (stops.length > 0) {
        miniMap.fitBounds([[minLat, minLng], [maxLat, maxLng]], { padding:[20,20] });
      }
    }

    /* ═══════════ DAY SELECTOR (itinerary section) ═══════════ */
    var dayCards = wrapper.querySelectorAll('.day-card');
    dayCards.forEach(function(card) {
      card.addEventListener('click', function() {
        dayCards.forEach(function(c){ c.classList.remove('active'); });
        this.classList.add('active');
        var day = this.getAttribute('data-day');
        var v = dayViews[day];
        if(v && mmap[v.id] && miniMap) {
          miniMap.flyTo(v.c, v.z, { duration:0.8 });
          mmap[v.id].openPopup();
        }
      });
    });

    /* ═══════════ FAQ TOGGLE ═══════════ */
    var faqBtns = wrapper.querySelectorAll('.faq-q');
    faqBtns.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var item = this.closest('.faq-item');
        var isOpen = item.classList.contains('open');
        wrapper.querySelectorAll('.faq-item').forEach(function(i){ i.classList.remove('open'); });
        if(!isOpen) item.classList.add('open');
      });
    });

  });
});
