<?php
/*
Plugin Name: Custom Stores Carousel
Description: [wcfm_stores_carousel] Fetches city name from a class and generates a stores carousel shortcode.
Version: 1.0
Author: Your Name
*/

function get_element_by_class($class) {
    ob_start();
    the_content();
    $content = ob_get_clean();
    
    $dom = new DOMDocument();
    @$dom->loadHTML($content);

    $xpath = new DOMXPath($dom);
    $elements = $xpath->query("//p[contains(@class, '$class')]");
    
    return !empty($elements) ? $elements[0]->textContent : '';
}

function custom_stores_carousel_shortcode($atts) {
    $city_name = get_element_by_class('location');

    $atts = shortcode_atts(array(
        'search_city' => $city_name,
    ), $atts);

    $shortcode = sprintf('[wcfm_stores_carousel search_city="%s"]', esc_attr($atts['search_city']));
    return do_shortcode($shortcode);
}
add_shortcode('custom_stores_carousel', 'custom_stores_carousel_shortcode');
