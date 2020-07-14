<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/26/2017
 * Time: 4:22 PM
 */


function themeUrl($path)
{
    $themeFolder = 'themes';
    $themeName = 'default';
    return url('/public/' . $themeFolder . '/' . $themeName . '/' . $path);
}