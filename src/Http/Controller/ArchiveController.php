<?php namespace Anomaly\PostsModule\Http\Controller;

use Anomaly\PostsModule\Post\Command\AddArchiveBreadcrumb;
use Anomaly\PostsModule\Post\Command\AddPostsBreadcrumb;
use Anomaly\PostsModule\Post\Contract\PostRepositoryInterface;
use Anomaly\Streams\Platform\Http\Controller\PublicController;

/**
 * Class ArchiveController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ArchiveController extends PublicController
{

    /**
     * Return an index of archived posts.
     *
     * @param  PostRepositoryInterface                                  $posts
     * @param                                                           $year
     * @param  null                                                     $month
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($year, $month = null)
    {
        dispatch_now(new AddPostsBreadcrumb());
        dispatch_now(new AddArchiveBreadcrumb());

        return view('anomaly.module.posts::archive/index', compact('year', 'month'));
    }
}
