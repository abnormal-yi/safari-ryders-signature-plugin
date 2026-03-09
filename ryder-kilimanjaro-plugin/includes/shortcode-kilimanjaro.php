<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode( 'ryder_kilimanjaro', 'ryder_kilimanjaro_shortcode' );

function ryder_kilimanjaro_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id' => get_the_ID(),
    ), $atts, 'ryder_kilimanjaro' );

    $post_id = $atts['id'];

    // Enqueue assets specifically when shortcode is used
    wp_enqueue_style( 'google-fonts-playfair', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap', array(), null );
    wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
    wp_enqueue_style( 'ryder-kilimanjaro-style', RYDER_KILIMANJARO_PLUGIN_URL . 'assets/css/kilimanjaro.css', array(), '1.0.0' );
    
    wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
    wp_enqueue_script( 'ryder-kilimanjaro-script', RYDER_KILIMANJARO_PLUGIN_URL . 'assets/js/kilimanjaro.js', array('leaflet-js'), '1.0.0', true );

    // Helper to get field with fallback
    $get_field = function($field_name, $fallback) use ($post_id) {
        if ( function_exists('get_field') ) {
            $val = get_field($field_name, $post_id);
            if ( $val !== null && $val !== '' && $val !== false ) {
                return $val;
            }
        }
        return $fallback;
    };

    ob_start();
    ?>
    <div class="ryder-kili-wrapper" id="ryder-kilimanjaro-<?php echo esc_attr($post_id); ?>">
        <!-- HERO -->
        <section class="hero">
          <div class="hero__inner">
            <div class="hero__badge">⭐ 4.9/5 · 312 Reviews · 90–95% Summit Success</div>
            <h1 class="hero__title">Lemosho Route 8-Day Kilimanjaro Climb:<br>Africa's Most Scenic Summit Path</h1>
            <p class="hero__subtitle">Traverse the pristine western wilderness of Kilimanjaro through ancient rainforest and the breathtaking Shira Plateau. The 8-day Lemosho Route delivers unmatched scenic beauty, excellent acclimatisation, and the uncrowded experience discerning climbers seek.</p>
            <div class="hero__stats">
              <div class="hero__stat"><span class="hero__stat-val">10 Days</span><span class="hero__stat-lbl">Total Duration</span></div>
              <div class="hero__stat"><span class="hero__stat-val">5,895m</span><span class="hero__stat-lbl">Uhuru Peak</span></div>
              <div class="hero__stat"><span class="hero__stat-val">66 km</span><span class="hero__stat-lbl">Trek Distance</span></div>
              <div class="hero__stat"><span class="hero__stat-val">4,449m</span><span class="hero__stat-lbl">Elevation Gain</span></div>
              <div class="hero__stat"><span class="hero__stat-val">90–95%</span><span class="hero__stat-lbl">Success Rate</span></div>
            </div>
            <div class="hero__ctas">
              <a href="#" class="btn btn--gold ryder-trigger-popup">Book Your Lemosho Adventure →</a>
              <a href="#itinerary" class="btn btn--outline">View Full Itinerary</a>
            </div>
          </div>
        </section>

        <!-- QUICK FACTS -->
        <section class="section">
          <div class="container">
            <div class="facts-grid">
              <div class="fact-card"><div class="fact-card__label">Duration</div><div class="fact-card__value">10 Days (8 climbing days)</div></div>
              <div class="fact-card"><div class="fact-card__label">Route</div><div class="fact-card__value">Lemosho Glades → Mweka Gate</div></div>
              <div class="fact-card"><div class="fact-card__label">Distance</div><div class="fact-card__value">66 km (41 miles)</div></div>
              <div class="fact-card"><div class="fact-card__label">Starting Elevation</div><div class="fact-card__value">2,100m (6,890 ft)</div></div>
              <div class="fact-card"><div class="fact-card__label">Summit Elevation</div><div class="fact-card__value">5,895m (19,341 ft)</div></div>
              <div class="fact-card"><div class="fact-card__label">Difficulty</div><div class="fact-card__value">Moderate to Challenging</div></div>
              <div class="fact-card"><div class="fact-card__label">Best Seasons</div><div class="fact-card__value">Jan–Mar · Jun–Oct</div></div>
              <div class="fact-card"><div class="fact-card__label">Group Size</div><div class="fact-card__value">Private (2+ climbers)</div></div>
              <div class="fact-card"><div class="fact-card__label">Crowd Level</div><div class="fact-card__value">Low to Moderate</div></div>
              <div class="fact-card"><div class="fact-card__label">Accommodation</div><div class="fact-card__value">Mountain camping (tents)</div></div>
            </div>
          </div>
        </section>

        <!-- OVERVIEW -->
        <section class="section section--alt" id="overview">
          <div class="container">
            <div class="overview-grid">
              <div>
                <div class="sec-header">
                  <span class="sec-header__eyebrow">Route Overview</span>
                  <h2 class="sec-header__title">Why the Lemosho Route Represents Kilimanjaro's Finest</h2>
                  <div class="divider"></div>
                </div>

                <p>The Lemosho Route 8-day Kilimanjaro itinerary consistently ranks as the mountain's premier climbing option among experienced guides and returning climbers. This western approach delivers what serious adventurers seek: pristine wilderness, exceptional scenery, manageable crowds, and acclimatisation profiles that translate directly to summit success rates exceeding 90%.</p>

                <p>Where other routes funnel climbers through well-worn paths, the Lemosho enters Kilimanjaro from the remote western slopes via the lush Lemosho Glades. The first two days traverse genuine wilderness where elephant and buffalo sightings remain possible — a wild introduction unavailable on busier routes. The gradual ascent through the Shira Plateau provides extended acclimatisation impossible to replicate on faster approaches.</p>

                <p>The Shira Plateau crossing defines this route's character. This vast, otherworldly landscape — the collapsed caldera of Kilimanjaro's oldest volcanic cone — stretches beneath Kibo Peak's imposing western face. Nowhere else on the mountain offers such expansive vistas combined with relatively gentle terrain. Climbers consistently describe these days as transformative, the mountain's scale becoming tangible through sustained immersion.</p>

                <p>RYDER Signature particularly recommends the 8-day Lemosho Route for photographers, nature enthusiasts, those seeking uncrowded trails, and any climber prioritising experience quality alongside summit success.</p>

                <div class="overview-features">
                  <div class="feature-card">
                    <div class="feature-card__icon">🌿</div>
                    <div class="feature-card__title">Wilderness Immersion</div>
                    <p class="feature-card__text">Remote western trailhead with possible elephant and buffalo encounters in ancient montane forest.</p>
                  </div>
                  <div class="feature-card">
                    <div class="feature-card__icon">🏔️</div>
                    <div class="feature-card__title">Exceptional Scenery</div>
                    <p class="feature-card__text">The full Shira Plateau crossing — 16km beneath Kibo's western face — delivers Kilimanjaro's finest panoramas.</p>
                  </div>
                  <div class="feature-card">
                    <div class="feature-card__icon">📈</div>
                    <div class="feature-card__title">Superior Acclimatisation</div>
                    <p class="feature-card__text">Gradual elevation profile with a dedicated "climb high, sleep low" day at Lava Tower boosts summit success.</p>
                  </div>
                  <div class="feature-card">
                    <div class="feature-card__icon">🧭</div>
                    <div class="feature-card__title">Lower Crowds</div>
                    <p class="feature-card__text">Remote trailhead deters casual climbers, creating more intimate camps and quieter trails throughout.</p>
                  </div>
                </div>
              </div>

              <!-- SIDEBAR CALLOUT -->
              <div>
                <div class="callout">
                  <div class="callout__head">
                    <h3>Price Per Person</h3>
                    <p>All-inclusive · Private departures</p>
                  </div>
                  <div class="callout__body">
                    <div class="price-slab">
                      <div class="price-row">
                        <span class="price-row__group">Solo Climber</span>
                        <span class="price-row__price">$4,800 <span>/ person</span></span>
                      </div>
                      <div class="price-row">
                        <span class="price-row__group">2 Climbers</span>
                        <span class="price-row__price">$3,900 <span>/ person</span></span>
                      </div>
                      <div class="price-row">
                        <span class="price-row__group">3–4 Climbers</span>
                        <span class="price-row__price">$3,500 <span>/ person</span></span>
                      </div>
                      <div class="price-row">
                        <span class="price-row__group">5+ Climbers</span>
                        <span class="price-row__price">$3,200 <span>/ person</span></span>
                      </div>
                    </div>
                    <p class="callout__note"><strong>All prices include:</strong> Park fees, professional guides, porters, all mountain meals, tents, emergency oxygen, and airport transfers. <a href="#inclusions">Full inclusions list ↓</a></p>
                    <a href="#" class="btn btn--gold ryder-trigger-popup" style="width:100%;justify-content:center;margin-bottom:10px;">Request a Quote →</a>
                    <a href="#itinerary" class="btn btn--outline" style="width:100%;justify-content:center;color:var(--dark);border-color:var(--border);">View Full Itinerary ↓</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- MAP SECTION -->
        <section class="map-section" id="map">
          <div class="container">
            <div class="sec-header">
              <span class="sec-header__eyebrow">Explore the Route</span>
              <h2 class="sec-header__title" style="color:#fff;">Interactive Route Map &amp; Elevation Profile</h2>
              <div class="divider"></div>
              <p class="sec-header__lead">Follow the complete Lemosho Route from Lemosho Glades to Mweka Gate. Click each camp marker for details, or select a day card to fly to that location. The elevation profile below shows the full 66km journey with accurate altitude zones.</p>
            </div>

            <div class="map-embed-wrapper">
              <div class="map-widget">
                <!-- LEGEND -->
                <div class="mw-legend">
                  <div class="mw-li"><span class="mw-dot" style="background:#3D2E0A;border:2.5px solid #6B5520"></span>Start / End</div>
                  <div class="mw-li"><span class="mw-dot" style="background:#A07828;border:2.5px solid #C49A3C"></span>Mountain Camps</div>
                  <div class="mw-li"><span class="mw-dot" style="background:#B8860B;border:2.5px solid #FFD700"></span>Summit (5,895m)</div>
                  <div class="mw-li"><span class="mw-dash"></span>Climbing Route</div>
                </div>
                <!-- STATS BADGE -->
                <div class="mw-badge">
                  Elevation Gain: <span>4,449m</span> &nbsp;|&nbsp; Elevation Loss: <span>4,909m</span> &nbsp;|&nbsp; Total Distance: <span>66 km</span>
                </div>
                <!-- BODY: MAP LEFT + ITINERARY RIGHT -->
                <div class="mw-body">
                  <div class="mw-left">
                    <!-- MAP -->
                    <div class="mw-mapcard">
                      <div id="s-map"></div>
                      <div class="mw-mf">
                        <span class="mw-mfl">8-Day Route</span>
                        <div style="display:flex;gap:7px;flex-wrap:wrap;">
                          <span class="mw-ftag">Lemosho Gate → Uhuru Peak</span>
                          <span class="mw-ftag">Most Scenic Route</span>
                          <span class="mw-ftag">90%+ Success Rate</span>
                        </div>
                      </div>
                    </div>
                    <!-- ELEVATION PROFILE -->
                    <div class="mw-elevation">
                      <div class="mw-elev-title">8-Day Lemosho Route — Elevation Profile</div>
                      <div class="mw-graph-container">
                        <svg class="mw-graph-svg" viewBox="0 0 1060 340" preserveAspectRatio="xMidYMid meet">
                          <defs>
                            <linearGradient id="zoneRainforest2" x1="0%" y1="0%" x2="0%" y2="100%">
                              <stop offset="0%" style="stop-color:#5a8a3c;stop-opacity:0.5"/>
                              <stop offset="100%" style="stop-color:#5a8a3c;stop-opacity:0.06"/>
                            </linearGradient>
                            <linearGradient id="zoneMoorland2" x1="0%" y1="0%" x2="0%" y2="100%">
                              <stop offset="0%" style="stop-color:#8aaa4a;stop-opacity:0.4"/>
                              <stop offset="100%" style="stop-color:#8aaa4a;stop-opacity:0.05"/>
                            </linearGradient>
                            <linearGradient id="zoneAlpine2" x1="0%" y1="0%" x2="0%" y2="100%">
                              <stop offset="0%" style="stop-color:#C49A3C;stop-opacity:0.5"/>
                              <stop offset="100%" style="stop-color:#C49A3C;stop-opacity:0.06"/>
                            </linearGradient>
                            <linearGradient id="zoneArctic2" x1="0%" y1="0%" x2="0%" y2="100%">
                              <stop offset="0%" style="stop-color:#7aaace;stop-opacity:0.6"/>
                              <stop offset="100%" style="stop-color:#aaccee;stop-opacity:0.08"/>
                            </linearGradient>
                            <linearGradient id="zoneDescent2" x1="0%" y1="0%" x2="0%" y2="100%">
                              <stop offset="0%" style="stop-color:#A07828;stop-opacity:0.35"/>
                              <stop offset="100%" style="stop-color:#A07828;stop-opacity:0.05"/>
                            </linearGradient>
                            <radialGradient id="summitGlow2" cx="50%" cy="50%" r="50%">
                              <stop offset="0%" style="stop-color:#FFD700;stop-opacity:0.55"/>
                              <stop offset="100%" style="stop-color:#FFD700;stop-opacity:0"/>
                            </radialGradient>
                          </defs>
                          <!-- Zone bands -->
                          <path d="M 20,300 L 20,257 L 107,209 L 107,300 Z" fill="url(#zoneRainforest2)" opacity="0.75"/>
                          <path d="M 107,300 L 107,209 L 224,165 L 311,151 L 384,103 L 456,143 L 529,142 L 529,300 Z" fill="url(#zoneMoorland2)" opacity="0.65"/>
                          <path d="M 529,300 L 529,142 L 587,101 L 587,300 Z" fill="url(#zoneAlpine2)" opacity="0.65"/>
                          <path d="M 587,300 L 587,101 L 689,26 L 689,300 Z" fill="url(#zoneArctic2)" opacity="0.7"/>
                          <path d="M 689,300 L 689,26 L 835,197 L 980,285 L 980,300 Z" fill="url(#zoneDescent2)" opacity="0.55"/>
                          <!-- Grid lines -->
                          <line x1="20" y1="264" x2="980" y2="264" stroke="#E8DFC8" stroke-width="1" stroke-dasharray="4 5"/>
                          <line x1="20" y1="203" x2="980" y2="203" stroke="#E8DFC8" stroke-width="1" stroke-dasharray="4 5"/>
                          <line x1="20" y1="142" x2="980" y2="142" stroke="#E8DFC8" stroke-width="1" stroke-dasharray="4 5"/>
                          <line x1="20" y1="81"  x2="980" y2="81"  stroke="#E8DFC8" stroke-width="1" stroke-dasharray="4 5"/>
                          <line x1="20" y1="20"  x2="980" y2="20"  stroke="#E8DFC8" stroke-width="0.6" stroke-dasharray="2 6" opacity="0.5"/>
                          <line x1="20" y1="300" x2="980" y2="300" stroke="#D4B96A" stroke-width="1.5"/>
                          <line x1="20" y1="20"  x2="20"  y2="300" stroke="#D4B96A" stroke-width="1"/>
                          <!-- Y-axis labels -->
                          <text x="14" y="268" font-size="11" fill="#6B5020" text-anchor="end" font-family="sans-serif" font-weight="600">2,000m</text>
                          <text x="14" y="207" font-size="11" fill="#6B5020" text-anchor="end" font-family="sans-serif" font-weight="600">3,000m</text>
                          <text x="14" y="146" font-size="11" fill="#6B5020" text-anchor="end" font-family="sans-serif" font-weight="600">4,000m</text>
                          <text x="14" y="85"  font-size="11" fill="#6B5020" text-anchor="end" font-family="sans-serif" font-weight="600">5,000m</text>
                          <text x="14" y="24"  font-size="11" fill="#A07828" text-anchor="end" font-family="sans-serif" font-weight="700">6,000m</text>
                          <!-- Zone labels -->
                          <text x="64"  y="293" font-size="8.5" fill="#4a7a2c" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">RAINFOREST</text>
                          <text x="318" y="293" font-size="8.5" fill="#5a7a20" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">HEATH / MOORLAND</text>
                          <text x="558" y="293" font-size="8.5" fill="#8A6018" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">ALPINE</text>
                          <text x="638" y="293" font-size="8.5" fill="#5588aa" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.9">ARCTIC</text>
                          <text x="835" y="293" font-size="8.5" fill="#8A6018" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.75">DESCENT</text>
                          <!-- Main fill -->
                          <path d="M 20,300 L 20,257 L 107,209 L 224,165 L 311,151 L 384,103 L 456,143 L 529,142 L 587,101 L 689,26 L 835,197 L 980,285 L 980,300 Z" fill="#F7F1E3" opacity="0.55"/>
                          <!-- Profile line -->
                          <path d="M 20,257 L 107,209 L 224,165 L 311,151 L 384,103 L 456,143 L 529,142 L 587,101 L 689,26 L 835,197 L 980,285" fill="none" stroke="#A07828" stroke-width="2.8" stroke-linejoin="round" stroke-linecap="round"/>
                          <!-- Accli annotation -->
                          <path d="M 311,151 Q 384,58 456,143" fill="none" stroke="#C49A3C" stroke-width="1.8" stroke-dasharray="6 4" opacity="0.8"/>
                          <text x="384" y="46" font-size="9" fill="#7A5C18" text-anchor="middle" font-family="sans-serif" font-weight="700" font-style="italic">Climb high, sleep low</text>
                          <text x="384" y="57" font-size="8" fill="#8A7250" text-anchor="middle" font-family="sans-serif">(acclimatisation day)</text>
                          <!-- Summit glow -->
                          <circle cx="689" cy="26" r="34" fill="url(#summitGlow2)"/>
                          <!-- Day dividers -->
                          <line x1="107" y1="300" x2="107" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <line x1="224" y1="300" x2="224" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <line x1="311" y1="300" x2="311" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <line x1="456" y1="300" x2="456" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <line x1="529" y1="300" x2="529" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <line x1="587" y1="300" x2="587" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <line x1="835" y1="300" x2="835" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>
                          <!-- Day labels -->
                          <text x="64"  y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D1</text>
                          <text x="165" y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D2</text>
                          <text x="267" y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D3</text>
                          <text x="384" y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D4</text>
                          <text x="493" y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D5</text>
                          <text x="558" y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D6</text>
                          <text x="711" y="13" font-size="8.5" fill="#B8860B" text-anchor="middle" font-family="sans-serif" font-weight="800">D7 — SUMMIT</text>
                          <text x="907" y="13" font-size="8"   fill="#A07828" text-anchor="middle" font-family="sans-serif" font-weight="700" opacity="0.85">D8</text>
                          <!-- Camp markers -->
                          <circle cx="20"  cy="257" r="5.5" fill="#3D2E0A" stroke="#fff" stroke-width="2"/>
                          <rect x="-14" y="263" width="68" height="15" fill="#3D2E0A" rx="3"/>
                          <text x="20"  y="274" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">LEMOSHO</text>
                          <text x="20"  y="252" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">2,100m</text>
                          <circle cx="107" cy="209" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="69" y="191" width="76" height="15" fill="#A07828" rx="3"/>
                          <text x="107" y="202" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">MTI MKUBWA</text>
                          <text x="107" y="225" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">2,895m</text>
                          <circle cx="224" cy="165" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="191" y="147" width="66" height="15" fill="#A07828" rx="3"/>
                          <text x="224" y="158" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">SHIRA 1</text>
                          <text x="224" y="181" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">3,610m</text>
                          <circle cx="311" cy="151" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="278" y="133" width="66" height="15" fill="#A07828" rx="3"/>
                          <text x="311" y="144" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">SHIRA 2</text>
                          <text x="311" y="167" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">3,840m</text>
                          <circle cx="384" cy="103" r="4.5" fill="#C49A3C" stroke="#fff" stroke-width="1.8"/>
                          <text x="384" y="118" font-size="9" fill="#7A5C18" text-anchor="middle" font-family="sans-serif" font-weight="700" font-style="italic">4,630m</text>
                          <circle cx="456" cy="143" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="418" y="152" width="76" height="15" fill="#A07828" rx="3"/>
                          <text x="456" y="163" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">BARRANCO</text>
                          <text x="456" y="136" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">3,976m</text>
                          <circle cx="529" cy="142" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="493" y="152" width="72" height="15" fill="#A07828" rx="3"/>
                          <text x="529" y="163" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">KARANGA</text>
                          <text x="529" y="135" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">3,995m</text>
                          <circle cx="587" cy="101" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="555" y="83" width="64" height="15" fill="#A07828" rx="3"/>
                          <text x="587" y="94" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">BARAFU</text>
                          <text x="587" y="117" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">4,673m</text>
                          <circle cx="689" cy="26"  r="8" fill="#B8860B" stroke="#FFD700" stroke-width="3"/>
                          <text x="689" y="30" font-size="10" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="900">★</text>
                          <rect x="651" y="35" width="76" height="15" fill="#B8860B" rx="3"/>
                          <text x="689" y="46" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">UHURU PEAK</text>
                          <text x="689" y="21" font-size="10" fill="#B8860B" text-anchor="middle" font-family="sans-serif" font-weight="800">5,895m</text>
                          <circle cx="835" cy="197" r="5" fill="#A07828" stroke="#fff" stroke-width="2"/>
                          <rect x="800" y="206" width="70" height="15" fill="#A07828" rx="3"/>
                          <text x="835" y="217" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">MWEKA</text>
                          <text x="835" y="191" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">3,100m</text>
                          <circle cx="980" cy="285" r="5.5" fill="#3D2E0A" stroke="#fff" stroke-width="2"/>
                          <rect x="936" y="268" width="88" height="15" fill="#3D2E0A" rx="3"/>
                          <text x="980" y="279" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">MWEKA GATE</text>
                          <text x="980" y="302" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">1,640m</text>
                          <!-- X-axis ticks & labels -->
                          <line x1="20"  y1="300" x2="20"  y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="107" y1="300" x2="107" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="224" y1="300" x2="224" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="311" y1="300" x2="311" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="456" y1="300" x2="456" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="529" y1="300" x2="529" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="587" y1="300" x2="587" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="689" y1="300" x2="689" y2="306" stroke="#B8860B" stroke-width="1.5"/>
                          <line x1="835" y1="300" x2="835" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <line x1="980" y1="300" x2="980" y2="306" stroke="#D4B96A" stroke-width="1.2"/>
                          <text x="20"  y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">0</text>
                          <text x="107" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">6</text>
                          <text x="224" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">14</text>
                          <text x="311" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">20</text>
                          <text x="456" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">30</text>
                          <text x="529" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">35</text>
                          <text x="587" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">39</text>
                          <text x="689" y="317" font-size="9.5" fill="#B8860B" text-anchor="middle" font-family="sans-serif" font-weight="700">46</text>
                          <text x="835" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">56</text>
                          <text x="980" y="317" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">66 km</text>
                          <text x="500" y="334" font-size="10" fill="#8A7250" text-anchor="middle" font-family="sans-serif" font-weight="600">Cumulative Distance (km) · Total Trek: 66 km</text>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <!-- ITINERARY SIDEBAR -->
                  <div class="mw-itin">
                    <div class="mw-dc on" data-day="1">
                      <div class="mw-db"><span>Day</span><strong>1</strong></div>
                      <p class="mw-dlbl">Wilderness Gateway</p>
                      <div class="mw-dtitle">Lemosho Gate → Mti Mkubwa</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 2,100m → 2,895m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 6 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 3–4 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Rainforest</div>
                      </div>
                    </div>
                    <div class="mw-dc" data-day="2">
                      <div class="mw-db"><span>Day</span><strong>2</strong></div>
                      <p class="mw-dlbl">Forest Transition</p>
                      <div class="mw-dtitle">Mti Mkubwa → Shira 1</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 2,895m → 3,610m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 8 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 5–7 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Heath/Moorland</div>
                      </div>
                    </div>
                    <div class="mw-dc" data-day="3">
                      <div class="mw-db"><span>Day</span><strong>3</strong></div>
                      <p class="mw-dlbl">Plateau Crossing</p>
                      <div class="mw-dtitle">Shira 1 → Shira 2</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 3,610m → 3,840m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 6 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 4–5 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Moorland</div>
                      </div>
                    </div>
                    <div class="mw-dc" data-day="4">
                      <div class="mw-db"><span>Day</span><strong>4</strong></div>
                      <p class="mw-dlbl">Altitude Challenge</p>
                      <div class="mw-dtitle">Shira 2 → Lava Tower → Barranco</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 3,840m → 4,630m → 3,976m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 10 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 6–8 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Alpine Desert</div>
                      </div>
                    </div>
                    <div class="mw-dc" data-day="5">
                      <div class="mw-db"><span>Day</span><strong>5</strong></div>
                      <p class="mw-dlbl">Wall Conquest</p>
                      <div class="mw-dtitle">Barranco → Karanga</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 3,976m → 3,995m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 5 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 4–5 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Alpine Desert</div>
                      </div>
                    </div>
                    <div class="mw-dc" data-day="6">
                      <div class="mw-db"><span>Day</span><strong>6</strong></div>
                      <p class="mw-dlbl">High Camp Arrival</p>
                      <div class="mw-dtitle">Karanga → Barafu Camp</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 3,995m → 4,673m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 4 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 4–5 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Alpine Desert</div>
                      </div>
                    </div>
                    <div class="mw-dc summit-day" data-day="7">
                      <div class="mw-db"><span>Day</span><strong>7</strong></div>
                      <p class="mw-dlbl">★ SUMMIT DAY</p>
                      <div class="mw-dtitle">Barafu → Uhuru Peak → Mweka</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 4,673m → 5,895m → 3,100m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 17 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 12–16 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Arctic → Rainforest</div>
                      </div>
                    </div>
                    <div class="mw-dc" data-day="8">
                      <div class="mw-db"><span>Day</span><strong>8</strong></div>
                      <p class="mw-dlbl">Celebration Descent</p>
                      <div class="mw-dtitle">Mweka Camp → Mweka Gate</div>
                      <div class="mw-stats">
                        <div class="mw-stat"><strong>Elev:</strong> 3,100m → 1,640m</div>
                        <div class="mw-stat"><strong>Dist:</strong> 10 km</div>
                        <div class="mw-stat"><strong>Time:</strong> 3–4 hrs</div>
                        <div class="mw-stat"><strong>Zone:</strong> Rainforest</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- CTA BANNER -->
        <section class="cta-banner">
          <div class="container">
            <h2>Experience Kilimanjaro's Finest Route</h2>
            <p>The Lemosho Route 8-Day climb offers discerning adventurers what mass-market routes cannot: genuine wilderness, exceptional scenery, manageable crowds, and the acclimatisation profile that delivers summit success. Kilimanjaro's premium experience awaits.</p>
            <div class="cta-banner__btns">
              <a href="#" class="btn btn--gold ryder-trigger-popup">Request Your Lemosho Quote →</a>
            </div>
          </div>
        </section>

        <!-- POPUP OVERLAY -->
        <div id="ryder-popup-overlay" class="ryder-popup-overlay">
          <div class="ryder-popup-content">
            <button class="ryder-popup-close">&times;</button>
            <h3 style="font-family:var(--font-display); font-size:1.8rem; margin-bottom:15px; color:var(--dark); text-align:center;">Trip Information</h3>
            <?php echo do_shortcode('[fluentform id="7"]'); ?>
          </div>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
