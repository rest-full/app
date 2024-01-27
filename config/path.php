<?php

/**
 * Use the DS to separate the directories in other defines
 */
define('DS', "/");

/**
 * Use the DS to separate the directories in other defines
 */
define('DS_REVERSE', '\\');

/**
 *
 */
define('ROOT', dirname(__DIR__) . DS);

/**
 *
 */
define('ROOT_PATH', ROOT . 'webroot' . DS);

/**
 *
 */
define('ROOT_ABSTRACT', ROOT . 'abstraction' . DS);

/**
 *
 */
define('RESTFULL', dirname(__DIR__) . DS . 'src' . DS);