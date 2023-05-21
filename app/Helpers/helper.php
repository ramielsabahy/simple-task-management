<?php

if (!function_exists('customResponse')) {

    function customResponse($data = [], $message = "", $code = 200)
    {
        return response()->json([
            'data'  => $data,
            'message'  => $message,
        ], $code);
    }
}
