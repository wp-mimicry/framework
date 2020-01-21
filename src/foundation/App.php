<?php
namespace Mimicry\Foundation;

use \Illuminate\Container\Container;

/**
 * Provider
 *
 * @package             Mimicry\Foundation
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class App extends Container {

    /**
     * @var string $version Mimicry version number
     * @access private
     */
    protected $version = '1.0.0';


    /**
     * __construct.
     *
     * Initialize the class.
     *
     * @access public
     */
    public function __construct()
    {
        $this->registerBaseBindings();
    }


    /**
     * registerBaseBindings.
     *
     * Load core classes into the Container.
     *
     * @access protected
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(\Mimicry\Foundation\App::class, $this);
        $this->instance(\Illuminate\Container\Container::class, $this);
        $this->singleton(\Mimicry\Foundation\Kernel::class, \Mimicry\Foundation\Kernel::class);
    }


    /**
     * version.
     *
     * Return the app version.
     *
     * @access public
     */
    public function version()
    {
        return $this->version;
    }

}
