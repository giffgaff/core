<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Filter;

use Flarum\Discussion\Discussion;
use Flarum\Discussion\Filter as DiscussionFilter;
use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Post\Filter as PostFilter;
use Flarum\Post\Post;
use Flarum\User\Filter as UserFilter;
use Flarum\User\User;

class FilterServiceProvider extends AbstractServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('flarum.filter.filters', function () {
            return [
                Discussion::class => [
                    DiscussionFilter\AuthorFilter::class,
                    DiscussionFilter\CreatedFilter::class,
                    DiscussionFilter\HiddenFilter::class,
                    DiscussionFilter\UnreadFilter::class,
                ],
                Post::class => [
                    PostFilter\AuthorFilter::class,
                    PostFilter\DiscussionFilter::class,
                    PostFilter\IdFilter::class,
                    PostFilter\NumberFilter::class,
                    PostFilter\TypeFilter::class,
                ],
                User::class => [
                    UserFilter\EmailFilter::class,
                    UserFilter\GroupFilter::class,
                ]
            ];
        });
    }

    public function boot()
    {
        $allFilters = $this->app->make('flarum.filter.filters');

        foreach ($allFilters as $resource => $resourceFilters) {
            foreach ($resourceFilters as $filter) {
                $filter = $this->app->make($filter);
                Filterer::addFilter($resource, $filter);
            }
        }
    }
}
