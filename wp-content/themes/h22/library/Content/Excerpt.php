<?php

namespace H22\Content;

class Excerpt
{
    public function __construct()
    {
        add_filter('get_the_excerpt', array($this, 'stripShortCodes'), 10, 2);
    }

    public function stripShortCodes($excerpt, $post)
    {
        $trimWords = apply_filters('H22/Content/Excerpt/trimWords', false, $post, $excerpt);
        $excerptLength = apply_filters('H22/Content/Excerpt/excerptLength', 140, $post, $excerpt);
        $excerptSuffix = apply_filters('H22/Content/Excerpt/excerptSuffix', '...', $post, $excerpt);
        $alwaysTrim = apply_filters('H22/Content/Excerpt/alwaysTrim', false, $post, $excerpt);

        return self::getExcerpt($post->ID, $excerptLength, $trimWords, $excerptSuffix, $alwaysTrim);
    }

    public static function getExcerpt($post = 0, $excerptLength = 50, $trimWords = true, $excerptSuffix = '...', $alwaysTrim = true)
    {
        if (!is_object($post) || get_class($post) !== 'WP_Post') {
            $post = is_numeric($post) && $post > 0 ? get_post($post) : get_queried_object();
        }

        if (!is_object($post)) {
            return '';
        }

        $excerpt = $post->post_excerpt;

        if (empty($excerpt)) {
            $excerpt = $post->post_content;

            // Remove shortcodes
            $excerpt = preg_replace('/\[.*?\]/', '', $excerpt);
            
            $filterPattern = apply_filters(
                'H22/Content/Excerpt/getExcerpt/filterPattern',
                '/<(h[1-6]|span).*?>.*?<\/(\1)>/m'
            );

            // Remove strings matching reg pattern
            if ($filterPattern) {
                preg_match_all($filterPattern, $excerpt, $matches);
                if (isset($matches[0]) && is_array($matches[0]) && !empty($matches[0])) {
                    foreach ($matches[0] as $fullMatch) {
                        if ($fullMatch) {
                            $excerpt = str_replace($fullMatch, '', $excerpt);
                        }
                    }
                }
            }
        }

        $excerpt = \Municipio\Helper\Html::stripTagsAndAtts($excerpt);

        // Don't trim existing excerpt if $alwaysTrim is false
        if (!empty($post->post_excerpt) && !$alwaysTrim) {
            return $excerpt;
        }

        if ($trimWords && $excerptLength > 0) {
            $words = explode(' ', $excerpt, $excerptLength + 1);
            if (count($words) > $excerptLength) {
                array_pop($words);
                $excerpt = implode(' ', $words);
            }
        }

        if (!$trimWords && $excerptLength > 0) {
            $excerpt = substr($excerpt, 0, $excerptLength);
        }

        if (empty($post->post_excerpt)) {
            $excerpt = $excerpt . apply_filters('excerpt_more', '...');
        }

        return $excerpt;
    }
}
