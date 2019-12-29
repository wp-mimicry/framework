<?php
/**
 * Mimicry
 *
 * Setup the Mimicry framework.
 *
 * @package    Mimicry
 */

namespace Mimicry;

require_once __DIR__ . '/../vendor/autoload.php';

use \Exception;
use \Mimicry\Foundation\App;

/**
 * Class Mimicry
 *
 * @package Mimicry
 */
final class Mimicry {

    static $MymicryLoaded = false;

    private $app = null;

    protected $baseConfig = [
        'app_path' => 'app',
        'config_dir_path' => 'app/config',
        'config_file' => 'app.php'
    ];


    /**
     * __construct.
     *
     * @throws Exception
     */
    public function __construct()
    {
        if (static::$MymicryLoaded)
            throw new \Exception('Mimicry is already loaded');

        $this->app = new App();
    }


    public function init(Array $config = []): void
    {
        ob_start();

        $this->setConstants($config);

        $this->initializeKernel();

        $this->app->instance('Mimicry\Mimicry', $this);

        static::$MymicryLoaded = true;
    }


    private function setConstants(Array $config): void
    {
        $config = $this->validateConfigArray($config);

        \define('MIMICRY_APP_DIR_PATH', \trim($config['app_path'], '/'));
        \define('MIMICRY_CONFIG_DIR_PATH', \trim($config['config_dir_path'], '/'));
        \define('MIMICRY_CONFIG_FILE', \trim($config['config_file'], '/'));
    }


    private function validateConfigArray(Array $config)
    {
        return \array_merge($this->baseConfig, $config);
    }


    /**
     * initializeKernel.
     *
     * Initialize the Mimicry Kernel.
     *
     * @return void
     */
    private function initializeKernel(): void
    {
        try {
            $kernel = $this->app->make(\Mimicry\Foundation\Kernel::class);
            $kernel->init();
        } catch (Exception $e) {
            wp_die($e->getMessage());
        }
    }

}