<?php

namespace Tests\Unit;

use App\HomeOwners\Import\NameNormaliser;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class NameNormaliserTest extends TestCase
{
    protected NameNormaliser $normaliser;

    public function setUp(): void
    {
        parent::setUp();

        $this->normaliser = new NameNormaliser;
    }

    public function test_it_normalises_one_3_part_name(): void
    {
        $normalised = $this->normaliser->normalise('Mr John Smith');

        $this->assertCount(1, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1] = $normalised;

        $this->assertSame('Mr', $name1['title']);
        $this->assertSame('John', $name1['first_name']);
        $this->assertNull($name1['initial']);
        $this->assertSame('Smith', $name1['last_name']);
    }

    public function test_it_normalises_one_3_part_name_using_initial(): void
    {
        $normalised = $this->normaliser->normalise('Mr J Smith');

        $this->assertCount(1, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1] = $normalised;

        $this->assertSame('Mr', $name1['title']);
        $this->assertNull($name1['first_name']);
        $this->assertSame('J', $name1['initial']);
        $this->assertSame('Smith', $name1['last_name']);
    }

    public function test_it_normalises_one_2_part_name(): void
    {
        $normalised = $this->normaliser->normalise('Mr Smith');

        $this->assertCount(1, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1] = $normalised;

        $this->assertSame('Mr', $name1['title']);
        $this->assertNull($name1['first_name']);
        $this->assertNull($name1['initial']);
        $this->assertSame('Smith', $name1['last_name']);
    }

    public function test_it_normalises_two_3_part_names(): void
    {
        $normalised = $this->normaliser->normalise('Mr John Smith and Mrs Jane Doe');

        $this->assertCount(2, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1, $name2] = $normalised;

        $this->assertSame('Mr', $name1['title']);
        $this->assertSame('John', $name1['first_name']);
        $this->assertNull($name1['initial']);
        $this->assertSame('Smith', $name1['last_name']);

        $this->assertSame('Mrs', $name2['title']);
        $this->assertSame('Jane', $name2['first_name']);
        $this->assertNull($name2['initial']);
        $this->assertSame('Doe', $name2['last_name']);
    }

    public function test_it_normalises_two_combined_names(): void
    {
        $normalised = $this->normaliser->normalise('Dr & Mrs Joe Bloggs');

        $this->assertCount(2, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1, $name2] = $normalised;

        $this->assertSame('Dr', $name1['title']);
        $this->assertSame('Joe', $name1['first_name']);
        $this->assertNull($name1['initial']);
        $this->assertSame('Bloggs', $name1['last_name']);

        $this->assertSame('Mrs', $name2['title']);
        $this->assertNull($name2['first_name']);
        $this->assertNull($name2['initial']);
        $this->assertSame('Bloggs', $name2['last_name']);
    }

    public function test_it_normalises_two_two_part_names(): void
    {
        $normalised = $this->normaliser->normalise('Mrs & Prof Bloggs');

        $this->assertCount(2, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1, $name2] = $normalised;

        $this->assertSame('Mrs', $name1['title']);
        $this->assertNull($name1['first_name']);
        $this->assertNull($name1['initial']);
        $this->assertSame('Bloggs', $name1['last_name']);

        $this->assertSame('Prof', $name2['title']);
        $this->assertNull($name2['first_name']);
        $this->assertNull($name2['initial']);
        $this->assertSame('Bloggs', $name2['last_name']);
    }

    public function test_it_normalises_three_names(): void
    {
        $normalised = $this->normaliser->normalise('Mrs & Prof Bloggs + Mr J. Appleseed');

        $this->assertCount(3, $normalised);
        $this->assertInstanceOf(Collection::class, $normalised);

        [$name1, $name2, $name3] = $normalised;

        $this->assertSame('Mrs', $name1['title']);
        $this->assertNull($name1['first_name']);
        $this->assertNull($name1['initial']);
        $this->assertSame('Bloggs', $name1['last_name']);

        $this->assertSame('Prof', $name2['title']);
        $this->assertNull($name2['first_name']);
        $this->assertNull($name2['initial']);
        $this->assertSame('Bloggs', $name2['last_name']);

        $this->assertSame('Mr', $name3['title']);
        $this->assertNull($name3['first_name']);
        $this->assertSame('J', $name3['initial']);
        $this->assertSame('Appleseed', $name3['last_name']);
    }
}
