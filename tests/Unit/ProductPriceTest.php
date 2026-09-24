<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductPriceTest extends TestCase
{
    public function test_harga_setelah_diskon_10_persen(): void
    {
        $price = 100000;
        $diskon = $price * 0.10;
        $hargaAkhir = $price - $diskon;

        $this->assertEquals(90000, $hargaAkhir);
    }

    public function test_harga_tidak_boleh_negatif(): void
    {
        $price = 50000;
        $this->assertTrue($price >= 0);
    }

    public function test_format_rupiah(): void
    {
        $price = 8500000;
        $formatted = 'Rp ' . number_format($price, 0, ',', '.');

        $this->assertEquals('Rp 8.500.000', $formatted);
    }
}
