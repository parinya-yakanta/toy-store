<?php

namespace App\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CommonHelper
{
    public static function saveImage($file, string $path, int $key, $returnLink = false)
    {
        $storage = env('PATH_STORAGE_IMAGE', 'dev')."/$path";
        $dateformat = now()->format('HisYmd');
        $name = "$dateformat$key.".$file->extension();

        if ($file) {

            $image = Image::make($file->getRealPath())->orientate();
            $img_width = $image->width();
            if ($img_width > 1300) {
                $image->resize(1300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $storageDisk = Storage::disk()->put(
                "$storage/$name",
                $image->encode($file->extension(), 60),
                'public'
            );

            if ($storageDisk) {
                if ($returnLink) {
                    return Storage::disk()->url("$storage/$name");
                } else {
                    return "$storage/$name";
                }
            }
        }

        return null;
    }

    public static function saveFile($file, string $path, int $key = 0)
    {
        $storage = env('PATH_STORAGE_IMAGE', 'images')."/$path";
        $dateformat = now()->format('Hisymd');
        $name = "$path$dateformat$key.".$file->extension();

        if ($file) {

            $disk = Storage::disk()->putFileAs(
                $storage,
                $file,
                $name,
                'public'
            );

            Storage::disk()->url(
                $disk
            );

            return "$storage/$name";
        }

        return null;
    }

    public static function removeFile($link)
    {
        if ($link) {
            $path = self::getImage($link);
            if (Storage::disk()->exists($path)) {
                Storage::disk()->delete($path);
            }
        }
    }

    public static function getImage($link = null)
    {
        if ($link != null) {
            return Storage::disk()->url($link);
        }

        return null;
    }

    public static function paginate(Collection $results, $showPerPage)
    {
        $pageNumber = Paginator::resolveCurrentPage('page');

        $totalPageNumber = $results->count();

        return self::paginator($results->forPage($pageNumber, $showPerPage), $totalPageNumber, $showPerPage, $pageNumber, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items',
            'total',
            'perPage',
            'currentPage',
            'options'
        ));
    }

    public static function getMonthName($month)
    {
        $monthName = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $monthName[$month];
    }

    public static function getMonthNameThai($month)
    {
        $month = (int) $month;
        $monthName = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];

        return $monthName[$month];
    }
}
