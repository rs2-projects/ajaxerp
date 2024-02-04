<?php

namespace App\Helpers;
use App\Models\Accounting\AccCoaAccount;
use Illuminate\Support\Str;

class MakeSlugHelper
{
    private static $makeSlugNumber = 1;

    public static function makeAccCoaAccountSlug($string)
    {
        $slug = Str::slug($string, '-');
        $main_slug = $slug;
        do {
            $find = AccCoaAccount::where('slug', $slug)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (!empty($find)) {
                $slug = Str::slug($main_slug.(self::$makeSlugNumber++), '-');
            }

        } while(!empty($find));

        return $slug;
    }


}
