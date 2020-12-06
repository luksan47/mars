<?php

namespace App\Http\Controllers\Secretariat;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    public function list()
    {
        $this->authorize('viewAny', DocumentRequest::class);

        $requests = DocumentRequest::all()->sortBy('date_of_request')->reverse();

        return view('secretariat.document.list', ['requests' => $requests]);
    }

    public function save_request($request_name)
    {
        $user = Auth::user();

        $requestData = [
            'name' => $user->name,
            'neptun' => $user->educationalInformation->neptun ?? '',
            'document_type' => $request_name,
            'date_of_request' => Carbon::now(),
        ];
        DocumentRequest::create($requestData);

        return back();
    }
}
