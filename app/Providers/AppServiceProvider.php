<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //Regla validacion - patron Cedula Venezuela V-20527745 V-20527745-1 E-20527745 V-20527745-1
        $this->app->validator->extendImplicit('cedula', function ($attribute, $value, $parameters) {
            $patron = "/^(V|E|v|e){1}(-){1}([0-9]){1,8}(-[1-9]\d?)?$/";
            return preg_match($patron, $value);
        }, 'Cedula invalida. Ingrese el Formato Requerido.');

        //Regla validacion - Longitud de telefono
        $this->app->validator->extendImplicit('telefono', function ($attribute, $value, $parameters) {
            if (trim(strlen($value)) == 11) return true;
        }, 'Longitud de telefono es 11');

        //Validando Edad Inicial mayor a Final
        $this->app->validator->extendImplicit('compareAgeIniFin', function ($attribute, $value, $parameters) {
            if ($value >= $parameters[0]) return false;
            return true;
        }, 'Edad Inicial es Mayor o igual a Edad Final');

        //Comparando Edad Final menor a Inicial
        $this->app->validator->extendImplicit('compareAgeFinIni', function ($attribute, $value, $parameters) {
            if ($value <= $parameters[0]) return false;
            return true;
        }, 'Edad Final es Menor o igual a Edad Inicial');

        //validar dato float (monto)
       $this->app->validator->extend('float', function($attribute, $value)
        {
            if ($value == null) return true;
            if(!filter_var($value, FILTER_VALIDATE_FLOAT) == true || substr($value, 0,1) == '-') return false;

            return true;
        });

       //fechas iguales
        $this->app->validator->extendImplicit('compareDate', function ($attribute, $value, $parameters) {
            $date_1 = \Carbon\Carbon::parse($value)->format('Y-m-d');
            $date_2 = \Carbon\Carbon::parse($parameters[0])->format('Y-m-d');
            if ($date_1 == $date_2) return true;
        }, 'Fechas deben ser iguales');

        //Compare Hora
        $this->app->validator->extendImplicit('compareHoraInicio', function ($attribute, $value, $parameters) {
            $hora_1 = \Carbon\Carbon::parse($value)->format('H:i');
            $hora_2 = \Carbon\Carbon::parse($parameters[0])->format('H:i');
            if ($hora_1 < $hora_2 && $hora_1 != $hora_2) return true;
        }, 'Hora Entraba debe ser diferente y menor a Hora Salida.');

        //Compare Hora
        $this->app->validator->extendImplicit('compareHoraSalida', function ($attribute, $value, $parameters) {
            $hora_1 = \Carbon\Carbon::parse($value)->format('H:i');
            $hora_2 = \Carbon\Carbon::parse($parameters[0])->format('H:i');
            if ($hora_1 > $hora_2 && $hora_2 != $hora_1) return true;
        }, 'Hora Salida debe ser diferente y mayor a Hora Entrada.');
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
