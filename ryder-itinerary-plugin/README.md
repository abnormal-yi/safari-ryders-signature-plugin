# Ryder Signature Itinerary Plugin

This WordPress plugin registers a custom post type `itinerary` and provides a shortcode to render the exact HTML, CSS, and JS provided in your template.

## Installation

1. Download the `ryder-itinerary-plugin` folder.
2. Upload it to your WordPress site's `wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Importing ACF Fields (Easiest Way)

Instead of creating all fields manually, you can import them instantly:
1. Go to **ACF > Tools** in your WordPress dashboard.
2. Under "Import Field Groups", click "Choose File".
3. Select the `acf-fields.json` file located inside this plugin folder.
4. Click **Import JSON**.
All fields will be automatically created and assigned to the Itinerary post type!

## Importing Elementor Template

If you are using Elementor Pro to design the Single Itinerary page:
1. Go to **Templates > Theme Builder** (or Saved Templates).
2. Click the **Import Templates** button (up arrow icon) at the top.
3. Select the `elementor-template.json` file located inside this plugin folder.
4. Set the display conditions for this template to "Include: Itineraries".

## Usage

1. Go to **Itineraries > Add New** in your WordPress dashboard.
2. Fill in the ACF fields (or leave them blank to use the default Northern Circuit data).
3. Publish the itinerary.
4. Use the shortcode `[ryder_itinerary id="POST_ID"]` in any page, post, or Elementor widget.
   - If you use the shortcode on the single itinerary page itself (or via the imported Elementor template), you can just use `[ryder_itinerary]`.
