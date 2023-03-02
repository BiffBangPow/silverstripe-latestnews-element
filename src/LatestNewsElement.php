<?php

namespace BiffBangPow\Element;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Blog\Model\BlogPost;

class LatestNewsElement extends BaseElement
{
    private static $table_name = 'BBP_LatestNewsElement';

    private static $db = [
        'Content' => 'HTMLText',
        'PostCount' => 'Int'
    ];

    private static $many_many = [
        'Blogs' => Blog::class
    ];

    public function getLatestPosts()
    {
        if ($this->Blogs()->count() > 0) {
            return BlogPost::get()->filter([
                'ParentID' => $this->Blogs()->Column('ID')
            ])->limit($this->limit);
        }
        return false;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return 'Latest News';
    }

    /**
     * @return string
     */
    public function getSimpleClassName()
    {
        return 'bbp-latestnews-element';
    }

}