<?php
namespace Mimicry\Foundation;

use Mimicry\Foundation\App;

abstract class Service {

    /**
     * app.
     *
     * @var Container Service container.
     *
     * @access protected
     */
    protected $app = null;


    /**
     * __construct.
     *
     * Initialize the class.
     *
     * @param App $app Service container.
     * @access public
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

}