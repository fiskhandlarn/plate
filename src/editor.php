<?php

/*
 * This file is part of WordPlate.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Illuminate\Support\Str;

// Remove meta boxes in post editor.
add_action('admin_menu', function () {
    $types = [
        'categorydiv' => 'post',
        'commentsdiv' => 'post',
        'commentstatusdiv' => 'post',
        'linkadvanceddiv' => 'link',
        'linktargetdiv' => 'link',
        'linkxfndiv' => 'link',
        'postcustom' => 'post',
        'postexcerpt' => 'post',
        'revisionsdiv' => 'post',
        'slugdiv' => 'post',
        'sqpt-meta-tags' => 'post',
        'tagsdiv-post_tag' => 'post',
        'trackbacksdiv' => 'post',
    ];

    $boxes = get_theme_support('plate-editor');

    foreach (reset($boxes) as $box) {
        remove_meta_box($box, $types[$box], 'normal');
    }
});

// Sanitize file names on save.
add_filter('sanitize_file_name', function ($name) {
    $path = pathinfo($name);

    if (!isset($path['extension'])) {
        return $name;
    }

    $filename = preg_replace(sprintf('/.%s$/', $path['extension']), '', $name);

    return sprintf('%s.%s', Str::slug($filename), $path['extension']);
}, 10, 2);
