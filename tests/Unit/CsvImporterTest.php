<?php

namespace Tests\Unit;

use App\HomeOwners\Import\CsvImporter;
use App\HomeOwners\Import\NameNormaliser;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class CsvImporterTest extends TestCase
{
    protected CsvImporter $csvImporter;

    public function setUp(): void
    {
        parent::setUp();

        $this->csvImporter = new CsvImporter(new NameNormaliser);
    }

    public function test_it_imports_a_csv(): void
    {
        $csvContent = (string) file_get_contents(__DIR__.'/../fixtures/test-names.csv');
        $file = UploadedFile::fake()->createWithContent('test-names.csv', $csvContent);

        $names = $this->csvImporter->import($file);

        $this->assertCount(8, $names);
    }
}
