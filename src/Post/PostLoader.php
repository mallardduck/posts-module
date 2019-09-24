<?php namespace Anomaly\PostsModule\Post;

use Anomaly\PostsModule\Post\Contract\PostInterface;

/**
 * Class PostLoader
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostLoader
{

    /**
     * Load post data to the template.
     *
     * @param PostInterface $post
     */
    public function load(PostInterface $post)
    {
        share('post', $post);
        share('title', $post->getTitle());
        share('meta_title', $post->getMetaTitle());
        share('meta_description', $post->getMetaDescription());
    }
}
