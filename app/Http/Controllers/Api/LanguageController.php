<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageCollection;
use App\Repository\LanguageRepository;

class LanguageController extends Controller
{
    /**
     * @return LanguageCollection
     * Get languages list.
     */
    public function index(): LanguageCollection
    {
        return (new LanguageRepository())->list();
    }//..... end of index() .....//
}
