<?php

namespace App\Http\Controllers;

use \App\Services\ReaderService;
use App\Http\Services\PlayerService;
use App\Player;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    protected $reader;
    protected $playerService;

    public function __construct(ReaderService $reader, PlayerService $playerService)
    {
        $this->playerService = $playerService;
        $this->reader = $reader;
    }

    // Index view
    public function index(Request $request)
    {
        // $this->reader->storeContent();
        $ranking = $this->playerService->index($request->all());

        return view('index', compact('ranking'));
    }
}
