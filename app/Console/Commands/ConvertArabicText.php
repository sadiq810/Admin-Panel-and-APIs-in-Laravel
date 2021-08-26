<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;

class ConvertArabicText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:Plain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command is use to convert arabic text to plain text !';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('process of converting arabic text to plain text start........');
        $res = Content::where('language_id', '=', 1)->get();
        foreach ($res as $k => $val) {
            $text =$this->plainTextConverter($val->content);
            echo $text;exit;
            $val->update(['plain_text' => $text]);
        }
        $this->info(count($res) . ' records successfully updated');
    }

    public function plainTextConverter($text)
    {
        $unicode = [
            "~[\x{0600}-\x{061F}]~u",
            "~[\x{063B}-\x{063F}]~u",
            "~[\x{064B}-\x{065E}]~u",
            "~[\x{066A}-\x{06FF}]~u",
            "~[\x{066A}-\x{06FF}]~u",
        ];

        return preg_replace($unicode, "", $text);
      /*  $diacritic = array('ِ', 'ُ', 'ٓ', 'ٰ', 'ْ', 'ٌ', 'ٍ', 'ً', 'ّ', 'َ');
        return str_replace($diacritic, '', $text);*/
    }
}
