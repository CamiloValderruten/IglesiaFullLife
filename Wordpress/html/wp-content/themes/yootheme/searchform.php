<?php
/**
 * The template for displaying a search form.
 */

$result = get_view('search', [

    'position' => get_current_sidebar(),
    'attrs' => [

        'id' => 'search-'.rand(100, 999),
        'action' => esc_url(home_url('/')),
        'method' => 'get',
        'role' => 'search',
        'class' => '',

    ],
    'fields' => [

        ['tag' => 'input', 'name' => 's', 'placeholder' => esc_attr_x('Search &hellip;', 'placeholder'), 'value' => get_search_query()],

    ]

]);

if ($echo) {
    echo $result;
} else {
    return $result;
}
