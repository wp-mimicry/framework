<?php
namespace Mimicry\Hooks;

use Mimicry\Foundation\App;
use Mimicry\Foundation\Service;

/**
 * HooksHandler
 *
 * @package             Mimicry\Hooks
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class HooksHandler {

    /**
     * @var Container $app Service container instance.
     * @access private
     */
    protected $app = null;

    /**
     * @var array $baseHook Default parameters for a hook.
     * @access private
     */
    protected $baseHook = ['hook' => '', 'callback' => '', 'priority' => 10, 'arguments' => 1];


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
     * registerHooks.
     *
     * Initialize the class.
     *
     * @param Service $service A service class.
     * @param array   $hooks   Hooks provided by the service.
     * @access public
     */
    public function registerHooks(Service $service, Array $hooks): void
    {
        foreach ($hooks as $hook) {
            $this->registerHook($service, $hook);
        }
    }


    /**
     * registerHook.
     *
     * Initialize the class.
     *
     * @param Service $service A service class.
     * @param array   $hook    A hook provided by the service.
     * @access public
     */
    public function registerHook(Service $service, Array $hook): void
    {
        $hook = $this->validateHooksArray($hook);
        $this->addHookWithWp($hook['hook'], $service, $hook['callback'], $hook['priority'], $hook['arguments']);
    }


    /**
     * addHookWithWp.
     *
     * Register a hook with WordPress and provide a privae callback function..
     *
     * @param string  $hook_name    Name of the hook.
     * @param Service $instance     the service class.
     * @param string  $method       the class method to call.
     * @param int     $priority     priority for the hook.
     * @param int     $accepted_arg Number of parameters to add.
     * @access public
     */
    public function addHookWithWp(string $hook_name, $instance, string $method, int $priority = 10, int $accepted_args = 1)
    {
        $app = $this->app;

        \add_action(
            $hook_name,
            function () use ($app, $instance, $method) {
                return $app->call(array($instance, $method), func_get_args());
            },
            $priority,
            $accepted_args
        );
    }


    /**
     * addHookWithWp.
     *
     * make shure all the required parameters are set.
     *
     * @param array $hook Array containing the hook parameters.
     * @access public
     */
    public function validateHooksArray(array $hook)
    {
        $filteredHook['hook'] = isset($hook['hook']) ? $hook['hook'] : $hook[0];
        $filteredHook['callback'] = isset($hook['callback']) ? $hook['callback'] : $hook[1];
        $filteredHook['priority'] = isset($hook['priority']) ? $hook['priority'] : (isset($hook[2]) ? $hook[2] : 10);
        $filteredHook['arguments'] = isset($hook['arguments']) ? $hook['arguments'] : (isset($hook[3]) ? $hook[3] : 1);
        return $filteredHook;
    }

}