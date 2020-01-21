<?php
namespace Mimicry;

/*
 * Check and maybe import the composer autoload file.
 */
if (file_exists(__DIR__ . '/../vendor/autoload.php'))
    require_once __DIR__ . '/../vendor/autoload.php';

use \Exception;
use \Mimicry\Foundation\App;
use \Mimicry\Foundation\Kernel;

/**
 * Mimicry
 *
 * @package             Mimicry
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class Mimicry {

    /**
     * @var bool $MimicryLoaded Is Mimicry loaded already.
     * @access static
     */
    static $mimicryLoaded = false;

    /**
     * @var Container $app Service container instance.
     * @access private
     */
    protected $app = null;

    /**
     * @var array $baseConfig Base configuration array.
     * @access private
     */
    protected $baseConfig = [
        'app_path' => 'app',
        'config_dir_path' => 'app/config',
        'config_file' => 'app.php'
    ];


    /**
     * __construct.
     *
     * Class constructor.
     *
     * @access public
     */
    public function __construct()
    {
        if (static::$mimicryLoaded)
            throw new \Exception('Mimicry is already loaded');

        $this->app = new App();
    }


    /**
     * init.
     *
     * Initialize Mimicry.
     *
     * @access public
     */
    public function init(Array $config = [])
    {
        $this->setConstants($config);

        $this->initializeKernel();

        static::$mimicryLoaded = true;
    }


    /**
     * setConstants.
     *
     * Validate the baseConfig array and use it to define constants.
     *
     * @access private
     */
    private function setConstants(Array $config)
    {
        $config = $this->validateConfigArray($config);

        \define('MIMICRY_APP_DIR_PATH', \trim($config['app_path'], '/'));
        \define('MIMICRY_CONFIG_DIR_PATH', \trim($config['config_dir_path'], '/'));
        \define('MIMICRY_CONFIG_FILE', \trim($config['config_file'], '/'));
    }


    /**
     * validateConfigArray.
     *
     * Validate the baseConfig array.
     *
     * @access private
     */
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
    private function initializeKernel()
    {
        try {
            $kernel = ($this->app->make(Kernel::class))->init();
        } catch (Exception $e) {
            wp_die($e->getMessage());
        }
    }

}