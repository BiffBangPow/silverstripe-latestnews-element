<?php

namespace BiffBangPow\Element\Control;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

/**
 * Class \BiffBangPow\Element\Control\LatestNewsElementController
 *
 */
class LatestNewsElementController extends ElementController
{
    public function init()
    {
        parent::init();
        Requirements::css(
            ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/elements/latestnews.css'),
            false,
            [
                'defer' => true
            ]
        );
    }
}