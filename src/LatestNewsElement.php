<?php

namespace BiffBangPow\Element;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\NumericField;

/**
 * Class \BiffBangPow\Element\LatestNewsElement
 *
 * @property string $LinkText
 * @property string $CTAType
 * @property string $LinkData
 * @property string $LinkAnchor
 * @property string $Content
 * @property int $PostCount
 * @property int $DownloadFileID
 * @property int $ActionID
 * @method \SilverStripe\Assets\File DownloadFile()
 * @method \SilverStripe\CMS\Model\SiteTree Action()
 * @method \SilverStripe\ORM\ManyManyList|\SilverStripe\Blog\Model\Blog[] Blogs()
 * @mixin \BiffBangPow\Extension\CallToActionExtension
 */
class LatestNewsElement extends BaseElement
{
    private static $table_name = 'BBP_LatestNewsElement';
    private static $inline_editable = false;
    private static $db = [
        'Content' => 'HTMLText',
        'PostCount' => 'Int'
    ];
    private static $defaults = [
        'PostCount' => 4
    ];

    private static $many_many = [
        'Blogs' => Blog::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Main', [
            HTMLEditorField::create('Content')->setRows(8),
            NumericField::create('PostCount', 'Number of posts to show')->setHTML5(true),
            ListboxField::create('Blogs', 'News feeds to include', Blog::get()->map())
        ]);
        return $fields;
    }

    public function getLatestPosts()
    {
        if ($this->Blogs()->count() > 0) {
            return BlogPost::get()->filter([
                'ParentID' => $this->Blogs()->Column('ID')
            ])->limit($this->PostCount);
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
