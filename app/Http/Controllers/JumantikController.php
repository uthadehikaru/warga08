<?php

namespace App\Http\Controllers;

use App\Models\Jumantik;

class JumantikController extends Controller
{
    /**
     * Display the submitted jumantik report.
     */
    public function __invoke($id)
    {
        $data['jumantik'] = Jumantik::findOrFail($id);

        return view('jumantik.show', $data);
    }
}
