<?php

return[
    'host' => env('ELASTICSEARCH_HOST', 'http://elasticsearch:9200'),

    'indices' =>[
        'posts' => env('ELASTICSEARCH_POSTS_INDEX' , 'posts'),
    ]
];