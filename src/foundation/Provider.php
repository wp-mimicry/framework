<?php
namespace Mimicry\Foundation;

/**
 * Provider
 *
 * @package             Mimicry\Foundation
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
abstract class Provider {

    /**
     * @var Container $app Service container instance.
     * @access private
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


    /**
     * register.
     *
     * Register resources with the service container.
     *
     * @access public
     */
    public function register()
    {
        //
    }


    /**
     * boot.
     *
     * Start off any required classes or services.
     *
     * @access public
     */
    public function boot()
    {
        //
    }


    /**
     * shutdown.
     *
     * Cleanup before the WordPress process stops.
     *
     * @access public
     */
    public function shutdown()
    {
        //
    }

}