<?php

namespace App\Services;

class ImageCompressor
{
    public function compress(string $path, int $maxEdge = 1600, int $quality = 75): string
    {
        if (! function_exists('imagecreatefromstring') || ! is_file($path)) {
            return $path;
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            return $path;
        }

        $source = @imagecreatefromstring($contents);
        if ($source === false) {
            return $path;
        }

        $orientation = $this->exifOrientation($path);
        $source = $this->applyExifOrientation($source, $orientation);

        $width = imagesx($source);
        $height = imagesy($source);
        $type = @getimagesize($path)[2] ?? null;
        $alreadySmall = $orientation <= 1
            && $width <= $maxEdge
            && $height <= $maxEdge
            && $type === IMAGETYPE_JPEG
            && filesize($path) <= 800 * 1024;

        if ($alreadySmall) {
            imagedestroy($source);

            return $path;
        }

        $scale = min($maxEdge / max($width, 1), $maxEdge / max($height, 1), 1);
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));

        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $background = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $background);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);

        $target = preg_replace('/\.[^.]+$/', '.jpg', $path) ?: $path.'.jpg';
        imageinterlace($canvas, true);
        imagejpeg($canvas, $target, $quality);
        imagedestroy($canvas);

        if ($target !== $path && is_file($path)) {
            unlink($path);
        }

        return $target;
    }

    private function exifOrientation(string $path): int
    {
        if (! function_exists('exif_read_data')) {
            return 1;
        }

        $exif = @exif_read_data($path);

        return (int) (is_array($exif) ? ($exif['Orientation'] ?? 1) : 1);
    }

    private function applyExifOrientation($image, int $orientation)
    {
        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };

        if ($rotated && $rotated !== $image) {
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }
}
