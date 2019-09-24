<?php namespace Anomaly\PostsModule\Http\Controller;

use Anomaly\PostsModule\Category\Command\AddCategoryBreadcrumb;
use Anomaly\PostsModule\Post\Command\AddPostBreadcrumb;
use Anomaly\PostsModule\Post\Command\AddPostsBreadcrumb;
use Anomaly\PostsModule\Post\Command\AddPostsMetaTitle;
use Anomaly\PostsModule\Post\Command\MakePostResponse;
use Anomaly\PostsModule\Post\Command\MakePreviewResponse;
use Anomaly\PostsModule\Post\Contract\PostRepositoryInterface;
use Anomaly\PostsModule\Post\PostResolver;
use Anomaly\Streams\Platform\Http\Controller\PublicController;

/**
 * Class PostsController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PostsController extends PublicController
{

    /**
     * Display recent posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        dispatch_now(new AddPostsBreadcrumb());
        dispatch_now(new AddPostsMetaTitle());

        return view('anomaly.module.posts::posts/index');
    }

    /**
     * Preview an existing post.
     *
     * @param PostRepositoryInterface $posts
     * @param                         $id
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function preview(PostRepositoryInterface $posts, $id)
    {
        if (!$post = $posts->findByStrId($id)) {
            abort(404);
        }

        dispatch_now(new AddPostsBreadcrumb());
        dispatch_now(new MakePreviewResponse($post));

        if ($category = $post->getCategory()) {
            dispatch_now(new AddCategoryBreadcrumb($category));
        }

        dispatch_now(new AddPostBreadcrumb($post));

        return $post->getResponse();
    }

    /**
     * View an existing post.
     *
     * @param  PostResolver $resolver
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function view(PostResolver $resolver)
    {
        if (!$post = $resolver->resolve()) {
            abort(404);
        }

        if (!$post->isLive()) {
            abort(404);
        }

        dispatch_now(new MakePostResponse($post));

        return $post->getResponse();
    }
}
