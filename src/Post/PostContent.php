<?php namespace Anomaly\PostsModule\Post;

use Anomaly\EditorFieldType\EditorFieldType;
use Anomaly\EditorFieldType\EditorFieldTypePresenter;
use Anomaly\PostsModule\Post\Contract\PostInterface;

/**
 * Class PostContent
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostContent
{

    /**
     * Make the view content.
     *
     * @param PostInterface $p
     */
    public function make(PostInterface $post)
    {
        $type = $post->getType();

        /* @var EditorFieldType $layout */
        /* @var EditorFieldTypePresenter $presenter */
        $layout    = $type->getFieldType('layout');
        $presenter = $type->getFieldTypePresenter('layout');

        $post->setContent(view($layout->getViewPath(), compact('post'))->render());

        /**
         * If the type layout is taking the
         * reigns then allow it to do so.
         *
         * This will let layouts natively
         * extend parent view blocks.
         */
        if (strpos($presenter->content(), '{% extends') !== false) {
            $post->setResponse(response($post->getContent()));
        }
    }
}
