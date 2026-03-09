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
            <div class="hero__badge"><?php echo esc_html( $get_field('ryder_hero_badge', '⭐ 4.9/5 · 312 Reviews · 90–95% Summit Success') ); ?></div>
            <h1 class="hero__title"><?php echo wp_kses_post( $get_field('ryder_hero_title', "Lemosho Route 8-Day Kilimanjaro Climb:<br>Africa's Most Scenic Summit Path") ); ?></h1>
            <p class="hero__subtitle"><?php echo esc_html( $get_field('ryder_hero_subtitle', 'Traverse the pristine western wilderness of Kilimanjaro through ancient rainforest and the breathtaking Shira Plateau. The 8-day Lemosho Route delivers unmatched scenic beauty, excellent acclimatisation, and the uncrowded experience discerning climbers seek.') ); ?></p>
            <div class="hero__stats">
              <div class="hero__stat"><span class="hero__stat-val"><?php echo esc_html( $get_field('ryder_duration', '10 Days') ); ?></span><span class="hero__stat-lbl">Total Duration</span></div>
              <div class="hero__stat"><span class="hero__stat-val"><?php echo esc_html( $get_field('ryder_summit_elev', '5,895m') ); ?></span><span class="hero__stat-lbl">Uhuru Peak</span></div>
              <div class="hero__stat"><span class="hero__stat-val"><?php echo esc_html( $get_field('ryder_distance', '66 km') ); ?></span><span class="hero__stat-lbl">Trek Distance</span></div>
              <div class="hero__stat"><span class="hero__stat-val"><?php echo esc_html( $get_field('ryder_elev_gain', '4,449m') ); ?></span><span class="hero__stat-lbl">Elevation Gain</span></div>
              <div class="hero__stat"><span class="hero__stat-val"><?php echo esc_html( $get_field('ryder_success_rate', '90–95%') ); ?></span><span class="hero__stat-lbl">Success Rate</span></div>
            </div>
            <div class="hero__ctas">
              <a href="#" class="btn btn--gold ryder-trigger-popup">Book Your Adventure →</a>
              <a href="#itinerary" class="btn btn--outline">View Full Itinerary</a>
            </div>
          </div>
        </section>

        <!-- QUICK FACTS -->
        <section class="section">
          <div class="container">
            <div class="facts-grid">
              <div class="fact-card"><div class="fact-card__label">Duration</div><div class="fact-card__value"><?php echo esc_html( $get_field('ryder_duration', '10 Days') ); ?></div></div>
              <div class="fact-card"><div class="fact-card__label">Route</div><div class="fact-card__value">Lemosho Glades → Mweka Gate</div></div>
              <div class="fact-card"><div class="fact-card__label">Distance</div><div class="fact-card__value"><?php echo esc_html( $get_field('ryder_distance', '66 km') ); ?></div></div>
              <div class="fact-card"><div class="fact-card__label">Starting Elevation</div><div class="fact-card__value">2,100m</div></div>
              <div class="fact-card"><div class="fact-card__label">Summit Elevation</div><div class="fact-card__value"><?php echo esc_html( $get_field('ryder_summit_elev', '5,895m') ); ?></div></div>
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
                  <h2 class="sec-header__title"><?php echo esc_html( $get_field('ryder_overview_title', "Why the Lemosho Route Represents Kilimanjaro's Finest") ); ?></h2>
                  <div class="divider"></div>
                </div>

                <div class="overview-content">
                    <?php echo wp_kses_post( $get_field('ryder_overview_content', '<p>The Lemosho Route 8-day Kilimanjaro itinerary consistently ranks as the mountain\'s premier climbing option among experienced guides and returning climbers.</p>') ); ?>
                </div>

                <div class="overview-features">
                  <?php
                  $features = $get_field('ryder_features', array());
                  if ( !empty($features) && is_array($features) ) {
                      foreach ( $features as $feature ) {
                          ?>
                          <div class="feature-card">
                            <div class="feature-card__icon"><?php echo esc_html($feature['icon']); ?></div>
                            <div class="feature-card__title"><?php echo esc_html($feature['title']); ?></div>
                            <p class="feature-card__text"><?php echo esc_html($feature['description']); ?></p>
                          </div>
                          <?php
                      }
                  } else {
                      // Fallback
                      ?>
                      <div class="feature-card">
                        <div class="feature-card__icon">🌿</div>
                        <div class="feature-card__title">Wilderness Immersion</div>
                        <p class="feature-card__text">Remote western trailhead with possible elephant and buffalo encounters in ancient montane forest.</p>
                      </div>
                      <?php
                  }
                  ?>
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
                      <?php
                      $pricing = $get_field('ryder_pricing', array());
                      if ( !empty($pricing) && is_array($pricing) ) {
                          foreach ( $pricing as $price ) {
                              $is_featured = isset($price['is_featured']) && $price['is_featured'] ? ' style="background:var(--gold-bg);"' : '';
                              ?>
                              <div class="price-row"<?php echo $is_featured; ?>>
                                <span class="price-row__group"><?php echo esc_html($price['group']); ?></span>
                                <span class="price-row__price"><?php echo esc_html($price['price']); ?> <span>/ person</span></span>
                              </div>
                              <?php
                          }
                      } else {
                          // Fallback
                          ?>
                          <div class="price-row">
                            <span class="price-row__group">Solo Climber</span>
                            <span class="price-row__price">$4,800 <span>/ person</span></span>
                          </div>
                          <?php
                      }
                      ?>
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

        <!-- ITINERARY AT A GLANCE -->
        <section class="section" id="glance">
          <div class="container">
            <div class="sec-header">
              <span class="sec-header__eyebrow">Itinerary at a Glance</span>
              <h2 class="sec-header__title">Your <?php echo esc_html( $get_field('ryder_duration', '10 Days') ); ?> Journey</h2>
              <div class="divider"></div>
              <p class="sec-header__lead">From arrival to your return — every day, every elevation, every detail at a glance.</p>
            </div>
            <div style="overflow-x:auto;">
            <table class="glance-table">
              <thead>
                <tr>
                  <th>Day</th>
                  <th>Stage &amp; Destination</th>
                  <th>Elevation</th>
                  <th>Distance</th>
                  <th>Duration</th>
                  <th>Zone</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $glance_rows = $get_field('ryder_glance', array());
                if ( !empty($glance_rows) && is_array($glance_rows) ) {
                    foreach ( $glance_rows as $row ) {
                        $is_summit = (stripos($row['route'], 'Uhuru') !== false || stripos($row['route'], 'Summit') !== false);
                        $row_class = $is_summit ? ' class="summit-row"' : '';
                        ?>
                        <tr<?php echo $row_class; ?>>
                          <td><?php echo esc_html($row['day']); ?></td>
                          <td><?php echo wp_kses_post($row['route']); ?></td>
                          <td><?php echo esc_html($row['elev']); ?></td>
                          <td><?php echo esc_html($row['dist']); ?></td>
                          <td><?php echo esc_html($row['time']); ?></td>
                          <td><?php echo esc_html($row['zone']); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    // Fallback
                    ?>
                    <tr>
                      <td>Day 1</td>
                      <td>Lemosho Glades → <strong>Mti Mkubwa Camp</strong></td>
                      <td>2,100m → 2,895m</td>
                      <td>6 km</td>
                      <td>3–4 hrs</td>
                      <td>Rainforest</td>
                    </tr>
                    <tr>
                      <td>Day 2</td>
                      <td>Mti Mkubwa → <strong>Shira 1 Camp</strong></td>
                      <td>2,895m → 3,610m</td>
                      <td>8 km</td>
                      <td>5–7 hrs</td>
                      <td>Heath / Moorland</td>
                    </tr>
                    <tr>
                      <td>Day 3</td>
                      <td>Shira 1 → <strong>Shira 2 Camp</strong></td>
                      <td>3,610m → 3,840m</td>
                      <td>6 km</td>
                      <td>4–5 hrs</td>
                      <td>Moorland</td>
                    </tr>
                    <tr>
                      <td>Day 4</td>
                      <td>Shira 2 → Lava Tower → <strong>Barranco Camp</strong></td>
                      <td>3,840m → 4,630m → 3,976m</td>
                      <td>10 km</td>
                      <td>6–8 hrs</td>
                      <td>Alpine Desert</td>
                    </tr>
                    <tr>
                      <td>Day 5</td>
                      <td>Barranco → <strong>Karanga Camp</strong></td>
                      <td>3,976m → 3,995m</td>
                      <td>5 km</td>
                      <td>4–5 hrs</td>
                      <td>Alpine Desert</td>
                    </tr>
                    <tr>
                      <td>Day 6</td>
                      <td>Karanga → <strong>Barafu Camp</strong></td>
                      <td>3,995m → 4,673m</td>
                      <td>4 km</td>
                      <td>4–5 hrs</td>
                      <td>Alpine Desert</td>
                    </tr>
                    <tr class="summit-row">
                      <td>Day 7</td>
                      <td>Barafu → <strong>Uhuru Peak</strong> → Mweka Camp</td>
                      <td>4,673m → 5,895m → 3,100m</td>
                      <td>17 km</td>
                      <td>12–16 hrs</td>
                      <td>Arctic / Descent</td>
                    </tr>
                    <tr>
                      <td>Day 8</td>
                      <td>Mweka Camp → <strong>Mweka Gate</strong></td>
                      <td>3,100m → 1,640m</td>
                      <td>10 km</td>
                      <td>3–4 hrs</td>
                      <td>Rainforest</td>
                    </tr>
                    <?php
                }
                ?>
              </tbody>
            </table>
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
                  Elevation Gain: <span><?php echo esc_html( $get_field('ryder_elev_gain', '4,449m') ); ?></span> &nbsp;|&nbsp; Total Distance: <span><?php echo esc_html( $get_field('ryder_distance', '66 km') ); ?></span>
                </div>
                <!-- BODY: MAP LEFT + ITINERARY RIGHT -->
                <div class="mw-body">
                  <div class="mw-left">
                    <!-- MAP -->
                    <div class="mw-mapcard">
                      <?php
                      // Fetch map stops from ACF
                      $map_stops = $get_field('ryder_map_stops', array());
                      $stops_json = '[]';
                      if ( !empty($map_stops) && is_array($map_stops) ) {
                          $formatted_stops = array();
                          foreach ( $map_stops as $index => $stop ) {
                              // We need coordinates. For now, we'll assign dummy coordinates based on index
                              // In a real scenario, you'd need a geocoding API or manual coordinate entry
                              $lat = -3.0670 + ($index * 0.005);
                              $lng = 37.0530 + ($index * 0.02);
                              
                              // If it's a known place, we could hardcode coordinates here
                              $name_lower = strtolower($stop['name']);
                              if (strpos($name_lower, 'lemosho') !== false) { $lat = -3.0670; $lng = 37.0530; }
                              elseif (strpos($name_lower, 'mti mkubwa') !== false) { $lat = -3.0450; $lng = 37.0850; }
                              elseif (strpos($name_lower, 'shira 1') !== false) { $lat = -3.0280; $lng = 37.1100; }
                              elseif (strpos($name_lower, 'shira 2') !== false) { $lat = -3.0100; $lng = 37.1350; }
                              elseif (strpos($name_lower, 'lava') !== false) { $lat = -3.0500; $lng = 37.2000; }
                              elseif (strpos($name_lower, 'barranco') !== false) { $lat = -3.0750; $lng = 37.2250; }
                              elseif (strpos($name_lower, 'karanga') !== false) { $lat = -3.0850; $lng = 37.2600; }
                              elseif (strpos($name_lower, 'barafu') !== false) { $lat = -3.0650; $lng = 37.2950; }
                              elseif (strpos($name_lower, 'uhuru') !== false || strpos($name_lower, 'summit') !== false) { $lat = -3.0759; $lng = 37.3537; }
                              elseif (strpos($name_lower, 'mweka camp') !== false) { $lat = -3.1050; $lng = 37.3200; }
                              elseif (strpos($name_lower, 'mweka gate') !== false) { $lat = -3.1450; $lng = 37.3100; }

                              $formatted_stops[] = array(
                                  'id' => 'stop_' . $index,
                                  'type' => $stop['type'],
                                  'day' => $stop['day'],
                                  'name' => $stop['name'],
                                  'elev' => $stop['elev'],
                                  'lat' => $lat,
                                  'lng' => $lng
                              );
                          }
                          $stops_json = json_encode($formatted_stops);
                      }
                      ?>
                      <div id="s-map" data-stops='<?php echo esc_attr($stops_json); ?>'></div>
                      <div class="mw-mf">
                        <span class="mw-mfl"><?php echo esc_html( $get_field('ryder_duration', '8-Day Route') ); ?></span>
                        <div style="display:flex;gap:7px;flex-wrap:wrap;">
                          <span class="mw-ftag">Most Scenic Route</span>
                          <span class="mw-ftag"><?php echo esc_html( $get_field('ryder_success_rate', '90%+ Success Rate') ); ?></span>
                        </div>
                      </div>
                    </div>
                    <!-- ELEVATION PROFILE -->
                    <div class="mw-elevation">
                      <div class="mw-elev-title"><?php echo esc_html( $get_field('ryder_duration', '8-Day Route') ); ?> — Elevation Profile</div>
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
                          
                          <?php
                          // Dynamic Elevation Profile Generation
                          $total_distance = (float) preg_replace('/[^0-9.]/', '', $get_field('ryder_distance', '66'));
                          if ($total_distance <= 0) $total_distance = 66;
                          
                          $max_elev = 6000;
                          $min_elev = 1500;
                          $elev_range = $max_elev - $min_elev;
                          
                          $svg_width = 960; // 980 - 20
                          $svg_height = 280; // 300 - 20
                          
                          $points = array();
                          $current_dist = 0;
                          
                          // We use the glance rows to build the profile
                          $glance_rows = $get_field('ryder_glance', array());
                          
                          if (!empty($glance_rows) && is_array($glance_rows)) {
                              // First point (start)
                              $first_elev_str = explode('→', $glance_rows[0]['elev'])[0];
                              $first_elev = (float) preg_replace('/[^0-9.]/', '', $first_elev_str);
                              
                              $x = 20;
                              $y = 300 - (($first_elev - $min_elev) / $elev_range) * $svg_height;
                              $points[] = array('x' => $x, 'y' => $y, 'elev' => $first_elev, 'dist' => 0, 'day' => 0, 'name' => 'START', 'zone' => 'Rainforest');
                              
                              foreach ($glance_rows as $index => $row) {
                                  $day_num = $index + 1;
                                  $dist_val = (float) preg_replace('/[^0-9.]/', '', $row['dist']);
                                  $current_dist += $dist_val;
                                  
                                  $elev_parts = explode('→', $row['elev']);
                                  $end_elev_str = end($elev_parts);
                                  $end_elev = (float) preg_replace('/[^0-9.]/', '', $end_elev_str);
                                  
                                  // If there's a middle elevation (like Lava Tower)
                                  if (count($elev_parts) > 2) {
                                      $mid_elev_str = $elev_parts[1];
                                      $mid_elev = (float) preg_replace('/[^0-9.]/', '', $mid_elev_str);
                                      
                                      $mid_x = 20 + (($current_dist - ($dist_val/2)) / $total_distance) * $svg_width;
                                      $mid_y = 300 - (($mid_elev - $min_elev) / $elev_range) * $svg_height;
                                      
                                      $points[] = array('x' => $mid_x, 'y' => $mid_y, 'elev' => $mid_elev, 'dist' => $current_dist - ($dist_val/2), 'day' => $day_num, 'name' => 'HIGH POINT', 'zone' => $row['zone'], 'is_mid' => true);
                                  }
                                  
                                  $x = 20 + ($current_dist / $total_distance) * $svg_width;
                                  $y = 300 - (($end_elev - $min_elev) / $elev_range) * $svg_height;
                                  
                                  $route_parts = explode('→', strip_tags($row['route']));
                                  $name = trim(end($route_parts));
                                  
                                  $is_summit = (stripos($row['route'], 'Uhuru') !== false || stripos($row['route'], 'Summit') !== false);
                                  
                                  $points[] = array('x' => $x, 'y' => $y, 'elev' => $end_elev, 'dist' => $current_dist, 'day' => $day_num, 'name' => strtoupper($name), 'zone' => $row['zone'], 'is_summit' => $is_summit);
                              }
                          } else {
                              // Fallback static points if no data
                              $points = [
                                  ['x'=>20, 'y'=>257, 'elev'=>2100, 'dist'=>0, 'day'=>0, 'name'=>'LEMOSHO', 'zone'=>'Rainforest'],
                                  ['x'=>107, 'y'=>209, 'elev'=>2895, 'dist'=>6, 'day'=>1, 'name'=>'MTI MKUBWA', 'zone'=>'Rainforest'],
                                  ['x'=>224, 'y'=>165, 'elev'=>3610, 'dist'=>14, 'day'=>2, 'name'=>'SHIRA 1', 'zone'=>'Moorland'],
                                  ['x'=>311, 'y'=>151, 'elev'=>3840, 'dist'=>20, 'day'=>3, 'name'=>'SHIRA 2', 'zone'=>'Moorland'],
                                  ['x'=>384, 'y'=>103, 'elev'=>4630, 'dist'=>25, 'day'=>4, 'name'=>'LAVA TOWER', 'zone'=>'Alpine', 'is_mid'=>true],
                                  ['x'=>456, 'y'=>143, 'elev'=>3976, 'dist'=>30, 'day'=>4, 'name'=>'BARRANCO', 'zone'=>'Alpine'],
                                  ['x'=>529, 'y'=>142, 'elev'=>3995, 'dist'=>35, 'day'=>5, 'name'=>'KARANGA', 'zone'=>'Alpine'],
                                  ['x'=>587, 'y'=>101, 'elev'=>4673, 'dist'=>39, 'day'=>6, 'name'=>'BARAFU', 'zone'=>'Alpine'],
                                  ['x'=>689, 'y'=>26, 'elev'=>5895, 'dist'=>46, 'day'=>7, 'name'=>'UHURU PEAK', 'zone'=>'Arctic', 'is_summit'=>true],
                                  ['x'=>835, 'y'=>197, 'elev'=>3100, 'dist'=>56, 'day'=>7, 'name'=>'MWEKA', 'zone'=>'Descent'],
                                  ['x'=>980, 'y'=>285, 'elev'=>1640, 'dist'=>66, 'day'=>8, 'name'=>'MWEKA GATE', 'zone'=>'Rainforest']
                              ];
                          }
                          
                          // Generate path string
                          $path_d = "M " . $points[0]['x'] . "," . $points[0]['y'];
                          for ($i = 1; $i < count($points); $i++) {
                              $path_d .= " L " . $points[$i]['x'] . "," . $points[$i]['y'];
                          }
                          
                          // Generate fill path
                          $fill_d = $path_d . " L " . end($points)['x'] . ",300 L 20,300 Z";
                          ?>
                          
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
                          
                          <!-- Main fill -->
                          <path d="<?php echo $fill_d; ?>" fill="#F7F1E3" opacity="0.55"/>
                          
                          <!-- Profile line -->
                          <path d="<?php echo $path_d; ?>" fill="none" stroke="#A07828" stroke-width="2.8" stroke-linejoin="round" stroke-linecap="round"/>
                          
                          <?php
                          // Draw points, labels, and day dividers
                          $prev_day = 0;
                          foreach ($points as $i => $p) {
                              // Day dividers and labels
                              if ($p['day'] > $prev_day && !isset($p['is_mid'])) {
                                  echo '<line x1="'.$p['x'].'" y1="300" x2="'.$p['x'].'" y2="20" stroke="#D4B96A" stroke-width="0.7" stroke-dasharray="3 6" opacity="0.45"/>';
                                  
                                  // X-axis ticks & labels
                                  echo '<line x1="'.$p['x'].'" y1="300" x2="'.$p['x'].'" y2="306" stroke="#D4B96A" stroke-width="1.2"/>';
                                  echo '<text x="'.$p['x'].'" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">'.$p['dist'].'</text>';
                                  
                                  $prev_day = $p['day'];
                              }
                              
                              if ($i === 0) {
                                  echo '<line x1="'.$p['x'].'" y1="300" x2="'.$p['x'].'" y2="306" stroke="#D4B96A" stroke-width="1.2"/>';
                                  echo '<text x="'.$p['x'].'" y="317" font-size="9.5" fill="#8A7250" text-anchor="middle" font-family="sans-serif">0</text>';
                              }
                              
                              // Markers
                              if (isset($p['is_summit']) && $p['is_summit']) {
                                  echo '<circle cx="'.$p['x'].'" cy="'.$p['y'].'" r="34" fill="url(#summitGlow2)"/>';
                                  echo '<circle cx="'.$p['x'].'" cy="'.$p['y'].'" r="8" fill="#B8860B" stroke="#FFD700" stroke-width="3"/>';
                                  echo '<text x="'.$p['x'].'" y="'.($p['y']+4).'" font-size="10" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="900">★</text>';
                                  echo '<rect x="'.($p['x']-38).'" y="'.($p['y']+9).'" width="76" height="15" fill="#B8860B" rx="3"/>';
                                  echo '<text x="'.$p['x'].'" y="'.($p['y']+20).'" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">'.$p['name'].'</text>';
                                  echo '<text x="'.$p['x'].'" y="'.($p['y']-5).'" font-size="10" fill="#B8860B" text-anchor="middle" font-family="sans-serif" font-weight="800">'.number_format($p['elev']).'m</text>';
                              } elseif (isset($p['is_mid']) && $p['is_mid']) {
                                  echo '<circle cx="'.$p['x'].'" cy="'.$p['y'].'" r="4.5" fill="#C49A3C" stroke="#fff" stroke-width="1.8"/>';
                                  echo '<text x="'.$p['x'].'" y="'.($p['y']+15).'" font-size="9" fill="#7A5C18" text-anchor="middle" font-family="sans-serif" font-weight="700" font-style="italic">'.number_format($p['elev']).'m</text>';
                              } else {
                                  $is_start_end = ($i === 0 || $i === count($points) - 1);
                                  $color = $is_start_end ? '#3D2E0A' : '#A07828';
                                  $r = $is_start_end ? 5.5 : 5;
                                  
                                  echo '<circle cx="'.$p['x'].'" cy="'.$p['y'].'" r="'.$r.'" fill="'.$color.'" stroke="#fff" stroke-width="2"/>';
                                  
                                  $rect_w = strlen($p['name']) * 6 + 10;
                                  $rect_x = $p['x'] - ($rect_w/2);
                                  $rect_y = $p['y'] + ($is_start_end && $i===0 ? 6 : ($is_start_end ? -17 : 9));
                                  $text_y = $rect_y + 11;
                                  $elev_y = $is_start_end && $i===0 ? $p['y'] - 5 : ($is_start_end ? $p['y'] + 17 : $p['y'] - 7);
                                  
                                  echo '<rect x="'.$rect_x.'" y="'.$rect_y.'" width="'.$rect_w.'" height="15" fill="'.$color.'" rx="3"/>';
                                  echo '<text x="'.$p['x'].'" y="'.$text_y.'" font-size="9" fill="#fff" text-anchor="middle" font-family="sans-serif" font-weight="700">'.$p['name'].'</text>';
                                  echo '<text x="'.$p['x'].'" y="'.$elev_y.'" font-size="9.5" fill="#3D2E0A" text-anchor="middle" font-family="sans-serif" font-weight="700">'.number_format($p['elev']).'m</text>';
                              }
                          }
                          ?>
                          
                          <text x="500" y="334" font-size="10" fill="#8A7250" text-anchor="middle" font-family="sans-serif" font-weight="600">Cumulative Distance (km) · Total Trek: <?php echo esc_html($total_distance); ?> km</text>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <!-- ITINERARY SIDEBAR -->
                  <div class="mw-itin">
                    <?php
                    $glance_rows = $get_field('ryder_glance', array());
                    if ( !empty($glance_rows) && is_array($glance_rows) ) {
                        foreach ( $glance_rows as $index => $row ) {
                            $day_num = $index + 1;
                            $is_summit = (stripos($row['route'], 'Uhuru') !== false || stripos($row['route'], 'Summit') !== false);
                            $class = 'mw-dc' . ($index === 0 ? ' on' : '') . ($is_summit ? ' summit-day' : '');
                            
                            // Extract parts from route (e.g. "Lemosho Gate → Mti Mkubwa")
                            $route_parts = explode('→', strip_tags($row['route']));
                            $title = trim($row['route']);
                            $lbl = "Day " . $day_num;
                            if ($is_summit) {
                                $lbl = "★ SUMMIT DAY";
                            } elseif (isset($row['title']) && !empty($row['title'])) {
                                $lbl = $row['title'];
                            }
                            
                            ?>
                            <div class="<?php echo esc_attr($class); ?>" data-day="<?php echo esc_attr($day_num); ?>" onclick="fd(<?php echo esc_attr($day_num); ?>)">
                              <div class="mw-db"><span>Day</span><strong><?php echo esc_html(preg_replace('/[^0-9]/', '', $row['day'])); ?></strong></div>
                              <p class="mw-dlbl"><?php echo esc_html($lbl); ?></p>
                              <div class="mw-dtitle"><?php echo wp_kses_post($title); ?></div>
                              <div class="mw-stats">
                                <div class="mw-stat"><strong>Elev:</strong> <?php echo esc_html($row['elev']); ?></div>
                                <div class="mw-stat"><strong>Dist:</strong> <?php echo esc_html($row['dist']); ?></div>
                                <div class="mw-stat"><strong>Time:</strong> <?php echo esc_html($row['time']); ?></div>
                                <div class="mw-stat"><strong>Zone:</strong> <?php echo esc_html($row['zone']); ?></div>
                              </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Fallback static HTML
                        ?>
                        <div class="mw-dc on" data-day="1" onclick="fd(1)">
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
                        <div class="mw-dc" data-day="2" onclick="fd(2)">
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
                        <div class="mw-dc" data-day="3" onclick="fd(3)">
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
                        <div class="mw-dc" data-day="4" onclick="fd(4)">
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
                        <div class="mw-dc" data-day="5" onclick="fd(5)">
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
                        <div class="mw-dc" data-day="6" onclick="fd(6)">
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
                        <div class="mw-dc summit-day" data-day="7" onclick="fd(7)">
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
                        <div class="mw-dc" data-day="8" onclick="fd(8)">
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
                        <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- DETAILED ITINERARY -->
        <section class="section section--alt" id="itinerary">
          <div class="container">
            <div class="sec-header">
              <span class="sec-header__eyebrow">Day-by-Day</span>
              <h2 class="sec-header__title">The Complete Route Experience</h2>
              <div class="divider"></div>
              <p class="sec-header__lead">Every camp, every habitat, every defining moment — described in full so you know exactly what to expect.</p>
            </div>

            <div class="itin-days" style="background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden;">
              <?php
              $days = $get_field('ryder_days', array());
              if ( !empty($days) && is_array($days) ) {
                  foreach ( $days as $day ) {
                      $is_summit = isset($day['is_summit']) && $day['is_summit'];
                      $day_class = $is_summit ? ' itin-day--summit' : '';
                      ?>
                      <div class="itin-day<?php echo $day_class; ?>">
                        <div class="itin-day__num">
                          <span class="itin-day__label">Day</span>
                          <span class="itin-day__n"><?php echo esc_html($day['day_num']); ?></span>
                        </div>
                        <div class="itin-day__content">
                          <div class="itin-day__eyebrow"><?php echo esc_html($day['eyebrow']); ?></div>
                          <h3 class="itin-day__title"><?php echo esc_html($day['title']); ?></h3>
                          
                          <?php if ( !empty($day['meta']) ) : ?>
                          <div class="itin-meta">
                            <?php
                            $meta_lines = explode("\n", str_replace("\r", "", $day['meta']));
                            foreach ( $meta_lines as $meta ) {
                                if ( trim($meta) ) {
                                    $meta_style = $is_summit ? ' style="background:#fff8e8;color:#7a4400;border-color:#D4B96A;"' : '';
                                    echo '<span class="itin-meta__item"' . $meta_style . '>' . esc_html(trim($meta)) . '</span>';
                                }
                            }
                            ?>
                          </div>
                          <?php endif; ?>

                          <div class="itin-day__body">
                            <?php echo wp_kses_post($day['body']); ?>
                          </div>

                          <?php if ( !empty($day['highlights']) ) : ?>
                          <div class="itin-highlights">
                            <?php
                            $hl_lines = explode("\n", str_replace("\r", "", $day['highlights']));
                            foreach ( $hl_lines as $hl ) {
                                if ( trim($hl) ) {
                                    echo '<span class="itin-hl">' . esc_html(trim($hl)) . '</span>';
                                }
                            }
                            ?>
                          </div>
                          <?php endif; ?>

                          <?php if ( !empty($day['accom']) ) : ?>
                          <div class="itin-day__accom"><strong>Camp/Accommodation:</strong> <?php echo esc_html($day['accom']); ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                      <?php
                  }
              } else {
                  echo '<p style="padding: 20px;">Itinerary details coming soon.</p>';
              }
              ?>
            </div>
          </div>
        </section>

        <!-- INCLUSIONS & EXCLUSIONS -->
        <section class="section" id="inclusions">
          <div class="container">
            <div class="sec-header">
              <span class="sec-header__eyebrow">What's Covered</span>
              <h2 class="sec-header__title">Inclusions &amp; Exclusions</h2>
              <div class="divider"></div>
            </div>
            <div class="inc-exc-grid">
              <div class="inc-exc-col">
                <h3 style="color:var(--green-inc);">✓ What's Included</h3>
                <ul class="inc-list">
                  <?php
                  $inclusions = $get_field('ryder_inclusions', '');
                  if ( $inclusions ) {
                      $inc_lines = explode("\n", str_replace("\r", "", $inclusions));
                      foreach ( $inc_lines as $line ) {
                          $line = trim($line);
                          if ( empty($line) ) continue;
                          if ( strpos($line, '##') === 0 ) {
                              echo '<li class="inc-cat" style="display:block;padding:12px 0 4px;">' . esc_html(trim(substr($line, 2))) . '</li>';
                          } else {
                              echo '<li><span class="inc-icon inc-icon--yes">✓</span>' . esc_html($line) . '</li>';
                          }
                      }
                  } else {
                      echo '<li><span class="inc-icon inc-icon--yes">✓</span>Professional Guides</li>';
                      echo '<li><span class="inc-icon inc-icon--yes">✓</span>Park Fees</li>';
                  }
                  ?>
                </ul>
              </div>
              <div class="inc-exc-col">
                <h3 style="color:var(--red-exc);">✗ Not Included</h3>
                <ul class="inc-list">
                  <?php
                  $exclusions = $get_field('ryder_exclusions', '');
                  if ( $exclusions ) {
                      $exc_lines = explode("\n", str_replace("\r", "", $exclusions));
                      foreach ( $exc_lines as $line ) {
                          $line = trim($line);
                          if ( empty($line) ) continue;
                          if ( strpos($line, '##') === 0 ) {
                              echo '<li class="inc-cat" style="display:block;padding:12px 0 4px;">' . esc_html(trim(substr($line, 2))) . '</li>';
                          } else {
                              echo '<li><span class="inc-icon inc-icon--no">✗</span>' . esc_html($line) . '</li>';
                          }
                      }
                  } else {
                      echo '<li><span class="inc-icon inc-icon--no">✗</span>International Flights</li>';
                      echo '<li><span class="inc-icon inc-icon--no">✗</span>Travel Insurance</li>';
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <!-- SUPPLEMENTS -->
        <section class="section section--alt" id="supplements">
          <div class="container">
            <div class="sec-header">
              <span class="sec-header__eyebrow">Add-Ons</span>
              <h2 class="sec-header__title">Supplements &amp; Optional Upgrades</h2>
              <div class="divider"></div>
              <p class="sec-header__lead">Enhance your expedition with additional services. All supplements can be arranged at booking.</p>
            </div>
            <div class="supps-grid">
              <?php
              $supplements = $get_field('ryder_supplements', array());
              if ( !empty($supplements) && is_array($supplements) ) {
                  foreach ( $supplements as $supp ) {
                      ?>
                      <div class="supp-card">
                        <div class="supp-card__title"><?php echo esc_html($supp['icon'] . ' ' . $supp['name']); ?></div>
                        <div class="supp-card__desc"><?php echo esc_html($supp['note']); ?></div>
                        <div class="supp-card__price"><?php echo esc_html($supp['price']); ?></div>
                      </div>
                      <?php
                  }
              } else {
                  echo '<p>No supplements listed.</p>';
              }
              ?>
            </div>
          </div>
        </section>

        <!-- FAQ -->
        <section class="section" id="faq">
          <div class="container">
            <div class="sec-header">
              <span class="sec-header__eyebrow">Common Questions</span>
              <h2 class="sec-header__title">Frequently Asked Questions</h2>
              <div class="divider"></div>
            </div>
            <div class="faq-list">
              <?php
              $faqs = $get_field('ryder_faqs', array());
              if ( !empty($faqs) && is_array($faqs) ) {
                  foreach ( $faqs as $faq ) {
                      ?>
                      <div class="faq-item">
                        <button class="faq-q"><?php echo esc_html($faq['question']); ?></button>
                        <div class="faq-a"><?php echo wp_kses_post($faq['answer']); ?></div>
                      </div>
                      <?php
                  }
              }
              ?>
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
