<?php

use Intervention\Image\ImageManagerStatic as Image;

class Photo
{
    public static $name;

    public static function upload($file, $path, $prefix, $size = [], $disable = true)
    {
        if (file_exists(public_path($path))) {
            try {
                $extension = $file->getClientOriginalExtension();
                $name = $prefix . rand(1, 2000) . rand(1, 500) . '-' . date('dmy') . '.' . $extension;

                if (count($size) == 2) {
                    Image::make($file)->resize($size[0], $size[1])->save(public_path($path . '/' . $name));
                } else {
                    Image::make($file)->save(public_path($path . '/' . $name));
                }

                if ($disable) {
                    $previewName = 'preview-' . $name;
                    $image = Image::make($file);

                    if (count($size) == 2) {
                        $image->resize(intval($size[0] * 0.25), intval($size[1] * 0.25));
                    } else {
                        $image->resize(intval($image->width() * 0.25), intval($image->height() * 0.25));
                    }

                    $image->encode('jpg', 30);
                    $image->save(public_path($path . '/' . $previewName));
                }

                self::$name = $name;
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }
        return false;
    }

    public static function delete($path, $file)
    {
        if (file_exists(public_path($path))) {
            try {
                unlink(public_path($path . '/' . $file));
                unlink(public_path($path . '/' . 'preview-' . $file));
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }
        return false;
    }
}
