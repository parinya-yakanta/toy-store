<?php

namespace App\Helpers;

class GoToHelper
{
    public static function warning(?string $message = null, string $to = 'back', $parameter = [])
    {
        flash()->addWarning($message);
        if($to !== 'back') {
            return redirect()->route($to, $parameter);
        }
        return back();
    }

    public static function error(?string $message = null)
    {
        flash()->addError($message);
        return back()->withInput()->withErrors($message ?? 'Something went wrong');
    }

    public static function success(?string $message = null, string $to = 'back', $parameter = [])
    {
        flash()->addSuccess($message);
        if($to !== 'back') {
            return redirect()->route($to, $parameter);
        }
        return back();
    }

    public static function info(?string $message = null, string $to = 'back', $parameter = [])
    {
        flash()->addInfo($message);
        if($to !== 'back') {
            return redirect()->route($to, $parameter);
        }
        return back();
    }

    public static function exceptionCatch($e)
    {
        error_log($e->getMessage());
    }

    public static function validator($validator, ?string $message = null)
    {
        flash()->addWarning($message ?? (string) $validator->messages()->first());
        error_log($validator->errors());
        return back()->withInput()->withErrors($validator->errors());
    }
}
