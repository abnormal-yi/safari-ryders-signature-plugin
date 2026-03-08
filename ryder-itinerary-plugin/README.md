# Ryder Signature Itinerary Plugin

This WordPress plugin registers a custom post type `itinerary` and provides a shortcode to render the exact HTML, CSS, and JS provided in your template.

## Installation

1. Download the `ryder-itinerary-plugin` folder.
2. Upload it to your WordPress site's `wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. Go to **Itineraries > Add New** in your WordPress dashboard.
2. Publish the itinerary.
3. Use the shortcode `[ryder_itinerary id="POST_ID"]` in any page, post, or Elementor widget (using the Shortcode widget).
   - If you use the shortcode on the single itinerary page itself, you can just use `[ryder_itinerary]`.

## Dynamic Data (ACF)

To make the data dynamic, install the **Advanced Custom Fields (ACF)** plugin.
Create a Field Group assigned to the Post Type `Itinerary`.

Use the following Field Names to override the default template data:

- `ryder_hero_badge` (Text)
- `ryder_hero_title` (Text)
- `ryder_hero_title_em` (Text)
- `ryder_hero_subtitle` (Textarea)
- `ryder_duration` (Text)
- `ryder_parks_visited` (Text)
- `ryder_starting_price` (Text)
- `ryder_best_for` (Text)
- `ryder_rating_score` (Text)
- `ryder_rating_reviews` (Text)
- `ryder_rating_award` (Text)
- `ryder_rating_departure` (Text)
- `ryder_overview_label` (Text)
- `ryder_overview_title` (Text)
- `ryder_overview_lead` (Textarea)
- `ryder_overview_content` (WYSIWYG)
- `ryder_highlights` (Repeater)
  - `icon` (Text)
  - `title` (Text)
  - `description` (Textarea)
- `ryder_glance` (Repeater)
  - `day` (Text)
  - `route` (Text)
  - `overnight` (Text)
  - `meals` (Checkbox: B, L, D)
  - `highlights` (Text)
- `ryder_map_stops` (Repeater)
  - `id` (Text)
  - `type` (Select: city, park)
  - `day` (Text)
  - `name` (Text)
  - `lat` (Number)
  - `lng` (Number)
  - `r` (Number - radius)
- `ryder_pricing` (Repeater)
  - `tier` (Text)
  - `name` (Text)
  - `price` (Text)
  - `features` (Textarea - one per line)
  - `sample` (Textarea)
  - `is_featured` (True/False)
- `ryder_days` (Repeater)
  - `day_num` (Text)
  - `day_type` (Text)
  - `title` (Text)
  - `body` (WYSIWYG)
  - `tags` (Textarea - one per line)
- `ryder_inclusions` (Textarea - one per line)
- `ryder_exclusions` (Textarea - one per line)
- `ryder_supplements` (Repeater)
  - `icon` (Text)
  - `name` (Text)
  - `price` (Text)
  - `note` (Textarea)
- `ryder_faqs` (Repeater)
  - `question` (Text)
  - `answer` (WYSIWYG)

If a field is left empty or ACF is not installed, the plugin will automatically fall back to the default static data from your HTML template.
