<?php
namespace Mimicry\Themesupport;

use Illuminate\Config\Repository;

/**
 * ServiceRegisterProvider
 *
 * @package             Mimicry\Themesupport
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class ThemeSupportHandler {

    /**
     * @var array $supports Array containing the theme supports.
     * @access private
     */
    private $supports = null;


    /**
     * __construct.
     *
     * Initialize the class.
     *
     * @param Repository $config The config class.
     *
     * @access public
     */
    public function __construct(Repository $config)
    {
        $this->supports = $config->get('theme-support');
    }


    /**
     * init.
     *
     * Check the theme support array exist,
     * and register with the after_setup_theme hook.
     *
     * @access public
     */
    public function init()
    {
        if (!is_array($this->supports)) {
            \trigger_error('Theme support array not found', E_USER_NOTICE);
            return;
        }

        \add_action('after_setup_theme', array($this, 'processThemeSupport'));
    }


    /**
     * processThemeSupport.
     *
     * Register theme support items from the config array with WordPress
     *
     * @access public
     */
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