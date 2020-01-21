<?php
namespace Mimicry\Foundation;

use Illuminate\Config\Repository;

/**
 * ConfigProvider
 *
 * @package             Mimicry\Foundation
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
class ConfigProvider extends Provider {

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
     * Register the config repository with the service container.
     *
     * @access public
     */
    public function register()
    {
        $this->app->singleton('Illuminate\Config\Repository', function () {

            $config = new Repository(require $this->getConfigFilepath());

            if (\is_array($files = $config->get('config_files'))) {
                foreach ($files as $key => $file) {
                    $data = include(\theme_path() . MIMICRY_CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . $file);
                    $config->set($key, $data);
                }
            }

            return $config;
        });
    }


    /**
     * getConfigFilepath.
     *
     * Get the full path to the app.php config file.
     *
     * @access private
     * @return string
     */
    private function getConfigFilepath(): string
    {
        $configfile = \theme_path() . MIMICRY_CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . MIMICRY_CONFIG_FILE;

        if (!file_exists($configfile))
            \wp_die("Config file does not exist! '{$configfile}'");

        return $configfile;
    }

}