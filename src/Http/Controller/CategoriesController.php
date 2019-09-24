<?php namespace Anomaly\PostsModule\Http\Controller;

use Anomaly\PostsModule\Category\Command\AddCategoryBreadcrumb;
use Anomaly\PostsModule\Category\Command\AddCategoryMetadata;
use Anomaly\PostsModule\Category\Contract\CategoryRepositoryInterface;
use Anomaly\PostsModule\Post\Command\AddPostsBreadcrumb;
use Anomaly\Streams\Platform\Http\Controller\PublicController;

/**
 * Class CategoriesController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CategoriesController extends PublicController
{

    /**
     * Return an index of category posts.
     *
     * @param  CategoryRepositoryInterface $categories
     * @param                              $category
     * @return \Illuminate\View\View
     */
    public function index(CategoryRepositoryInterface $categories, $category)
    {
        if (!$category = $categories->findBySlug($category)) {
            abort(404);
        }

        dispatch_now(new AddPostsBreadcrumb());
        dispatch_now(new AddCategoryBreadcrumb($category));
        dispatch_now(new AddCategoryMetadata($category));

        return view('anomaly.module.posts::categories/index', compact('category'));
    }
}
