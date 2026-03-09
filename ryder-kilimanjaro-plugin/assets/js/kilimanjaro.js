document.addEventListener('DOMContentLoaded', function() {
  if (!document.getElementById('s-map')) return;

  var stops=[
    {id:'lemosho',   type:'start',  day:'Start', name:'Lemosho Gate',  lat:-3.0670,lng:37.0530,elev:'2,100m'},
    {id:'mti',       type:'camp',   day:'Day 1', name:'Mti Mkubwa',    lat:-3.0450,lng:37.0850,elev:'2,895m'},
    {id:'shira1',    type:'camp',   day:'Day 2', name:'Shira 1 Camp',  lat:-3.0280,lng:37.1100,elev:'3,610m'},
    {id:'shira2',    type:'camp',   day:'Day 3', name:'Shira 2 Camp',  lat:-3.0100,lng:37.1350,elev:'3,840m'},
    {id:'lava',      type:'camp',   day:'Day 4', name:'Lava Tower',    lat:-3.0500,lng:37.2000,elev:'4,630m'},
    {id:'barranco',  type:'camp',   day:'Day 4', name:'Barranco Camp', lat:-3.0750,lng:37.2250,elev:'3,976m'},
    {id:'karanga',   type:'camp',   day:'Day 5', name:'Karanga Camp',  lat:-3.0850,lng:37.2600,elev:'3,995m'},
    {id:'barafu',    type:'camp',   day:'Day 6', name:'Barafu Camp',   lat:-3.0650,lng:37.2950,elev:'4,673m'},
    {id:'summit',    type:'summit', day:'Day 7', name:'Uhuru Peak',    lat:-3.0759,lng:37.3537,elev:'5,895m'},
    {id:'mweka',     type:'camp',   day:'Day 7', name:'Mweka Camp',    lat:-3.1050,lng:37.3200,elev:'3,100m'},
    {id:'mwekagate', type:'end',    day:'Day 8', name:'Mweka Gate',    lat:-3.1450,lng:37.3100,elev:'1,640m'}
  ];
  var fullRoute=[
    [-3.0670,37.0530],[-3.0450,37.0850],[-3.0280,37.1100],[-3.0100,37.1350],
    [-3.0500,37.2000],[-3.0750,37.2250],[-3.0850,37.2600],[-3.0650,37.2950],
    [-3.0759,37.3537],[-3.1050,37.3200],[-3.1450,37.3100]
  ];
  var map=L.map('s-map',{center:[-3.07,37.20],zoom:10,zoomControl:true,scrollWheelZoom:false});
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{subdomains:'abcd',maxZoom:19}).addTo(map);
  map.fitBounds([[-3.18,37.00],[-2.98,37.40]],{padding:[40,40]});
  var mmap={},animLine=null,dotMarker=null,raf=null,loopTimer=null;
  function lerp(a,b,t){return[a[0]+(b[0]-a[0])*t,a[1]+(b[1]-a[1])*t];}
  function ease(t){return t<0.5?2*t*t:1-2*(1-t)*(1-t);}
  function clearAnimLayersOnly(){
    if(animLine){try{map.removeLayer(animLine);}catch(e){} animLine=null;}
    if(dotMarker){try{map.removeLayer(dotMarker);}catch(e){} dotMarker=null;}
    if(raf){cancelAnimationFrame(raf);raf=null;}
    if(loopTimer){clearTimeout(loopTimer);loopTimer=null;}
    Object.keys(mmap).forEach(function(k){try{map.removeLayer(mmap[k]);}catch(e){}});
    mmap={};
  }
  window.runAnimation=function(){
    clearAnimLayersOnly();
    stops.forEach(function(s,i){
      var isSummit=s.type==='summit';
      var isStart=s.type==='start'||s.type==='end';
      var bg=isSummit?'#B8860B':(isStart?'#3D2E0A':'#A07828');
      var bdr=isSummit?'#FFD700':(isStart?'#6B5520':'#C49A3C');
      var delay=600+i*280;
      // Pin marker with elevation
      var icon=L.divIcon({
        html:'<div style="width:44px;height:44px;background:'+bg+';border:2.5px solid '+bdr+';border-radius:50% 50% 50% 4px;transform:rotate(-45deg);box-shadow:0 3px 14px rgba(90,60,0,.28);display:flex;align-items:center;justify-content:center;opacity:0;animation:popIn 0.55s cubic-bezier(.34,1.56,.64,1) '+delay+'ms both;"><span style="transform:rotate(45deg);color:#fff;font-size:'+(isSummit?'8.5px':'7.5px')+';font-weight:700;font-family:sans-serif;text-align:center;line-height:1.1;">'+s.elev+'</span></div>',
        className:'',iconSize:[44,44],iconAnchor:[22,42],popupAnchor:[0,-48]
      });
      var m=L.marker([s.lat,s.lng],{icon:icon}).addTo(map);
      m.bindPopup(
        '<div style="font-family:sans-serif;min-width:220px;"><div style="background:'+bg+';padding:12px 15px;">'
        +'<div style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.75);margin-bottom:3px;">'+s.day+'</div>'
        +'<div style="font-size:1rem;font-weight:700;color:#fff;">'+s.name+'</div>'
        +'<div style="font-size:.85rem;color:rgba(255,255,255,.85);margin-top:2px;">'+s.elev+'</div></div>'
        +'<div style="padding:9px 15px;background:#fff;font-size:.83rem;color:#7A6040;font-style:italic;line-height:1.5;">'
        +(isSummit?"Africa's highest point — 5,895m!":(isStart?'Journey begins here':'Click day card to explore'))
        +'</div></div>',{maxWidth:240,closeButton:false}
      );
      mmap[s.id]=m;
      // Animated name label
      var lblDelay=delay+320;
      var nameIcon=L.divIcon({
        html:'<div style="background:rgba(255,255,255,0.93);border:1.5px solid '+bdr+';border-radius:4px;padding:2px 7px;white-space:nowrap;box-shadow:0 2px 8px rgba(90,60,0,.18);opacity:0;animation:popIn 0.4s cubic-bezier(.34,1.56,.64,1) '+lblDelay+'ms both;"><span style="font-size:11px;font-weight:700;color:'+bg+';font-family:sans-serif;letter-spacing:.03em;">'+s.name+'</span></div>',
        className:'',iconSize:[0,0],iconAnchor:[0,-52],popupAnchor:[0,-60]
      });
      var nm=L.marker([s.lat,s.lng],{icon:nameIcon,interactive:false,zIndexOffset:-10}).addTo(map);
      mmap['lbl_'+s.id]=nm;
    });
    var line=L.polyline([],{color:'#7A5C18',weight:3,dashArray:'10 8',opacity:.92}).addTo(map);
    animLine=line;
    var dotIcon=L.divIcon({
      html:'<div style="width:14px;height:14px;background:#fff;border:3px solid #A07828;border-radius:50%;animation:pulse 1s ease-in-out infinite;"></div>',
      className:'',iconSize:[14,14],iconAnchor:[7,7]
    });
    var dot=L.marker(fullRoute[0],{icon:dotIcon,zIndexOffset:1000}).addTo(map);
    dotMarker=dot;
    var duration=5000,startTs=null,segs=fullRoute.length-1;
    function step(ts){
      if(!startTs) startTs=ts;
      var t=Math.min((ts-startTs)/duration,1),p=ease(t);
      var sp=p*segs,si=Math.min(Math.floor(sp),segs-1),st=sp-si;
      var cur=lerp(fullRoute[si],fullRoute[Math.min(si+1,segs)],st);
      line.setLatLngs(fullRoute.slice(0,si+1).concat([cur]));
      dot.setLatLng(cur);
      if(t<1){raf=requestAnimationFrame(step);}
      else{
        setTimeout(function(){if(dotMarker){try{map.removeLayer(dotMarker);}catch(e){}dotMarker=null;}},800);
        loopTimer=setTimeout(window.runAnimation,3000);
      }
    }
    setTimeout(function(){raf=requestAnimationFrame(step);},600);
  };
  setTimeout(window.runAnimation,800);

  var views={
    1:{c:[-3.055,37.07],z:12,id:'mti'},
    2:{c:[-3.028,37.11],z:12,id:'shira1'},
    3:{c:[-3.010,37.135],z:12,id:'shira2'},
    4:{c:[-3.065,37.21],z:11,id:'barranco'},
    5:{c:[-3.080,37.24],z:12,id:'karanga'},
    6:{c:[-3.065,37.295],z:12,id:'barafu'},
    7:{c:[-3.076,37.354],z:13,id:'summit'},
    8:{c:[-3.127,37.31],z:11,id:'mwekagate'}
  };

  window.fd = function(day){
    document.querySelectorAll('.mw-dc').forEach(function(c){c.classList.remove('on');});
    var el = document.querySelector('[data-day="'+day+'"]');
    if(el) el.classList.add('on');
    var v=views[day];
    if(v) {
      map.flyTo(v.c,v.z,{duration:1.1,easeLinearity:.4});
      if(mmap[v.id]) mmap[v.id].openPopup();
    }
  };

  window.toggleFaq = function(btn){
    var item=btn.parentElement;
    item.classList.toggle('open');
  };

  // Popup logic
  var popupOverlay = document.getElementById('ryder-popup-overlay');
  var popupClose = document.querySelector('.ryder-popup-close');
  var triggerBtns = document.querySelectorAll('.ryder-trigger-popup');

  if (popupOverlay) {
    triggerBtns.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        popupOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
      });
    });

    if (popupClose) {
      popupClose.addEventListener('click', function() {
        popupOverlay.classList.remove('active');
        document.body.style.overflow = '';
      });
    }

    popupOverlay.addEventListener('click', function(e) {
      if (e.target === popupOverlay) {
        popupOverlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && popupOverlay.classList.contains('active')) {
        popupOverlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  }
});
