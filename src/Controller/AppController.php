<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this Template file, choose Tools | Templates
 * and open the Template in the editor.
 */

namespace App\Controller;

use Restfull\Controller\BaseController;
use Restfull\Error\Exceptions;
use Restfull\Event\Event;

/**
 *
 */
class AppController extends BaseController
{

    /**
     * @return AppController
     * @throws Exceptions
     */
    public function initialize(): AppController
    {
        parent::initialize();
        $this->loadComponents('Flash');
        $this->settingTrueOrFalseToUseTheModel(true);
        return $this;
    }

    /**
     * @param Event $event
     * @return AppController
     */
    public function beforeFilter(Event $event): AppController
    {
        $this->set('title', 'Rest-Full App');
        $this->set('icon', 'favicons' . DS . 'favicon.png');
        return $this;
    }

}
