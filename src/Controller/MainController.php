<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this Template file, choose Tools | Templates
 * and open the Template in the editor.
 */

namespace App\Controller;

/**
 * Description of MainController
 * @package App\Controller
 */
class MainController extends AppController
{

    /**
     *
     */
    public function index(): void
    {
        $this->Flash->info('This framework check all available components.');
        $this->set(
            'icons',
            [
                'database' => $this->checkDatabase ? 'connected' : 'disconnected',
                'version' => version_compare(PHP_VERSION, '7.2.0', '>=') ? 'connected' : 'disconnected',
                'encrypt' => $this->encrypting ? 'connected' : 'disconnected',
                'extensions' => extension_loaded('mbstring') && extension_loaded(
                    'intl'
                ) ? 'connected' : 'disconnected',
                'email' => $this->activeHelpers['email'] ? 'connected' : 'disconnected',
                'pdf' => $this->activeHelpers['pdf'] ? 'connected' : 'disconnected',
            ]
        );
        return;
    }

}
