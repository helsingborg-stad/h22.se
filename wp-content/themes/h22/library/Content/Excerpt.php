<?php

namespace H22\Content;

class Excerpt
{
    public function __construct()
    {
        add_filter('get_the_excerpt', array($this, 'stripShortCodes'), 9999, 2);
    }

    public function stripShortCodes($excerpt, $post)
    {
        $trimWords = apply_filters('H22/Content/Excerpt/trimWords', false, $post, $excerpt);
        $excerptLength = apply_filters('H22/Content/Excerpt/excerptLength', 140, $post, $excerpt);
        $excerptSuffix = apply_filters('H22/Content/Excerpt/excerptSuffix', '...', $post, $excerpt);
        $alwaysTrim = apply_filters('H22/Content/Excerpt/alwaysTrim', false, $post, $excerpt);

        return self::getExcerpt($post->ID, $excerptLength, $trimWords, $excerptSuffix, $alwaysTrim);
    }

    public static function getExcerpt($postId = 0, $excerptLength = 50, $trimWords = true, $excerptSuffix = '...', $alwaysTrim = true)
    {
        $postId = $postId ? $postId : get_queried_object_id();
        if (!$postId) {
            return '';
        }
        $post = get_post($postId);
        $excerpt = $post->post_excerpt;

        if (!empty($excerpt) && !$alwaysTrim) {
            return $excerpt;
        }

        if (empty($excerpt)) {
            $excerpt = $post->post_content;

            // Remove shortcodes
            $excerpt = preg_replace('/\[.*?\]/', '', $excerpt);

            // Only include paragraphs
            if (apply_filters('H22/Content/Excerpt/onlyIncludeParagraphs', true)) {
                $re = '/<p.*?>.*?<\/p>/m';
                $str = $excerpt;
                preg_match_all($re, $str, $matches);
                if (is_array($matches) && !empty($matches)) {
                    $excerpt = array();
                    foreach ($matches as $match) {
                        if (isset($match[0])) {
                            $excerpt[] = $match[0];
                        }
                    }
                    $excerpt = implode(' ', $excerpt);
                }
            }
        }

        $excerpt = \Municipio\Helper\Html::stripTagsAndAtts($excerpt);

        if ($trimWords && $excerptLength > 0) {
            $words = explode(' ', $excerpt, $excerptLength + 1);
            if (count($words) > $excerptLength) {
                array_pop($words);
                $excerpt = implode(' ', $words) . '...';
            }
        }

        if (!$trimWords && $excerptLength > 0) {
            $excerpt = substr($excerpt, 0, $excerptLength);
        }

        if (is_string($excerptSuffix) && !empty($excerptSuffix)) {
            $excerpt = $excerpt . $excerptSuffix;
        }

        return $excerpt;
    }
}
