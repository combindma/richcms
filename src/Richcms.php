<?php

namespace Combindma\Richcms;

use Artesaos\SEOTools\Facades\SEOTools;
use Combindma\Blog\Models\Post;

class Richcms
{
    public function setSeo(array $page, bool $noindex = false): void
    {
        if ($noindex) {
            SEOTools::metatags()->addMeta('robots', 'noindex,nofollow');
        }
        SEOTools::setTitle($page['meta_title']);

        if (array_key_exists('meta_description', $page)) {
            SEOTools::setDescription($page['meta_description']);
        }
        if (array_key_exists('featured_image', $page)) {
            SEOTools::addImages([$page['featured_image']]);
        }
        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->addValue('@id', url()->current() . '#webpage');
    }

    public function setPostSeo(Post $post)
    {
        SEOTools::setTitle($post->meta_title ?? ucfirst($post->title));
        SEOTools::setDescription($post->meta_description ?? ucfirst($post->description));
        SEOTools::opengraph()->setTitle($post->meta_title ?? ucfirst($post->title))
            ->setDescription($post->meta_description ?? ucfirst($post->description))
            ->setType('article')
            ->setArticle([
                'locale' => str_replace('_', '-', app()->getLocale()),
                'published_time' => $post->published_at,
                'modified_time' => $post->published_at,
                'author' => $post->author?->name,
            ]);
        SEOTools::opengraph()->addProperty('locale', str_replace('_', '-', app()->getLocale()));
        SEOTools::opengraph()->addImage(url($post->featured_image_url()));

        SEOTools::twitter()->setTitle($post->meta_title ?? ucfirst($post->title));
        SEOTools::twitter()->setSite(config('app.name'));

        SEOTools::jsonLd()->setTitle($post->meta_title ?? ucfirst($post->title));
        SEOTools::jsonLd()->setDescription($post->meta_description ?? ucfirst($post->description));
        SEOTools::jsonLd()->setType('Article');
        SEOTools::jsonLd()->addImage(url($post->featured_image_url()));
        SEOTools::jsonLd()->addValue('author', [
            '@type' => 'Person',
            'name' => $post->author?->name,
        ]);
        SEOTools::jsonLd()->addValue('datePublished', $post->published_at);
        SEOTools::jsonLd()->addValue('dateModified', $post->published_at);
        SEOTools::jsonLd()->addValue('headline', $post->meta_title ?? ucfirst($post->title));
        SEOTools::jsonLd()->addValue('mainEntityOfPage', [
            '@type' => 'WebPage',
            '@id' => url()->current(),
        ]);
    }
}
