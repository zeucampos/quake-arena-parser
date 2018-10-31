<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\ReaderService;

class IndexController extends Controller
{
    protected $service;

    public function __construct(ReaderService $service)
    {
        $this->service = $service;
    }

    // Index view
    public function index()
    {
        $document = $this->service->storeContent();
        return $document;
    }
}
