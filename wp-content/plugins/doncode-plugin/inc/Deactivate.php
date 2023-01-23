<?php

/**
 * @package Custome Post Type Plugin
 * @version 1.0
 */

 namespace Inc;
class Deactivate
{

    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}
