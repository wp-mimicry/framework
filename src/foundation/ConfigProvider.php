<?php
namespace Mimicry\Foundation;

use Illuminate\Config\Repository;
use Mimicry\Foundation\App;

class ConfigProvider {

    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public function register(): void
    {
        $this->app->singleton('Illuminate\Config\Repository', function () {
            $config = new Repository(require $this->getConfigFilepath());

            if (is_array($files = $config->get('config_files'))) {
                foreach ($files as $key => $file) {
                    $data = include(\theme_path() . MIMICRY_CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . $file);
                    $config->set($key, $data);
                }
            }

            return $config;
        });
    }


    private function getConfigFilepath()
    {
        $configfile = \theme_path() . MIMICRY_CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . MIMICRY_CONFIG_FILE;

        if (!file_exists($configfile))
            \wp_die("Config file does not exist! '{$configfile}'");

        return $configfile;
    }

}