<?php

namespace App\Providers;

use App\Models\LDemo;
use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\PostRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Psr\Http\Client\ClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);

        $this->app->singleton(Client::class, function(){
            return ClientBuilder::create()
            ->setHosts([config('elasticsearch.host') ])
            ->build();
        });

        $this->app->bind(ClientInterface::class, Client::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        View::composer(['welcome' , 'demo1'], function ($view) {
            $ldemos = LDemo::all();
            $view->with('demos', $ldemos);
        });

        Post::observe(PostObserver::class);
    }
}
