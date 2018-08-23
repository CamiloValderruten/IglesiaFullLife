<?php

return [

    'update' => 'https://yootheme.com/api/update/yootheme_wp',

    'yootheme/wordpress-widgets' => require 'modules.php',

    'replacements' => [

        'list_match' => '$match(type, "(recent-posts|pages|recent-comments|archives|categories|meta)")',

    ]
];
