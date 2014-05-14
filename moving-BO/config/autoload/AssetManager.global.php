<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'asset_manager' => array(
        
        'resolver_configs' => array(
            'collections' => array(
                'js/bootstrap-all.js' => array(
                    'js/jquery.js',
                    'js/bootstrap.js',
                ),
                'js/dataTables.js' => array(
                    'js/jquery.dataTables.js',
                    'js/ResultSet.js',
                ),/*
                'css/bootstrap-all.css' => array(
                    'css/bootstrap-all.less',
                ),
                */
                'css/bootstrap-all.css' => array(
                    'css/bootstrap.css',
                    'css/bootstrap-responsive.css',
                ),/*
                'css/bootstrap-all.less' => array(
                    'css/bootstrap.less',
                    'css/bootstrap-responsive.less',
                ),*/
            ),
            'paths' => array(
                __DIR__ . '/../../public',
            ),
            'map' => array(
               // 'css/bootstrap.less' => __DIR__ . '/../../public/less/bootstrap.less',
               // 'css/bootstrap-responsive.less' => __DIR__ . '/../../public/less/responsive.less',
            ),
        ),
        'caching' => array(
            'default' => array(
                'cache'     => 'FilePath',
                'options' => array(
                    'dir' => __DIR__ . '/../../data/cache', // path/to/cache
                ),
            ),
        ),
        'filters' => array(
            /*'css/bootstrap-all.less' => array(
                array(
                    'filter' => 'Lessphp',
                ),
            ),*//*
            'css/bootstrap-all.css' => array(
                array(
                    'filter' => 'CssMinFilter',
                ),
            ),*/
            'js/dataTables.js' => array(
                array(
                    // Note: You will need to require the classes used for the filters yourself.
                    'filter' => 'JSMin',  // Allowed format is Filtername[Filter]. Can also be FQCN
                ),
            ),
            'js/bootstrap-all.js' => array(
                array(
                    // Note: You will need to require the classes used for the filters yourself.
                    'filter' => 'JSMin',  // Allowed format is Filtername[Filter]. Can also be FQCN
                ),
            ),

        ),
    ),
);
