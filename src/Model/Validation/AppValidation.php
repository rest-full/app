<?php

namespace App\Model\Validation;

use Restfull\ORM\Validation\BaseValidation;

/**
 * Description of AppValidation
 *
 * @package App\Model\Validation
 */
class AppValidation extends BaseValidation
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        return $this;
    }

    /**
     * @return AppValidation
     */
    public function validations(): AppValidation
    {
        $keysRules = array_keys(
            $this->typeQuery == 'create' ? $this->rules : $this->data
        );
        $count = count($keysRules);
        for ($a = 0; $a < $count; $a++) {
            $valueRule = $keysRules[$a];
            if (strlen($valueRule) > 2 && substr($valueRule, 0, 2) === 'id') {
                $valueRule = substr($valueRule, 0, 2);
            }
            $rules = $this->getRules($keysRules[$a]);
            $continue = true;
            if (in_array('required', $rules) !== false) {
                array_shift($rules);
                $this->required($keysRules[$a]);
                if ($this->check()) {
                    return $this;
                }
            } else {
                if (in_array($keysRules[$a], array_keys($this->data))
                    === false
                ) {
                    $continue = !$continue;
                }
            }
            if ($continue) {
                $this->searchMethod($this, $valueRule, $keysRules[$a]);
                if ($this->check()) {
                    return $this;
                }
                switch ($valueRule) {
                    case "email":
                        $this->array($keysRules[$a])->email($keysRules[$a])->equals(
                            $keysRules[$a]
                        );
                        break;
                    case "number":
                    case "id":
                        $this->numeric($keysRules[$a]);
                        break;
                    case "float":
                        $this->float($keysRules[$a]);
                        break;
                    case "date":
                        $this->date($keysRules[$a]);
                        break;
                    case "time":
                        $this->time($keysRules[$a]);
                        break;
                    case "datetime":
                        $this->date($keysRules[$a])->time($keysRules[$a]);
                        break;
                    case "file":
                        $this->url($keysRules[$a])->file($keysRules[$a]);
                        break;
                    default:
                        if ($this->search) {
                            $this->string($keysRules[$a])->alphaNumeric(
                                $keysRules[$a]
                            )->search(
                                $keysRules[$a],
                                $this->words
                            );
                            $this->search = false;
                        }
                        break;
                }
            }
        }
        return $this;
    }

}
