<?php
return [
    'class'       => 'himiklab\sitemap\Sitemap',
    'models'      => [
    // your models
    //'app\modules\news\models\News',
    // or configuration for creating a behavior
    ],
    'urls'        => [
        // your additional urls
        /* [
          'loc'        => '/news/index',
          'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
          'priority'   => 0.8,
          'news'       => [
          'publication'      => [
          'name'     => 'Example Blog',
          'language' => 'en',
          ],
          'access'           => 'Subscription',
          'genres'           => 'Blog, UserGenerated',
          'publication_date' => 'YYYY-MM-DDThh:mm:ssTZD',
          'title'            => 'Example Title',
          'keywords'         => 'example, keywords, comma-separated',
          'stock_tickers'    => 'NASDAQ:A, NASDAQ:B',
          ],
          'images'     => [
          [
          'loc'          => 'http://example.com/image.jpg',
          'caption'      => 'This is an example of a caption of an image',
          'geo_location' => 'City, State',
          'title'        => 'Example image',
          'license'      => 'http://example.com/license',
          ],
          ],
          ], */
        [ 'loc' => '/db/article'],
        [ 'loc' => '/db/article-category'],
        [ 'loc' => '/db/client'],
        [ 'loc' => '/db/client-category'],
        [ 'loc' => '/db/member'],
        [ 'loc' => '/db/member-category'],
        [ 'loc' => '/db/project'],
        [ 'loc' => '/db/project-category'],
        [ 'loc' => '/db/project-category-second'],
        [ 'loc' => '/db/user'],
        [ 'loc' => '/db/widget-text'],
        [ 'loc' => '/db/page'],
        [ 'loc' => '/db/feedbacks'],
        [ 'loc' => '/db/blocks']
    ],
    'enableGzip'  => false, // default is false
    'cacheExpire' => 1, // 1 second. Default is 24 hours
];
