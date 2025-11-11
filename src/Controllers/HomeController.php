<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return $this->view('home');
    }
}