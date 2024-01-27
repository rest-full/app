<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this Template file, choose Tools | Templates
 * and open the Template in the editor.
 */

namespace App\View;

use Restfull\View\BaseView;

/**
 *
 */
class AppView extends BaseView
{

    /**
     * @return AppView
     */
    public function initialize(): AppView
    {
        parent::initialize();
        $this->identifyDatasLayout();
        return $this;
    }

}
