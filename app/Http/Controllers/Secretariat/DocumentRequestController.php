<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;

class DocumentRequestController extends Controller
{
    public function list()
    {
        $this->authorize('viewAny', DocumentRequest::class);

        $requests = DocumentRequest::orderBy('created_at', 'desc')->get();

        return view('secretariat.document.list', ['requests' => $requests]);
    }
}
