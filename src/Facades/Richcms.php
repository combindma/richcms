<?php

namespace Combindma\Richcms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Combindma\Richcms\Richcms
 */
class Richcms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'richcms';
    }
}
