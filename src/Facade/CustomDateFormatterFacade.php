<?php
 namespace Larasoft\PasswordExpiry\Facade;

 use Illuminate\Support\Facades\Facade;

 class CustomDateFormatterFacade extends Facade {

     /**
      * Get the registered name of the component.
      *
      * @return string
      */
     protected static function getFacadeAccessor()
     {
         return 'CustomDateFormatterFacade';
     }

 }