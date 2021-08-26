<?php


namespace App\Repository;


use App\Models\Language;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Repository
{
    /**
     * @return mixed
     * Get current language details.
     */
    public function getLanguage()
    {
        return Language::where('code', app()->getLocale())->first();
    }//.... end of getLanguage() .....//

    /**
     * @return mixed
     * Get current language details.
     */
    public function getLanguageByCode($code = null)
    {
        if (!$code)
            $code = app()->getLocale();

        return Language::where('code', $code)->first();
    }//.... end of getLanguage() .....//

    /**
     * @param string $str
     * @return string
     * Clean text, remove html entities.
     */
    public function cleanText($str = ''): string
    {
        return Str::limit(trim(str_replace('&nbsp;', '', strip_tags($str))), 160);
    }

    /**
     * @param $file
     * remove file.
     */
    public function removeFile($file)
    {
        unlink(public_path('uploads/'.$file));
    }

    /**
     * @param string $file
     * @param false $resize
     * @param int $width
     * @param int $height
     * @return string
     * Upload image.
     */
    public function uploadImage($file = '', $resize = false, $width = 518, $height = 250)
    {

        $imageName = time() . '.' . $file->getClientOriginalExtension();

        if (Str::of($imageName)->contains(['jpg', 'jpeg', 'png'])) {
            $image = Image::make($file);

            if ($resize)
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            $image->save(public_path('uploads/'.$imageName));
        } else {
            $file->storeAs('uploads', $imageName);
        }//..... end if-else() .....//

        return $imageName;
    }//..... end of uploadImage() .....//
}
