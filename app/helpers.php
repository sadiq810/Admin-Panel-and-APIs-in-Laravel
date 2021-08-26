<?php

if (! function_exists('numberToArabic')) {
    function numberToArabic($number) {
        try {
            $arabic = ['۰', '۱', '٢', '۳', '٤', '٥', '٦', '٧', '٨', '٩'];
            $english = [ 0 ,  1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 ];

            return str_replace($english, $arabic, $number);
        } catch (Exception $exception) {
            return $number;
        }//.... end of try-catch() .....//
    }//..... end of numberToArabic() .....//
}//...... end if() ......//


if (! function_exists('numberToFarsi')) {
    function numberToFarsi($number) {
        try {
            $farsi = ['۰', '۱', '٢', '۳', '۴', '۵', '۶', '٧', '٨', '٩'];
            $english = [ 0 ,  1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 ];

            return str_replace($english, $farsi, $number);
        } catch (Exception $exception) {
            return $number;
        }//.... end of try-catch() .....//
    }//..... end of numberToArabic() .....//
}//...... end if() ......//

if (! function_exists('convertNumberInString')) {
    function convertNumberInString($text = '', $lang_id = 0) {
        // 1: ar, 2: fa, you may check in language table.

        if (! in_array($lang_id, [1, 2]))
            return $text;

        try {
            preg_match_all('/\d+/', $text, $matches);

            $digits = [];

            foreach ($matches[0] as $number) {
                $digits[] = (int) $number;
            }

            arsort($digits);

            foreach ($digits as $num) {
                $n = $lang_id == 1 ? numberToArabic($num): ($lang_id == 2 ? numberToFarsi($num): $num);
                $text = str_replace($num, $n, $text);
            }

            return $text;
        } catch (Exception $exception) {
            return $text;
        }//.... end of try-catch() .....//
    }//..... end of numberToArabic() .....//
}//...... end if() ......//
