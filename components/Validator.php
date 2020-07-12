<?php

namespace app\components;

class Validator{

    private $_errors = [];

    public function validate($src, $rules = [] ){

        foreach($src as $item => $item_value){
            if(key_exists($item, $rules)){
                foreach($rules[$item] as $rule => $rule_value){

                    if(is_int($rule))
                         $rule = $rule_value;

                    switch ($rule){
                        case 'required':
                        if(empty($item_value) && $rule_value){
                            $this->addError($item, 'Поле не должно быть пустым');
                        }
                        break;

                        case 'minLen':
                        if(strlen($item_value) < $rule_value){
                            $this->addError($item, 'Минимальное количество символов: '.$rule_value);
                        }       
                        break;

                        case 'maxLen':
                        if(strlen($item_value) > $rule_value){
                            $this->addError($item, 'Максимальное количество символов: '.$rule_value);
                        }
                        break;

                        case 'email':
                        if(!preg_match("|^([a-z0-9_.-]{1,20})@([a-z0-9.-]{1,20}).([a-z]{2,4})|is", strtolower($item_value))){
                            $this->addError($item, 'E-mail введён неправильно');
                        }
                    }
                }
            }
        }    

        if(empty($this->_errors)) return true;
        return false; 

    }

    private function addError($item, $error){
        if(empty($this->_errors[$item])) $this->_errors[$item] = '<p class="mb-0">' . $error . '</p>';
            else $this->_errors[$item] .= '<p class="mb-0">' . $error . '</p>';
    }


    public function getErrors(){
        if(empty($this->_errors)) return false;
        return $this->_errors;
    }
}