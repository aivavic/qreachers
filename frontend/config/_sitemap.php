<?php
return [
    'class'  => 'himiklab\sitemap\Sitemap',
    'models' => [
        // your models
        //'app\modules\news\models\News',
        // or configuration for creating a behavior
        //Article
        [
            'class'     => 'common\models\Article',
            'behaviors' => [
                'sitemap'     => [
                    'class' => himiklab\sitemap\behaviors\SitemapBehavior::className(),
                    'scope' => function ($model) {
                        // @var \yii\db\ActiveQuery $model
                        $model->select(['slug', 'updated_at']);
                        $model->andWhere(['status' => 1]);
                    },
                        'dataClosure' => function ($model) {
                        // @var self $model
                        return
                            [
                                'loc'        => \yii\helpers\Url::to('ru/article/view/' . $model->slug, true),
                                'lastmod'    => strtotime($model->updated_at),
                                'changefreq' => himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                                'priority'   => 0.8
                        ];
                    }
                    ]
                ]
            ],
            //Project
            [
                'class'     => 'common\models\Project',
                'behaviors' => [
                    'sitemap'     => [
                        'class' => himiklab\sitemap\behaviors\SitemapBehavior::className(),
                        'scope' => function ($model) {
                            // @var \yii\db\ActiveQuery $model
                            $model->select(['slug', 'updated_at']);
                            $model->andWhere(['status' => 1]);
                        },
                            'dataClosure' => function ($model) {
                            // @var self $model
                            return [
                                'loc'        => \yii\helpers\Url::to('ru/project/view/' . $model->slug, true),
                                'lastmod'    => strtotime($model->updated_at),
                                'changefreq' => himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                                'priority'   => 0.8
                            ];
                        }
                        ],
                    ],
                ],
                //Page
                [
                    'class'     => 'common\models\Page',
                    'behaviors' => [
                        'sitemap'     => [
                            'class' => himiklab\sitemap\behaviors\SitemapBehavior::className(),
                            'scope' => function ($model) {
                                // @var \yii\db\ActiveQuery $model
                                $model->select(['slug', 'updated_at']);
                                $model->andWhere(['status' => 1]);
                            },
                                'dataClosure' => function ($model) {
                                // @var self $model
                                return [
                                    'loc'        => \yii\helpers\Url::to('ru/page/view/' . $model->slug, true),
                                    'lastmod'    => strtotime($model->updated_at),
                                    'changefreq' => himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                                    'priority'   => 0.8
                                ];
                            }
                            ],
                        ],
                    ],
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
                ],
                'enableGzip'  => false, // default is false
                'cacheExpire' => 1, // 1 second. Default is 24 hours
            ];
