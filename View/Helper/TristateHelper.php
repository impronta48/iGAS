<?php
App::uses('AppHelper', 'View/Helper');

class TristateHelper extends AppHelper {
    
    //get the value of a query string value in form of a threestate
    public function get($field)
        {        
            if (isset($this->request->query[$field]))
            { 
                if ($this->request->query($field))
                {
                    return 'checked';                 
                } 
                else
                { 
                    return ''; 

                }
            }
            return 'indeterminate="indeterminate"';
        }
 
    public function checked($field, $value)
    {
            if (isset($this->request->query[$field]))
            { 
                if ($this->request->query($field) == $value)
                {
                    return 'checked';                 
                }              
            }                    
    }   
}