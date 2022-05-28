<?php

namespace VittITServices\humhub\modules\gallery\helpers;


/**
 * Class Url
 */
class URL extends \yii\helpers\Url
{
    const ROUTE_SPACE_SETTINGS = '/gallery/space';
    const ROUTE_MODIFIED_STREAM_ACTION = '/gallery/space/photostream';
    const ROUTE_ADMIN = '/gallery/admin';

    function domainname()
    {
        return URL::base(true);
    }

    public static function toSpaceSettings()
    {
        return static::ROUTE_SPACE_SETTINGS;
    }

    public static function toModifiedStreamAction()
    {
        return static::ROUTE_MODIFIED_STREAM_ACTION;
    }

    // public static function toSpaceWithMessage(string $baseurl, string $message)
    // {
    //     return static::to([$baseurl . static::ROUTE_SPACE, 'message' => $message]);
    // }

    public static function toAdmin()
    {
        return static::to([static::ROUTE_ADMIN]);
    }
}
