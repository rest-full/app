<?php

namespace App\Controller;

use Restfull\Event\Event;

/**
 *
 */
class FlashController extends AppController
{

    /**
     * @param Event $event
     *
     * @return FlashController
     */
    public function beforeFilter(Event $event): FlashController
    {
        $this->Auth->pages([strtolower($this->name) => ['handler']]);
        $this->notORM = ['handler'];
        parent::beforeFilter($event);
        return $this;
    }

    /**
     *
     */
    public function handler(): void
    {
        $flash = $this->Flash->returnOfAllText();
        $newFlash = [];
        foreach ($this->Flash->msgTypes() as $keyType => $type) {
            if (stripos($this->route, $type) !== false) {
                if (count($flash[$keyType]) > 0) {
                    $count = count($flash[$keyType]);
                    for ($a = 0; $a < $count; $a++) {
                        $text = $flash[$keyType][$a];
                        if (!isset($newFlash[$keyType]) || in_array($text, $newFlash[$keyType]) !== false) {
                            $newFlash[$keyType][] = $text;
                        }
                    }
                    $count = count($newFlash[$keyType]);
                    for ($a = 0; $a < $count; $a++) {
                        $this->Flash->{$type}($newFlash[$keyType][$a]);
                    }
                }
            }
        }
        $this->layout = 'notExist';
        return;
    }
}