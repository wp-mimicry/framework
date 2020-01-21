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

}