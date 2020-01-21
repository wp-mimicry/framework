<?php

namespace Mimicry\Enqueue;

class Enqueue {

    /**
     * instance.
     *
     * @var Enqueue $instance instance.
     *
     * @access private
     * @since  1.0.0
     */
    private static $instance = null;


    public function __construct()
    {
        $this->setupHooks();
    }


    /**
     * instance.
     *
     * Return a instance of this class.
     *
     * @return Enqueue
     * @since  1.0.0
     *
     * @access public
     */
    public static function instance(): Enqueue
    {
        if (!isset(self::$instance) && !(self::$instance instanceof \Mimicry\Enqueue\Enqueue)) {
            self::$instance = new Self();
        }
        return self::$instance;
    }


    private function setupHooks()
    {
        // dd('setupHooks');
    }


    public function enqueueStyle(string $handle, string $src = '', array $deps = array(), $ver = false, string $media = 'all')
    {
        \wp_enqueue_style($handle, $src, $deps, $ver, $media);
    }


    public function enqueueScript(string $handle, string $src = '', array $deps = array(), $ver = false, bool $in_footer = false, bool $async = false, bool $defer = false)
    {
        \wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
        \wp_script_add_data($handle, 'async', $async);
        \wp_script_add_data($handle, 'defer', $defer);
    }

}