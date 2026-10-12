<?php

namespace Tests\Unit;

use App\Models\Package;
use PHPUnit\Framework\TestCase;

class PackagePriceParserTest extends TestCase
{
    public function test_it_parses_common_indonesian_price_formats(): void
    {
        $this->assertSame(28500000.0, Package::parsePrice('28.5 jt'));
        $this->assertSame(28500000.0, Package::parsePrice('28,5 juta'));
        $this->assertSame(28500000.0, Package::parsePrice('Rp 28.500.000'));
        $this->assertSame(28500000.0, Package::parsePrice('28500000'));
    }

    public function test_empty_price_returns_zero(): void
    {
        $this->assertSame(0.0, Package::parsePrice(null));
        $this->assertSame(0.0, Package::parsePrice(''));
    }
}
