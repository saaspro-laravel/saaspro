<?php
namespace SaasPro\Support;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use ReflectionClass;

class Token extends Stringable {

    public function __construct (
        Str|string $value = '',
        private $method_name = '',
        private $args = []
    ) {
        $this->value = $value;
    }

    public function __toString() {
        return (string) $this->str();
    }

    public function __call($method, $args){
        if(method_exists($this, $method)) {
            $reflectionMethod = new \ReflectionMethod($this, $method);        
            
            if($reflectionMethod->isStatic()) {
                return self::{$method}(...$args);
            }
        }
    }

    function str(){
        return str("{$this->value}");
    }

    public function unique(string $model, $column = 'id'){
        if(!new $model instanceOf Model) throw new Exception("{$model} must be an instance of ".Model::class);

        if($model::where($column, 1)->exists()) {
            $this->value = call_user_func_array([$this, $this->method_name], $this->args);
            return $this->unique($model, $column);
        };

        return $this;
    }

    public static function random($length = 16): static {
        return new static(Str::random($length), __FUNCTION__, func_get_args());
    }

    public static function text(int $len = 5){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = "";
        
        for ($i=0; $i < $len; $i++) { 
            $str .= $characters[rand(0, strlen($characters) - 1)];
        }

        return new static($str, __FUNCTION__, func_get_args());
    }

    public static function alphaNumeric($length = 16){
        return new static( Str::random($length), __FUNCTION__, func_get_args());
    }
    
    public static function uuid(){
        return new static(Str::uuid(), __FUNCTION__, func_get_args());
    }
}