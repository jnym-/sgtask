<?php

namespace App\Http\Controllers;

use App\HomeOwners\Import\CsvImporter;
use App\Http\Requests\CsvUploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class HomeOwnerImportsController extends Controller
{
    public function __construct(
        protected CsvImporter $csvImporter
    ) {

    }

    public function store(CsvUploadRequest $request): JsonResponse
    {
        /** @var UploadedFile $csv */
        $csv = $request->validated()['csv'];

        return response()->json([
            'names' => $this->csvImporter->import($csv),
        ]);
    }
}
