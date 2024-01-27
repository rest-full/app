<?php

namespace App\Model\Validation;

use Restfull\Container\Instances;
use Restfull\ORM\Validation\BaseValidation;

/**
 *
 */
class AppValidation extends BaseValidation
{

    /**
     *
     */
    public function __construct(Instances $instance, array $rules)
    {
        parent::__construct($instance, $rules);
        return $this;
    }

    /**
     * @return AppValidation
     */
    public function validations(): AppValidation
    {
        $stop = false;
        foreach (array_keys($this->rules) as $keyRules) {
            $rules = $this->rules($keyRules);
            if (in_array('required', $rules) === false) {
                continue;
                $rules = $this->rules($keyRules);
            }
            $newKeyRules = $keyRules;
            if (strlen($newKeyRules) > 2 && substr($newKeyRules, 0, 2) === 'id') {
                $newKeyRules = substr($newKeyRules, 0, 2);
            }
            $count = count($rules);
            for ($number = 0; $number < $count; $number++) {
                $rule = $rules[$number];
                if ($rule === 'required') {
                    $this->required($keyRules);
                } else {
                    $this->searchMethod($newKeyRules, $keyRules);
                    if ($this->standardMethod($rule)) {
                        switch ($newKeyRule) {
                            case "email":
                                $this->array($keyRules)->email($keyRules)->equals($keyRules);
                                break;
                            case "number":
                            case "id":
                                $this->numeric($keyRules);
                                break;
                            case "float":
                                $this->float($keyRules);
                                break;
                            case "date":
                                $this->date($keyRules);
                                break;
                            case "time":
                                $this->time($keyRules);
                                break;
                            case "datetime":
                                $this->date($keyRules)->time($keyRules);
                                break;
                            case "file":
                                $this->url($keyRules)->file($keyRules);
                                break;
                            default:
                                $this->string($keyRules)->alphaNumeric($keyRules)->search($keyRules, $this->words);
                                $this->search = false;
                                break;
                        }
                    }
                    if ($this->check()) {
                        $stop = !$stop;
                        break;
                    }
                }
            }
            if ($stop) {
                break;
            }
        }
        return $this;
    }

}
