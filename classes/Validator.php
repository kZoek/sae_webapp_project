<?php
class Validator{

    protected $errorHandler;

    protected $rules = ['required','minlenght','maxlenght','email','alnum'];

    public $messages = [
        'required' => 'The :field field is required',
        'minlenght' => 'The :field field must be a minimum of :satisifer lenght',
        'maxlenght' => 'The :field field must be a maximum of :satisifer lenght',
        'email' => 'Please enter a valid email address',
        'alnum' => 'User must contain only letters and numbers',
        'match' => 'The :field field must match the :satisifer field',
    ];
    // construct with errorHandler dependency
    public function __construct(ErrorHandler $errorHandler){
        $this->errorHandler = $errorHandler;
    }
    // declare rules and inputs in array
    public function check($items, $rules){
        foreach($items as $item => $value){
            if(in_array($item, array_keys($rules) )){
                $this->validate([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item]
                ]);
            }
        }
        return $this;
    }
    // returns a boolean, got the input an errormessage or not
    public function fails(){
        return $this->errorHandler->hasErrors();
    }
    // return an errorhandler object, to show errors
    public function errors(){
        return $this->errorHandler;
    }
    // stucture to validate inputs, with chosen rules
    protected function validate($item){
        $field = $item['field'];
        foreach($item['rules'] as $rule => $satisifer){
            if( in_array($rule, $this->rules) ){
                // echo $rule .'<br>';
                if(!call_user_func_array( [$this, $rule ], [ $field, $item['value'], $satisifer ] )){
                    $this->errorHandler->addError(
                        str_replace([':field',':satisifer'],[$field,$satisifer],$this->messages[$rule]),
                        $field);
                }
            }
        }
    }
    // functions based on validatation Rules
    protected function required($field,$value,$satisifer){
        if(!empty(trim($value))){
            filter_var($value, FILTER_SANITIZE_STRING);
            strip_tags($value);
           return htmlspecialchars($value);
        }
    }

    protected function minlenght($field,$value,$satisifer){
        return mb_strlen( $value ) >= $satisifer;
    }

    protected function maxlenght($field,$value,$satisifer){
        return mb_strlen( $value ) <= $satisifer;
    }

    protected function email($field,$value,$satisifer){
        return filter_var($value,FILTER_VALIDATE_EMAIL);
    }

    protected function alnum($field,$value,$satisifer){
        return ctype_alnum($value);
    }
    protected function match($field,$value,$satisifer){
        return $value == $this->items[$satisifer];
    }
}
