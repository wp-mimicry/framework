<?php

get_header();

if (have_posts()) {

    while (have_posts()) {

        the_post();

        $before = is_archive() ? '<h2>' : '<h1>';
        $after = is_archive() ? '</h2>' : '</h1>';
        the_title($before, $after);

        if (is_archive()) {
            the_excerpt();
        } else {
            the_content();
        }
    }
}

get_footer();
?>