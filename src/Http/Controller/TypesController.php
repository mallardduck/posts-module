<?php namespace Anomaly\PostsModule\Http\Controller;

use Anomaly\PostsModule\Post\Command\AddPostsBreadcrumb;
use Anomaly\PostsModule\Type\Command\AddTypeBreadcrumb;
use Anomaly\PostsModule\Type\Command\AddTypeMetadata;
use Anomaly\PostsModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\Streams\Platform\Http\Controller\PublicController;

/**
 * Class TypesController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TypesController extends PublicController
{

    /**
     * Return an index of type posts.
     *
     * @param  TypeRepositoryInterface     $types
     * @param                              $type
     * @return \Illuminate\View\View
     */
    public function index(TypeRepositoryInterface $types, $type)
    {
        if (!$type = $types->findBySlug($type)) {
            abort(404);
        }

        dispatch_now(new AddPostsBreadcrumb());
        dispatch_now(new AddTypeBreadcrumb($type));
        dispatch_now(new AddTypeMetadata($type));

        return view('anomaly.module.posts::types/index', compact('type'));
    }
}
