<?php

namespace Blogger\BlogBundle\Twig\Extensions;

class BloggerBlogExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'created_ago' => new \Twig_Filter_Method($this, 'createdAgo'),
        );
    }

    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \InvalidArgumentException('createdAgo is unable to handle dates in the future');

        $duration = '';

        switch ($delta) {
            case $delta < 60:
                // Seconds
                $time = $delta;
                $duration = $time . " second" . (($time > 1) ? "s" : "") . " ago";
                break;
            case $delta <=3600:
                // Mins
                $time = floor($delta / 60);
                $duration = $time . " minute" . (($time > 1) ? "s" : "") . " ago";
                break;
            case $delta <=86400:
                // Hours
                $time = floor($delta / 3600);
                $duration = $time . " hour" . (($time > 1) ? "s" : "") . " ago";
                break;
            case $delta >86400;
                // Days
                $time = floor($delta / 86400);
                $duration = $time . " day" . (($time > 1) ? "s" : "") . " ago";
                break;
            default:
                echo "createdAgo is unable to handle dates in the future";
        }

        return $duration;
    }

    public function getName()
    {
        return 'blogger_blog_extension';
    }
}