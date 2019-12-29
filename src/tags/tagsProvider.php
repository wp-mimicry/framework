<?php

namespace Mimicry\Tags;

use Illuminate\Config\Repository;

class tagsProvider {

    public function boot(Repository $config)
    {
        $tagFiles = glob($this->getTagsDir($config) . "/*.php");

        foreach ($tagFiles as $tagFile) {
            require_once $tagFile;
        }
    }


    private function getTagsDir($config): String
    {
        $tagsDir = $config->get('tags_dir_path');

        $tagDir = \theme_path() . trim($tagsDir, '/') . "/";

        if (!is_dir($tagDir))
            \wp_die("Tags dir does not exist! Please check the 'tags_dir_path' config setting! '{$tagDir}'");

        return $tagDir;
    }

}