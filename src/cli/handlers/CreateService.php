<?php

namespace Mimicry\Cli\Handlers;

class CreateService {

    public function __construct()
    {
    }


    public function init($arguments, $options)
    {
        $newFile = 'app/' . $arguments['name'] . '.php';

        if (file_exists($newFile))
            return "File already exists";

        $handle = fopen($newFile, 'w') or die('Cannot open file:  ' . $newFile);
        $data = file_get_contents(dirname(__FILE__) . '/../stubs/service.php');
        fwrite($handle, $data);
        fclose($handle);

        return null;
    }

}