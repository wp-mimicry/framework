<?php
namespace Mimicry\Themesupport;

use Illuminate\Config\Repository;

class ThemeSupportHandler {

    private $supports = null;


    public function __construct(Repository $config)
    {
        $this->supports = $config->get('theme-support');
    }


    public function init()
    {
        if (!is_array($this->supports)) {
            \trigger_error('Theme support array not found', E_USER_NOTICE);
            return;
        }

        \add_action('after_setup_theme', array($this, 'processThemeSupport'));
    }


    public function processThemeSupport()
    {
        foreach ($this->supports as $support => $value) {
            if ($value === false) {
                \remove_theme_support($support);
            } else {
                \add_theme_support($support, $value);
            }
        }
    }

}