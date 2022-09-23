<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SpaController extends Controller
{
    /**
     * Получение основного шаблона приложения
     *
     * @return View
     */
    public function index(): View
    {
        return view('spa');
    }
}
