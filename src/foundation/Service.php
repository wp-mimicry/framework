<?php
/**
 * Service
 *
 * base service class.
 *
 * @package             Mimicry
 * @subpackage          Mimicry\Foundation;
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @copyright           2020 Stephan Nijman
 * @license             GPL-2.0-or-later
 * @version             1.0.0
 */

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