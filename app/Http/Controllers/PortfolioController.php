<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('welcome'); // or 'portfolio' depending on your view file name
    }

    public function downloadResume()
    {
        $filePath = public_path('documents/resume.pdf');

        if (file_exists($filePath)) {
            return response()->download($filePath, 'Resume.pdf');
        }

        abort(404, 'Resume file not found.');
    }
}