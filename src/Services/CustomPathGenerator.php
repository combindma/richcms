<?php

namespace Combindma\Richcms\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Vinkla\Hashids\Facades\Hashids;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return Hashids::connection('main')->encode($media->id).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return Hashids::connection('main')->encode($media->id).'/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return Hashids::connection('main')->encode($media->id).'/responsive-images/';
    }
}
