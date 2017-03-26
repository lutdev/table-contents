<?php
namespace Lutskevich\TOC;

use Illuminate\Support\ServiceProvider;

class TableContentsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TableContents::class, function ($app) {
            return new TableContents();
        });
    }
}