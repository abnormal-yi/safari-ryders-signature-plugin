<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode( 'ryder_itinerary', 'ryder_itinerary_shortcode' );

function ryder_itinerary_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id' => get_the_ID(),
    ), $atts, 'ryder_itinerary' );

    $post_id = $atts['id'];

    // Enqueue assets specifically when shortcode is used
    wp_enqueue_style( 'google-fonts-cormorant', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Jost:wght@300;400;500;600;700&display=swap', array(), null );
    wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
    wp_enqueue_style( 'ryder-itinerary-style', RYDER_ITINERARY_PLUGIN_URL . 'assets/css/itinerary.css', array(), '1.0.0' );
    
    wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
    wp_enqueue_script( 'ryder-itinerary-script', RYDER_ITINERARY_PLUGIN_URL . 'assets/js/itinerary.js', array('leaflet-js'), '1.0.0', true );

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

    // Auto-Coordinates Resolver Function
    $resolve_coords = function($place_name) {
        $name = strtolower(trim($place_name));
        $dict = array(
            'arusha' => array('lat' => -3.3869, 'lng' => 36.6830),
            'tarangire' => array('lat' => -4.1629, 'lng' => 36.0899),
            'ngorongoro' => array('lat' => -3.1618, 'lng' => 35.5877),
            'serengeti' => array('lat' => -2.3333, 'lng' => 34.8333),
            'manyara' => array('lat' => -3.5053, 'lng' => 35.8280),
            'kilimanjaro' => array('lat' => -3.0674, 'lng' => 37.3556),
            'karatu' => array('lat' => -3.3387, 'lng' => 35.6741),
            'ndutu' => array('lat' => -3.0200, 'lng' => 34.9960),
            'zanzibar' => array('lat' => -6.1659, 'lng' => 39.2026),
            'dar es salaam' => array('lat' => -6.7924, 'lng' => 39.2083),
            'ruaha' => array('lat' => -7.6366, 'lng' => 34.8888),
            'selous' => array('lat' => -9.0000, 'lng' => 37.4000),
            'mikumi' => array('lat' => -7.2340, 'lng' => 37.1381),
            'nairobi' => array('lat' => -1.2921, 'lng' => 36.8219),
            'masai mara' => array('lat' => -1.4900, 'lng' => 35.1439),
            'amboseli' => array('lat' => -2.6527, 'lng' => 37.2606),
        );
        foreach($dict as $key => $coords) {
            if (strpos($name, $key) !== false) {
                return $coords;
            }
        }
        // Fallback to center of Tanzania if not found
        return array('lat' => -6.3690, 'lng' => 34.8888);
    };

    // Fetch fields
    $hero_badge = $get_field('ryder_hero_badge', 'NT-C1 · Flagship Program');
    $hero_title = $get_field('ryder_hero_title', '5-Day Tanzania Northern Circuit Safari:');
    $hero_title_em = $get_field('ryder_hero_title_em', 'Where the Wild Heart of Africa Beats');
    $hero_subtitle = $get_field('ryder_hero_subtitle', "Tarangire's elephant herds. Ngorongoro's ancient crater floor. The endless Serengeti horizon. Three legendary destinations. One unforgettable journey.");
    $duration = $get_field('ryder_duration', '6 Days / 5 Nights');
    $parks_visited = $get_field('ryder_parks_visited', '3 Destinations');
    $starting_price = $get_field('ryder_starting_price', '$3,200 / person');
    $best_for = $get_field('ryder_best_for', 'First-Time Visitors');
    
    $rating_score = $get_field('ryder_rating_score', '4.9');
    $rating_reviews = $get_field('ryder_rating_reviews', '187 verified reviews');
    $rating_award = $get_field('ryder_rating_award', '🏆 <strong style="color:var(--dark-mid)">Flagship Program</strong> &nbsp;·&nbsp; Most Booked Itinerary');
    $rating_departure = $get_field('ryder_rating_departure', '📍 Departs from <strong style="color:var(--dark-mid)">Kilimanjaro International Airport</strong>');

    $overview_label = $get_field('ryder_overview_label', 'Overview');
    $overview_title = $get_field('ryder_overview_title', 'Tanzania\'s <em>Iconic Three</em> — In One Classic Safari');
    $overview_lead = $get_field('ryder_overview_lead', 'The 5-day Tanzania northern circuit safari is the essential introduction to East Africa\'s greatest wildlife stage. Moreover, it is RYDER Signature\'s most-loved flagship itinerary — refined across hundreds of departures to balance pacing, depth, and pure wildlife impact.');
    $overview_image = $get_field('ryder_overview_image', ''); // New Image Field
    $overview_content = $get_field('ryder_overview_content', '
        <p style="font-size:14.5px;color:var(--text-body);line-height:1.78;max-width:860px;margin-bottom:16px;">
          You arrive at Kilimanjaro International Airport, where your dedicated RYDER Signature guide meets you at arrivals. From that moment forward, Tanzania reveals itself at exactly the right pace. First, the baobab forests of Tarangire National Park introduce you to elephant herds that number in the hundreds. Subsequently, the Ngorongoro Conservation Area draws you toward its famous crater — a collapsed volcano that shelters one of Africa\'s densest concentrations of wildlife within a single bowl of land. Finally, the Serengeti opens before you: two million acres of golden grassland, acacia shade, and predators that move through it all with breathtaking ease.
        </p>
        <p style="font-size:14.5px;color:var(--text-body);line-height:1.78;max-width:860px;margin-bottom:16px;">
          This itinerary is designed for first-time safari visitors who want to experience the full Northern Circuit without rushing. However, it equally rewards returning travellers who appreciate a well-paced, unhurried journey. All three parks are UNESCO-recognised ecosystems. Each offers a distinctly different landscape, different wildlife behaviour, and a different emotional register. Furthermore, RYDER Signature ensures you spend meaningful time in each location — not just a night and a drive-through.
        </p>
        <p style="font-size:14.5px;color:var(--text-body);line-height:1.78;max-width:860px;">
          Your private 4x4 Land Cruiser provides guaranteed window seats and a pop-up roof hatch for 360-degree game viewing. Your professional English-speaking guide brings deep knowledge of Tanzania\'s ecosystems — knowing where the lions rested at dawn, where the leopard was spotted last week, and when to slow down and simply listen. Therefore, every game drive delivers moments that no wildlife documentary can fully replicate.
        </p>
    ');

    $highlights = $get_field('ryder_highlights', array(
        array('icon'=>'🐘', 'title'=>'Tarangire Elephant Herds', 'description'=>'Witness Africa\'s largest elephant concentrations among ancient baobab trees in a park that many consider Tanzania\'s best-kept secret.'),
        array('icon'=>'🦁', 'title'=>'Ngorongoro Crater Floor', 'description'=>'Descend into the world\'s largest intact volcanic caldera — home to all five Big Five species in a single, extraordinary wildlife arena.'),
        array('icon'=>'🌅', 'title'=>'Serengeti Sunrise Drives', 'description'=>'Experience two full game drives across the Serengeti\'s Central plains — the iconic stage for predator-prey encounters that define East Africa.'),
        array('icon'=>'🚗', 'title'=>'Private Land Cruiser', 'description'=>'Travel in your own 4x4 safari vehicle with a pop-up roof hatch, guaranteed window seats, and a dedicated expert guide throughout.'),
        array('icon'=>'🏨', 'title'=>'Three Tiers Available', 'description'=>'Choose from mid-range comfort, luxury tented camps, or high-end exclusive lodges — all carefully curated to match the safari experience.'),
        array('icon'=>'📋', 'title'=>'Fully Inclusive Program', 'description'=>'Park fees, meals, transfers, and Flying Doctors emergency coverage — all included. No hidden costs. No logistics to manage.')
    ));

    $glance = $get_field('ryder_glance', array(
        array('day'=>'1', 'route'=>'Arrive Kilimanjaro → Arusha', 'overnight'=>'Arusha', 'meals'=>array('d'), 'highlights'=>'Airport meet & greet, transfer, safari briefing'),
        array('day'=>'2', 'route'=>'Arusha → Tarangire National Park', 'overnight'=>'Tarangire Area', 'meals'=>array('b','l','d'), 'highlights'=>'Elephant herds, baobab forests, afternoon game drive'),
        array('day'=>'3', 'route'=>'Tarangire → Ngorongoro Conservation Area', 'overnight'=>'Crater Rim', 'meals'=>array('b','l','d'), 'highlights'=>'Scenic Rift Valley drive, crater rim arrival, sundowner'),
        array('day'=>'4', 'route'=>'Ngorongoro Crater → Central Serengeti', 'overnight'=>'Central Serengeti', 'meals'=>array('b','l','d'), 'highlights'=>'Full crater descent, Big Five, transfer to Serengeti'),
        array('day'=>'5', 'route'=>'Full Day — Central Serengeti', 'overnight'=>'Central Serengeti', 'meals'=>array('b','l','d'), 'highlights'=>'Full-day game drives, predator activity, sundowner on the plains'),
        array('day'=>'6', 'route'=>'Serengeti → Kilimanjaro Airport', 'overnight'=>'—', 'meals'=>array('b'), 'highlights'=>'Morning game drive, scenic return, departure')
    ));

    $pricing = $get_field('ryder_pricing', array(
        array('tier'=>'Mid-Range · MID', 'name'=>'Explorer', 'price'=>'$3,200', 'features'=>"Arusha Planet Lodge (arrival night)\nLake Burunge Tented Camp, Tarangire\nNgorongoro Serena Safari Lodge\nTamu Tamu, Central Serengeti\nAll park fees, meals & transfers", 'sample'=>'Well-managed tented camps and comfortable lodges in excellent park-adjacent locations.', 'is_featured'=>false),
        array('tier'=>'Luxury · LUX', 'name'=>'Signature', 'price'=>'$5,500', 'features'=>"Gran Meliá Arusha (arrival night)\nElephant Spring Lodge, Tarangire\nNgorongoro Lodge by Meliá\nSalinero Serengeti\nAll park fees, meals & transfers\nPremium service & intimate settings", 'sample'=>'Award-winning lodges with exceptional service and locations that place you deep in the wildlife areas.', 'is_featured'=>true),
        array('tier'=>'High-End Luxury · HEL', 'name'=>'Pinnacle', 'price'=>'$9,800', 'features'=>"Legendary Lodge, Arusha (arrival night)\nLemala Mpingo Ridge, Tarangire\nCrater's Edge, Ngorongoro\nFour Seasons Safari Lodge, Serengeti\nAll park fees, meals & transfers\nExclusive concession access\nPersonalised butler & VIP arrangements", 'sample'=>'The finest addresses in each park — ultra-exclusive, architecturally stunning, and impeccably staffed.', 'is_featured'=>false)
    ));

    $stops = $get_field('ryder_map_stops', array(
        array('id'=>'arusha', 'type'=>'city', 'day'=>'', 'name'=>'Arusha', 'lat'=>-3.3869, 'lng'=>36.6830, 'r'=>0),
        array('id'=>'tarangire', 'type'=>'park', 'day'=>'Day 2', 'name'=>'Tarangire N.P.', 'lat'=>-4.1629, 'lng'=>36.0899, 'r'=>50000),
        array('id'=>'ngorongoro', 'type'=>'park', 'day'=>'Days 3–4', 'name'=>'Ngorongoro Conservation', 'lat'=>-3.1618, 'lng'=>35.5877, 'r'=>27000),
        array('id'=>'serengeti', 'type'=>'park', 'day'=>'Days 4–5', 'name'=>'Serengeti N.P.', 'lat'=>-2.3333, 'lng'=>34.8333, 'r'=>92000)
    ));

    $days = $get_field('ryder_days', array(
        array('day_num'=>'1', 'day_type'=>'Day 1 — Arrival', 'title'=>'Arrive Kilimanjaro → Welcome to Arusha', 'body'=>'<p>Your 5-day Tanzania northern circuit safari begins the moment your flight touches down at Kilimanjaro International Airport (JRO). Your dedicated RYDER Signature guide meets you at arrivals with a personalised welcome sign, then transfers you directly to your hotel in Arusha — typically a 60-minute journey through the foothills of Mount Meru.</p><p>Today is intentionally light. After a long international flight, rest is your most important activity. Settle into your accommodation, refresh, and enjoy your first East African dinner. In the evening, your guide conducts a detailed safari briefing, covering the route ahead, wildlife expectations, and what to pack in your daypack for tomorrow\'s game drive.</p><p>No game drives are scheduled on arrival day. This policy reflects RYDER Signature\'s commitment to guest wellbeing — tired travellers miss the details that make a game drive extraordinary. Furthermore, starting rested sets the tone for an alert, immersive experience throughout the safari.</p>', 'tags'=>"Arusha\nArrival Day\nSafari Briefing", 'map_lat'=>-3.3869, 'map_lng'=>36.6830, 'map_zoom'=>8, 'map_stop_id'=>'arusha'),
        array('day_num'=>'2', 'day_type'=>'Day 2 — First Game Drive', 'title'=>'Arusha → Tarangire National Park', 'body'=>'<p>After breakfast, your Land Cruiser heads south-west from Arusha on a 2.5-hour drive to Tarangire National Park. As you descend from the highlands onto the Masai Steppe, the landscape shifts dramatically — acacia scrub gives way to ancient baobab trees that seem to erupt from the dry earth like sculptures carved by wind and time.</p><p>Tarangire is one of Tanzania\'s most underrated parks and a personal favourite of many experienced guides. During the dry season, the Tarangire River acts as a magnet for extraordinary wildlife concentrations. Elephant herds arrive in the hundreds — sometimes thousands — to drink and graze along the riverbanks. Additionally, the park holds large populations of buffalo, zebra, wildebeest, and a remarkable diversity of birds exceeding 550 recorded species.</p><p>Your afternoon game drive explores the riverine forest and open floodplains. Lions rest under shade in the afternoon heat, while hippos wallow in the remaining pools. At sunset, your guide selects a quiet viewpoint to pause, absorb the landscape, and pour sundowners before the short drive to your lodge.</p>', 'tags'=>"Tarangire N.P.\nElephant Herds\nBaobab Forest\nAfternoon Drive", 'map_lat'=>-4.1629, 'map_lng'=>36.0899, 'map_zoom'=>9, 'map_stop_id'=>'tarangire'),
        array('day_num'=>'3', 'day_type'=>'Day 3 — Transfer Day', 'title'=>'Tarangire → Ngorongoro Conservation Area', 'body'=>'<p>You depart Tarangire after an early morning game drive that frequently yields encounters the midday heat would otherwise deny you — lion cubs playing near a kill, leopards descending from fever trees, and the eerie beauty of a jackal hunting alone across the floodplain.</p><p>The drive north-east to the Ngorongoro Conservation Area takes approximately 1.5 hours, passing through the Karatu highlands and the lush coffee and banana farms that drape the slopes beneath the crater rim. As you climb above 2,300 metres, the air cools and the dense montane forest closes in around the road. This transition from Tarangire\'s drylands to Ngorongoro\'s cool altitude represents one of the most dramatic landscape shifts in all of East Africa.</p><p>You arrive at the crater rim in the late afternoon. The view into the caldera — a 600-metre drop to a 260-square-kilometre floor — is staggering on first sight and does not diminish with familiarity. Consequently, most guests simply stand at the viewpoint in silence. Dinner at your rim lodge comes with the kind of stillness that only high-altitude bush can provide.</p>', 'tags'=>"Ngorongoro\nCrater Rim\nMorning Drive\nScenic Transfer", 'map_lat'=>-3.1618, 'map_lng'=>35.5877, 'map_zoom'=>9, 'map_stop_id'=>'ngorongoro'),
        array('day_num'=>'4', 'day_type'=>'Day 4 — Grand Descent', 'title'=>'Ngorongoro Crater Descent → Central Serengeti', 'body'=>'<p>Today ranks among the most extraordinary days in East African safari travel. You descend into the Ngorongoro Crater at dawn, winding down the steep switchback road as mist cloaks the rim above and the crater floor emerges below. Inside, the world is condensed: predators, prey, and scavengers all compete for territory within this natural amphitheatre, and the density of wildlife per square kilometre is arguably unmatched anywhere on the continent.</p><p>The crater holds all five Big Five species. Black rhino move through the grasslands in the early hours. Lions — prides of up to 30 animals — are resident year-round. Additionally, enormous elephant bulls visit from the slopes, and cheetah have been sighted crossing the open floor in breathtaking long-stride pursuits. You spend the full morning exploring different zones before ascending via the exit road.</p><p>Following a picnic lunch on the crater rim, you continue west on the three-hour drive to the Central Serengeti — arriving in time for an afternoon game drive that introduces you to the endless plains. Even that first glimpse of the Serengeti, before you have had time to settle or strategise, tends to produce sightings that guests remember for decades.</p>', 'tags'=>"Ngorongoro Crater\nSerengeti N.P.\nBig Five\nFull Crater Day", 'map_lat'=>-3.0, 'map_lng'=>35.2, 'map_zoom'=>7, 'map_stop_id'=>'ngorongoro'),
        array('day_num'=>'5', 'day_type'=>'Day 5 — Full Serengeti Day', 'title'=>'Full Day in the Heart of the Serengeti', 'body'=>'<p>Your full day in the Central Serengeti is the emotional centrepiece of this safari. The wake-up call comes before dawn. You depart into the cool, blue-dark morning as the first light begins to separate the horizon from the sky. This window — roughly 20 minutes of transition from night to day — is when the Serengeti makes its most dramatic moves.</p><p>The Central Serengeti, or Seronera zone, holds the highest year-round concentration of predators in the ecosystem. Resident lion prides dominate drainage lines and granite kopje outcrops. Cheetah mothers teach cubs to hunt on the open plains. Leopards rest with kills wedged into the fork of sausage trees along the Seronera River. Moreover, the resident wildebeest and zebra population ensures that predator activity remains high regardless of the Great Migration\'s seasonal position.</p><p>The afternoon drive takes a different route, perhaps further west towards the plains or north to explore the rolling hills above Seronera. After sunset returns you to camp, dinner under a sky dense with stars provides a natural conclusion to what is, for most guests, the most vivid wildlife day of their lives. Your guide briefs you on tomorrow\'s departure logistics.</p>', 'tags'=>"Serengeti N.P.\nPredators\nDawn Drive\nFull Day", 'map_lat'=>-2.3333, 'map_lng'=>34.8333, 'map_zoom'=>8, 'map_stop_id'=>'serengeti'),
        array('day_num'=>'6', 'day_type'=>'Day 6 — Departure', 'title'=>'Serengeti → Kilimanjaro — Farewell to the Wild', 'body'=>'<p>Departures from the Serengeti are bittersweet. Nevertheless, a final morning game drive ensures the safari ends on an active note — not simply a drive to an airstrip. Depending on your flight timing, your guide plans a route back toward Ngorongoro and Arusha that incorporates one more game drive corridor before transitioning to tarmac.</p><p>For guests with late evening international flights departing after 18:00, a direct transfer to Kilimanjaro International Airport is perfectly feasible. For earlier flights, RYDER Signature recommends an overnight stay near the airport in Arusha, eliminating the stress of a rushed final transfer. Either way, your guide remains with you until the airport drop-off is complete.</p><p>As you board your flight home, Tanzania recedes below — the Rift Valley, the crater, the Serengeti horizon — and the photographs, the silence, the exact weight of a lion\'s gaze across a distance of ten metres, travel with you. Therefore, many guests find themselves planning their return before they have even landed.</p>', 'tags'=>"Departure Day\nMorning Drive\nAirport Transfer", 'map_lat'=>-3.1, 'map_lng'=>35.5, 'map_zoom'=>7, 'map_stop_id'=>'arusha'),
    ));

    $inclusions = $get_field('ryder_inclusions', "Airport meet and greet upon arrival at Kilimanjaro International Airport\nAll airport transfers as per itinerary (one pick-up, one drop-off)\nProfessional English-speaking safari guide and driver throughout\nPrivate 4x4 Toyota Land Cruiser with pop-up roof hatch and guaranteed window seats\nAll national park entry fees and Ngorongoro Conservation Area fees\nGame drives as specified in the itinerary (morning and afternoon)\nAccommodation as specified per tier (or equivalent standard if unavailable)\nAll meals as indicated — Breakfast, Lunch, and Dinner throughout\nBottled mineral water during all game drives\nFlying Doctors emergency evacuation coverage for the duration of the safari\n24/7 RYDER Signature safari support hotline access");
    
    $exclusions = $get_field('ryder_exclusions', "International flights to and from East Africa\nTanzania visa fees (USD 50 per person — obtainable online or on arrival)\nComprehensive travel insurance — mandatory and must cover medical evacuation\nTips and gratuities — recommended USD 30–50 per day per vehicle\nPersonal items: laundry, phone calls, souvenirs, and snacks\nPremium and imported alcoholic beverages\nOptional activities not specified in the itinerary\nHot air balloon safari (available as an optional supplement)\nAny costs arising from deviation from the confirmed itinerary\nAny items of a personal nature not listed under inclusions");

    $supplements = $get_field('ryder_supplements', array(
        array('icon'=>'🎈', 'name'=>'Hot Air Balloon Safari', 'price'=>'$550 per person', 'note'=>'Dawn balloon flight over the Serengeti with champagne bush breakfast. Unforgettable perspective on the plains.'),
        array('icon'=>'🌟', 'name'=>'Room / Tent Upgrade', 'price'=>'Price on request', 'note'=>'Upgrade to superior category rooms or premium suites at any property along the route.')
    ));

    $faqs = $get_field('ryder_faqs', array(
        array('question'=>'What is included in the 5-day Tanzania northern circuit safari?', 'answer'=>'The safari includes airport transfers, five nights of accommodation, all meals as indicated, game drives with a professional guide, national park and conservation fees, bottled water on game drives, and Flying Doctors emergency evacuation coverage. Essentially, all logistics are handled — you simply arrive and experience.'),
        array('question'=>'When is the best time to do the northern circuit safari in Tanzania?', 'answer'=>'The northern circuit is genuinely rewarding year-round. However, the dry season from June to October offers the best game viewing — animals concentrate around water sources and vegetation thins for clearer sightlines. January to March is superb for calving season near Ndutu, with dense predator activity. Moreover, the green season from November to May delivers lush landscapes, excellent bird life, and significantly fewer visitors at parks and lodges.'),
        array('question'=>'Is the 5-day northern circuit safari suitable for first-time visitors?', 'answer'=>'Absolutely. This itinerary is RYDER Signature\'s flagship classic program, designed specifically for first-time safari visitors who want to experience Tanzania\'s three most iconic destinations in a well-paced journey. The driving distances are manageable, the wildlife is abundant, and the variety — from Tarangire\'s elephants to the Serengeti\'s predators — ensures there is something profound at every stage.')
    ));

    // Format Map Data
    $formatted_stops = array();
    if (is_array($stops)) {
        foreach($stops as $stop) {
            if (empty($stop['name'])) continue; // Skip empty rows
            
            $coords = $resolve_coords($stop['name']);
            
            // Foolproof check: if they typed a park name but selected City, fix it automatically
            $name_lower = strtolower($stop['name']);
            $is_known_park = false;
            $known_parks = array('serengeti', 'tarangire', 'ngorongoro', 'manyara', 'ruaha', 'selous', 'mikumi', 'amboseli', 'masai mara', 'kilimanjaro');
            foreach($known_parks as $kp) {
                if (strpos($name_lower, $kp) !== false) {
                    $is_known_park = true; break;
                }
            }
            $actual_type = ($stop['type'] === 'park' || $is_known_park) ? 'park' : 'city';
            $radius = ($actual_type === 'park') ? 40000 : 0;
            
            $formatted_stops[] = array(
                'id' => sanitize_title($stop['name']),
                'type' => $actual_type,
                'day' => $stop['day'],
                'name' => $stop['name'],
                'lat' => (float)$coords['lat'],
                'lng' => (float)$coords['lng'],
                'r' => (int)$radius
            );
        }
    }
    
    $route = array();
    foreach($formatted_stops as $stop) {
        $route[] = array($stop['lat'], $stop['lng']);
    }
    if(count($route) > 1) {
        $route[] = $route[0]; // Return to start only if there's more than 1 point
    }

    $day_views = array();
    foreach($days as $d) {
        $stop_id = sanitize_title($d['map_stop_id']);
        $focus_lat = -3.1;
        $focus_lng = 35.4;
        
        // Find coordinates from formatted stops
        foreach($formatted_stops as $fs) {
            if ($fs['id'] === $stop_id) {
                $focus_lat = $fs['lat'];
                $focus_lng = $fs['lng'];
                break;
            }
        }

        $day_views[$d['day_num']] = array(
            'c' => array((float)$focus_lat, (float)$focus_lng),
            'z' => (int)($d['map_zoom'] ? $d['map_zoom'] : 8),
            'id' => $stop_id
        );
    }

    ob_start();
    ?>
    <div class="ryder-itinerary-wrapper" id="ryder-itinerary-<?php echo esc_attr($post_id); ?>"
         data-stops="<?php echo htmlspecialchars(json_encode($formatted_stops), ENT_QUOTES, 'UTF-8'); ?>"
         data-route="<?php echo htmlspecialchars(json_encode($route), ENT_QUOTES, 'UTF-8'); ?>"
         data-dayviews="<?php echo htmlspecialchars(json_encode($day_views), ENT_QUOTES, 'UTF-8'); ?>">
        <!-- HERO -->
        <header class="hero" role="banner">
          <div class="hero-badge"><?php echo esc_html($hero_badge); ?></div>
          <h1><?php echo wp_kses_post($hero_title); ?><br><em><?php echo esc_html($hero_title_em); ?></em></h1>
          <p class="hero-sub"><?php echo esc_html($hero_subtitle); ?></p>
          <div class="hero-meta">
            <div class="hero-meta-item">
              <span class="label">Duration</span>
              <span class="value"><?php echo esc_html($duration); ?></span>
            </div>
            <div class="hero-divider"></div>
            <div class="hero-meta-item">
              <span class="label">Parks Visited</span>
              <span class="value"><?php echo esc_html($parks_visited); ?></span>
            </div>
            <div class="hero-divider"></div>
            <div class="hero-meta-item">
              <span class="label">Starting From</span>
              <span class="value gold"><?php echo esc_html($starting_price); ?></span>
            </div>
            <div class="hero-divider"></div>
            <div class="hero-meta-item">
              <span class="label">Best For</span>
              <span class="value"><?php echo esc_html($best_for); ?></span>
            </div>
          </div>
          <div class="hero-cta-row">
            <a href="#" class="btn-primary ryder-trigger-popup">Design Your Journey ›</a>
            <a href="#itinerary" class="btn-ghost">Explore the Route</a>
          </div>
        </header>

        <!-- RATING STRIP -->
        <div class="rating-strip" aria-label="Guest ratings">
          <div class="rating-item">
            <span class="stars">★★★★★</span>
            <span class="rating-val"><?php echo esc_html($rating_score); ?></span>
            <span style="font-size:12px;color:var(--muted);">/ 5.0 &nbsp;·&nbsp; <?php echo esc_html($rating_reviews); ?></span>
          </div>
          <div class="rating-sep"></div>
          <div class="rating-item"><?php echo wp_kses_post($rating_award); ?></div>
          <div class="rating-sep"></div>
          <div class="rating-item"><?php echo wp_kses_post($rating_departure); ?></div>
        </div>

        <main>
        <!-- OVERVIEW -->
        <section class="section" aria-labelledby="overview-heading">
          <div class="page-wrap">
            <p class="section-label"><?php echo esc_html($overview_label); ?></p>
            <h2 id="overview-heading" class="section-title"><?php echo wp_kses_post($overview_title); ?></h2>
            <p class="section-lead"><?php echo esc_html($overview_lead); ?></p>

            <?php if ($overview_image): ?>
            <img src="<?php echo esc_url($overview_image); ?>" alt="<?php echo esc_attr(strip_tags($overview_title)); ?>" style="width:100%; height:auto; border-radius:12px; margin-bottom:32px; box-shadow:0 8px 30px rgba(0,0,0,0.1);">
            <?php endif; ?>

            <?php echo wp_kses_post($overview_content); ?>

            <div class="highlights-grid" style="margin-top:40px;">
              <?php foreach($highlights as $hl): ?>
              <div class="highlight-card">
                <div class="highlight-icon"><?php echo esc_html($hl['icon']); ?></div>
                <div class="highlight-text">
                  <strong><?php echo esc_html($hl['title']); ?></strong>
                  <p><?php echo esc_html($hl['description']); ?></p>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <a href="#" class="btn-primary ryder-trigger-popup" style="display:inline-flex;margin-top:8px;">Get a Custom Quote ›</a>
          </div>
        </section>

        <!-- ITINERARY AT A GLANCE -->
        <section class="section" aria-labelledby="glance-heading">
          <div class="page-wrap">
            <p class="section-label">Itinerary at a Glance</p>
            <h2 id="glance-heading" class="section-title"><em>Six Days</em>, Three Parks, One Lifetime Memory</h2>
            <p class="section-lead">The table below outlines the daily progression of your safari, including overnight locations and meal arrangements.</p>

            <div class="glance-table-wrap">
              <table class="glance-table" role="grid" aria-label="Itinerary at a glance">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Route</th>
                    <th>Overnight</th>
                    <th>Meal Plan</th>
                    <th>Highlights</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($glance as $g): 
                    $meals = is_array($g['meals']) ? $g['meals'] : array();
                  ?>
                  <tr>
                    <td><span class="day-badge"><?php echo esc_html($g['day']); ?></span></td>
                    <td class="dest-name"><?php echo esc_html($g['route']); ?></td>
                    <td><?php echo esc_html($g['overnight']); ?></td>
                    <td>
                        <?php if(in_array('b', $meals) || in_array('B', $meals)) echo '<span class="meal-tag b">B</span>'; ?>
                        <?php if(in_array('l', $meals) || in_array('L', $meals)) echo '<span class="meal-tag l">L</span>'; ?>
                        <?php if(in_array('d', $meals) || in_array('D', $meals)) echo '<span class="meal-tag d">D</span>'; ?>
                        <?php if(empty($meals)) echo '<span class="meal-tag na">L/D own</span>'; ?>
                    </td>
                    <td><?php echo esc_html($g['highlights']); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <p style="font-size:12px;color:var(--muted);margin-top:10px;">B = Breakfast &nbsp;·&nbsp; L = Lunch &nbsp;·&nbsp; D = Dinner</p>
          </div>
        </section>

        <!-- INTERACTIVE MAP -->
        <section class="map-section" aria-labelledby="map-heading">
          <div class="map-section-inner">
            <div class="map-header">
              <p class="section-label">Explore the Route</p>
              <h2 id="map-heading" class="section-title" style="margin-bottom:6px;">Your Safari <em>Route, Mapped</em></h2>
              <p style="color:rgba(255,255,255,.55);font-size:14px;margin-bottom:22px;">Follow the animated route from Arusha through the parks.</p>
            </div>

            <div class="map-legend">
              <div class="legend-item"><span class="l-dot park"></span>National Park / Conservation Area</div>
              <div class="legend-item"><span class="l-dot city"></span>Gateway City</div>
              <div class="legend-item"><span class="l-dash"></span>Safari Route</div>
            </div>

            <div class="map-card" style="margin-top:20px;">
              <div id="s-map" class="ryder-map-container"></div>
              <div class="map-footer">
                <span class="map-footer-label">Parks Visited</span>
                <div class="park-tags">
                  <?php 
                  $park_names = array();
                  foreach($formatted_stops as $fs) {
                      if($fs['type'] === 'park' && !in_array($fs['name'], $park_names)) {
                          $park_names[] = $fs['name'];
                          echo '<span class="park-tag">' . esc_html($fs['name']) . '</span>';
                      }
                  }
                  if(empty($park_names)) {
                      echo '<span class="park-tag" style="background:transparent;border:none;color:var(--muted);">No parks selected yet</span>';
                  }
                  ?>
                </div>
                <button class="btn-replay">&#9654; Replay Route</button>
              </div>
            </div>
          </div>
        </section>

        <!-- PRICE SLABS -->
        <section class="section" aria-labelledby="pricing-heading">
          <div class="page-wrap">
            <p class="section-label">Investment</p>
            <h2 id="pricing-heading" class="section-title">Choose Your <em>Safari Style</em></h2>
            <p class="section-lead">Every tier delivers the same exceptional guiding, the same game drives, and the same parks. The difference lies in where you sleep.</p>

            <div class="notice-box">
              All listed accommodations are subject to availability. Should a property be unavailable, RYDER Signature will substitute an equally-tiered alternative.
            </div>

            <div class="price-grid">
              <?php foreach($pricing as $p): 
                $feat_class = $p['is_featured'] ? 'featured' : '';
                $features_arr = explode("\n", $p['features']);
              ?>
              <div class="price-card <?php echo $feat_class; ?>">
                <p class="price-tier"><?php echo esc_html($p['tier']); ?></p>
                <h3 class="price-name"><?php echo esc_html($p['name']); ?></h3>
                <p class="price-from"><span class="currency">from </span><strong><?php echo esc_html($p['price']); ?></strong> <span class="currency">per person</span></p>
                <ul class="price-features">
                  <?php foreach($features_arr as $f): if(trim($f)): ?>
                  <li><?php echo esc_html(trim($f)); ?></li>
                  <?php endif; endforeach; ?>
                </ul>
                <p class="price-sample"><?php echo esc_html($p['sample']); ?></p>
                <a href="#" class="btn-primary ryder-trigger-popup" style="font-size:10.5px;padding:10px 22px;margin-top:16px;display:inline-flex;">Enquire Now ›</a>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <!-- DETAILED DAY-BY-DAY ITINERARY -->
        <section id="itinerary" class="section" aria-labelledby="itin-heading">
          <div class="page-wrap">
            <p class="section-label">Day-by-Day</p>
            <h2 id="itin-heading" class="section-title">Your <em>Journey</em>, Day by Day</h2>
            
            <div class="itin-grid">
              <div class="day-list">
                <?php $first = true; foreach($days as $d): 
                  $active_class = $first ? 'active' : '';
                  $first = false;
                  $tags_arr = explode("\n", $d['tags']);
                ?>
                <div class="day-card <?php echo $active_class; ?>" data-day="<?php echo esc_attr($d['day_num']); ?>">
                  <div class="day-number"><span>Day</span><strong><?php echo esc_html($d['day_num']); ?></strong></div>
                  <p class="day-type"><?php echo esc_html($d['day_type']); ?></p>
                  <h3 class="day-title"><?php echo esc_html($d['title']); ?></h3>
                  <div class="day-body">
                    <?php echo wp_kses_post($d['body']); ?>
                  </div>
                  <div class="day-tags">
                    <?php foreach($tags_arr as $t): if(trim($t)): ?>
                    <span class="day-tag"><?php echo esc_html(trim($t)); ?></span>
                    <?php endif; endforeach; ?>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>

              <!-- STICKY SIDE PANEL -->
              <div class="sticky-map-panel">
                <div id="mini-map" class="ryder-minimap-container"></div>
                <div class="mini-map-footer">
                  <h4>Safari At a Glance</h4>
                  <div class="quick-stats">
                    <div class="quick-stat"><span class="qs-label">Duration</span><span class="qs-val"><?php echo esc_html($duration); ?></span></div>
                    <div class="quick-stat"><span class="qs-label">Parks</span><span class="qs-val"><?php echo esc_html($parks_visited); ?></span></div>
                  </div>
                  <div class="cta-box">
                    <p>Ready to start planning? Our safari specialists are available seven days a week.</p>
                    <a href="#" class="ryder-trigger-popup">Design Your Journey ›</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- INCLUSIONS & EXCLUSIONS -->
        <section class="section" aria-labelledby="inclusions-heading">
          <div class="page-wrap">
            <p class="section-label">What's Included</p>
            <h2 id="inclusions-heading" class="section-title">Inclusions <em>&amp;</em> Exclusions</h2>
            
            <div class="inc-exc-grid">
              <div class="inc-box">
                <div class="box-head">
                  <h3>✓ &nbsp;What's Included</h3>
                </div>
                <div class="box-body">
                  <ul class="inc-exc-list inc">
                    <?php $inc_arr = explode("\n", $inclusions); foreach($inc_arr as $inc): if(trim($inc)): ?>
                    <li><?php echo esc_html(trim($inc)); ?></li>
                    <?php endif; endforeach; ?>
                  </ul>
                </div>
              </div>

              <div class="exc-box">
                <div class="box-head">
                  <h3>✗ &nbsp;What's Not Included</h3>
                </div>
                <div class="box-body">
                  <ul class="inc-exc-list exc">
                    <?php $exc_arr = explode("\n", $exclusions); foreach($exc_arr as $exc): if(trim($exc)): ?>
                    <li><?php echo esc_html(trim($exc)); ?></li>
                    <?php endif; endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- SUPPLEMENTS -->
        <section class="section" aria-labelledby="supplements-heading">
          <div class="page-wrap">
            <p class="section-label">Enrich Your Safari</p>
            <h2 id="supplements-heading" class="section-title">Optional <em>Supplements</em></h2>
            
            <div class="supps-grid">
              <?php foreach($supplements as $s): ?>
              <div class="supp-card">
                <span class="supp-icon"><?php echo esc_html($s['icon']); ?></span>
                <div>
                  <div class="supp-name"><?php echo esc_html($s['name']); ?></div>
                  <div class="supp-price"><?php echo esc_html($s['price']); ?></div>
                  <div class="supp-note"><?php echo esc_html($s['note']); ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <!-- FAQ -->
        <section class="section" aria-labelledby="faq-heading">
          <div class="page-wrap">
            <p class="section-label">Common Questions</p>
            <h2 id="faq-heading" class="section-title">Frequently Asked <em>Questions</em></h2>
            
            <div class="faq-list" role="list">
              <?php $first = true; foreach($faqs as $f): 
                $open_class = $first ? 'open' : '';
                $first = false;
              ?>
              <div class="faq-item <?php echo $open_class; ?>" role="listitem">
                <button class="faq-q" aria-expanded="true">
                  <?php echo esc_html($f['question']); ?>
                  <span class="faq-icon">+</span>
                </button>
                <div class="faq-a">
                  <?php echo wp_kses_post($f['answer']); ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <!-- FOOTER CTA -->
        <section id="inquire" class="footer-cta" aria-labelledby="cta-heading">
          <div class="footer-cta-inner">
            <p class="section-label">Begin Your Safari</p>
            <h2 id="cta-heading" class="section-title">Ready to <em>Design Your Journey?</em></h2>
            <p>Your RYDER Signature specialist will build a personalised quote within 24 hours.</p>
            <div class="hero-cta-row">
              <a href="#" class="btn-primary ryder-trigger-popup">Design Your Journey ›</a>
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

        </main>
    </div>
    <?php
    return ob_get_clean();
}
