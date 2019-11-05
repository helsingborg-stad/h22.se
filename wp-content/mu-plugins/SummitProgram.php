<?php

/*
Plugin Name: SummitProgram
Description: Append anchor links to permalinks at specific times
Version:     1.0
Author:      Nikolas Ramstedt
*/

namespace SummitProgram;

class SummitProgram
{
    public function __construct()
    {
        add_filter('post_link', array($this, 'appendAnchorLinksDuringEvent'), 10, 2);
        add_filter('page_link', array($this, 'appendAnchorLinksDuringEvent'), 10, 2);
        add_filter('post_type_link', array($this, 'appendAnchorLinksDuringEvent'), 10, 2);
        add_filter('category_link', array($this, 'appendAnchorLinksDuringEvent'), 11, 2);
        add_filter('tag_link', array($this, 'appendAnchorLinksDuringEvent'), 10, 2);
        add_filter('author_link', array($this, 'appendAnchorLinksDuringEvent'), 11, 2);
        add_filter('day_link', array($this, 'appendAnchorLinksDuringEvent'), 11, 2);
        add_filter('month_link', array($this, 'appendAnchorLinksDuringEvent'), 11, 2);
        add_filter('year_link', array($this, 'appendAnchorLinksDuringEvent'), 11, 2);
    }

    public function appendAnchorLinksDuringEvent($permalink, $post)
    {
        if ($post !== 5712) {
            return $permalink;
        }

        if (time() >= strtotime('05-11-2019 11:45 +1') && time() < strtotime('05-11-2019 14:45 +1')) {
            $permalink .= '#breakoutsone';
        }

        if (time() >= strtotime('05-11-2019 14:45 +1') && time() < strtotime('05-11-2019 18:00 +1')) {
            $permalink .= '#breakoutstwo';
        }

        if (time() >= strtotime('05-11-2019 18:00 +1') && time() < strtotime('05-12-2019 23:59 +1')) {
            $permalink .= '#daytwo';
        }

        return $permalink;
    }
}

new \SummitProgram\SummitProgram();
