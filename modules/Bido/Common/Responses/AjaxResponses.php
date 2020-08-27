<?php

namespace Bido\Common\Responses;

use Illuminate\Http\Response;

class AjaxResponses
{
    public static function successResponse()
    {
        return response()->json(['message' => 'عملیات با موفقیت انجام شد.'], Response::HTTP_OK);
    }

    public static function failResponse()
    {
        return response()->json(['message' => 'عملیات با شکست مواجهه شد.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}