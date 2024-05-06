<?php

namespace App\HomeOwners\Import;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use League\Csv\Reader;

class CsvImporter
{
    public function __construct(
        protected NameNormaliser $nameNormaliser
    ) {

    }

    /**
     * @return Collection<int, array<string, string|null>>
     */
    public function import(UploadedFile $file): Collection
    {
        $file = Reader::createFromPath($file->getPathName());
        $file->setHeaderOffset(0);

        $names = new Collection;

        foreach ($file->getRecords() as $record) {
            /** @var string $name */
            $name = $record[$file->getHeader()[0]];
            $names = $names->merge($this->nameNormaliser->normalise($name));
        }

        return $names;
    }
}
