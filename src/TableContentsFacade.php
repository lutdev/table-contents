<?php
namespace Lutdev\TOC;

use Illuminate\Support\Facades\Facade;

class TableContentsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TableContents::class;
    }
}