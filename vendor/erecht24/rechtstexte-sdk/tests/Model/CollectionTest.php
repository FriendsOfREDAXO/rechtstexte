<?php
declare(strict_types=1);

namespace Model;

namespace eRecht24\RechtstexteSDK\Tests\Model;

use eRecht24\RechtstexteSDK\Model\Collection;
use PHPUnit\Framework\TestCase;

final class CollectionTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $collection = new Collection();
        $this->assertInstanceOf(
            Collection::class,
            $collection
        );
    }

    public function testCanDetectEmptyCollection(): void
    {
        $collection = new Collection();
        $this->assertSame(true, $collection->isEmpty());

        $collection = new Collection([1, 2]);
        $this->assertSame(false, $collection->isEmpty());
    }

    public function testCanCountElements(): void
    {
        $collection = new Collection();
        $this->assertSame(0, $collection->count());

        $collection = new Collection([1, 2]);
        $this->assertSame(2, $collection->count());
    }

    public function testCanGetAllElements(): void
    {
        $array = ["car", "bike", "train"];
        $collection = new Collection($array);
        $this->assertSame($array, $collection->all());
    }

    public function testCanFindElement(): void
    {
        $collection = new Collection(["car", "bike", "train"]);
        $this->assertSame("bike", $collection->get(1));
    }

    public function testCanAddElement(): void
    {
        $collection = new Collection();
        $collection->add("new");
        $this->assertSame(1, $collection->count());
        $this->assertSame("new", $collection->get(0));
    }

    public function testCanPushElement(): void
    {
        $collection = new Collection();
        $collection->push("new", "also new");
        $this->assertSame(2, $collection->count());
        $this->assertSame("new", $collection->get(0));
        $this->assertSame("also new", $collection->get(1));
    }
}