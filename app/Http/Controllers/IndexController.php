<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\ReaderService;

class IndexController extends Controller
{
    protected $reader;

    public function __construct(ReaderService $reader)
    {
        $this->reader = $reader;
    }

    // Index view
    public function index()
    {
        $document = $this->reader->storeContent();

        return $document;
    }
}
