<?php

namespace BiffBangPow\Element;

use BiffBangPow\Element\Control\LatestNewsElementController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Blog\Model\BlogCategory;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Blog\Model\BlogTag;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Security\Member;

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
 * @property int $VideoFileID
 * @method \SilverStripe\Assets\File DownloadFile()
 * @method \SilverStripe\CMS\Model\SiteTree Action()
 * @method \SilverStripe\Assets\File VideoFile()
 * @method \SilverStripe\ORM\ManyManyList|\SilverStripe\Blog\Model\Blog[] Blogs()
 * @method \SilverStripe\ORM\ManyManyList|\SilverStripe\Blog\Model\BlogCategory[] Categories()
 * @method \SilverStripe\ORM\ManyManyList|\SilverStripe\Blog\Model\BlogTag[] Tags()
 * @method \SilverStripe\ORM\ManyManyList|\SilverStripe\Security\Member[] Authors()
 * @mixin \BiffBangPow\Extension\CallToActionExtension
 */
class LatestNewsElement extends BaseElement
{
    private static $table_name = 'BBP_LatestNewsElement';
    private static $controller_class = LatestNewsElementController::class;
    private static $inline_editable = false;
    private static $db = [
        'Content' => 'HTMLText',
        'PostCount' => 'Int'
    ];
    private static $defaults = [
        'PostCount' => 4
    ];

    private static $many_many = [
        'Blogs' => Blog::class,
        'Categories' => BlogCategory::class,
        'Tags' => BlogTag::class,
        'Authors' => Member::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Main', [
            HTMLEditorField::create('Content')->setRows(8),
            NumericField::create('PostCount', 'Number of posts to show')->setHTML5(true),
            HeaderField::create('News sources'),
            LiteralField::create('sourcehelp', '<p>By default, the element will include posts from any blog page on the site.</p>
<p>You can be more selective with the filters below.  Please note: these filters are <em>additive</em>, so if you select more than one, posts from <em>all the sources</em> are included</em></p>'),
            ListboxField::create('Blogs', 'News feeds to include', Blog::get()->map()),
            ListboxField::create('Categories', 'Categories to include', BlogCategory::get()->map()),
            ListboxField::create('Tags', 'Tags to include', BlogTag::get()->map()),
            ListboxField::create('Authors', 'Authors to include', Member::get()->map())
        ]);
        return $fields;
    }

    public function getLatestPosts()
    {
        $posts = BlogPost::get();
        $filters = [];

        if ($this->Blogs()->count() > 0) {
            $filters['ParentID'] = $this->Blogs()->Column('ID');
        }
        if ($this->Categories()->count() > 0) {
            $filters['Categories.ID'] = $this->Categories()->Column('ID');
        }
        if ($this->Tags()->count() > 0) {
            $filters['Tags.ID'] = $this->Tags()->Column('ID');
        }
        if ($this->Authors()->count() > 0) {
            $filters['Authors.ID'] = $this->Authors()->Column('ID');
        }

        if (count($filters) > 0) {
            $posts = $posts->filterAny($filters);
        }
        return $posts->limit($this->PostCount);
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
