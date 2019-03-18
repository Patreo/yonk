<?php

    if (!function_exists('get_link_by_slug')) {
        function get_link_by_slug($slug, $type = 'post') {
            $post = get_page_by_path($slug, OBJECT, $type);
            return get_permalink($post->ID);
        }
    }
