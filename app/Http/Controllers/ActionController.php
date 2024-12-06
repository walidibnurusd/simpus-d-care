<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function index()
    {
        $actions = Action::all();
        return view('content.action.index', compact('actions'));
    }
    public function actionReport()
{
    $actions = Action::all(); // Ganti dengan query sesuai kebutuhan
    return view('content.action.print', compact('actions'));
}
}
