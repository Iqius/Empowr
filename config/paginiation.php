<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Pagination View
    |--------------------------------------------------------------------------
    |
    | This option controls the default pagination view that will be used when
    | generating pagination links for your application. By default, we use
    | the "tailwind" pagination view which provides a Tailwind-compatible
    | style, but you are free to customize this to your liking.
    |
    */

    'default' => 'tailwind',

    /*
    |--------------------------------------------------------------------------
    | Pagination Views
    |--------------------------------------------------------------------------
    |
    | Here you can specify a custom view that will be used to render pagination
    | links. You may modify the default "tailwind" pagination view to suit
    | your needs, or you may create a custom view for your pagination links.
    |
    */

    'views' => [
        'default' => 'pagination::tailwind',
    ],

];
