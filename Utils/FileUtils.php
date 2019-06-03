<?php

namespace Zakjakub\OswisCoreBundle\Utils;

class FileUtils
{

    final public static function humanReadableFileUploadMaxSize(): string
    {
        return self::humanReadableBytes(self::fileUploadMaxSize());
    }

    final public static function humanReadableBytes(int $bytes, int $decimals = 2, string $system = 'binary'): string
    {
        $mod = ($system === 'binary') ? 1024 : 1000;

        $units = array(
            'binary' => array(
                'B',
                'KiB',
                'MiB',
                'GiB',
                'TiB',
                'PiB',
                'EiB',
                'ZiB',
                'YiB',
            ),
            'metric' => array(
                'B',
                'kB',
                'MB',
                'GB',
                'TB',
                'PB',
                'EB',
                'ZB',
                'YB',
            ),
        );

        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f %s", $bytes / ($mod ** $factor), $units[$system][$factor]);
    }

    final public static function fileUploadMaxSize(): int
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = self::parseSize(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            $upload_max = self::parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }

    final public static function parseSize(string $size): int
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * (1024 ** stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }

}
