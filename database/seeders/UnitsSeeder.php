<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['code' => 'Set', 'name' => 'Set'],
            ['code' => 'Year', 'name' => 'Year'],
            ['code' => 'Box', 'name' => 'Box'],
            ['code' => 'Piece', 'name' => 'Piece'],
            ['code' => 'Square Centimetre', 'name' => 'Euro'],
            ['code' => 'Day', 'name' => 'Day'],
            ['code' => 'Dozen', 'name' => 'Dozen'],
            ['code' => 'Foot', 'name' => 'Foot'],
            ['code' => 'Gram', 'name' => 'Gram'],
            ['code' => 'Gross ton', 'name' => 'Gross ton'],
            ['code' => 'Hour', 'name' => 'Hour'],
            ['code' => 'Barrel', 'name' => 'Barrel'],
            ['code' => 'Kilogram', 'name' => 'Kilogram'],
            ['code' => 'Kilojoules', 'name' => 'Kilojoules'],
            ['code' => 'Kilowatt-hour', 'name' => 'Kilowatt-hour'],
            ['code' => 'Lot', 'name' => 'Lot'],
            ['code' => 'Litre', 'name' => 'Litre'],
            ['code' => 'Milligrams', 'name' => 'Milligrams'],
            ['code' => 'Minute', 'name' => 'Minute'],
            ['code' => 'Cubic Millimetre', 'name' => 'Cubic Millimetre'],
            ['code' => 'Month', 'name' => 'Month'],
            ['code' => 'Square metre', 'name' => 'Square metre'],
            ['code' => 'Cubic Metre', 'name' => 'Cubic Metre'],
            ['code' => 'Metre', 'name' => 'Metre'],
            ['code' => 'Pair', 'name' => 'Pair'],
            ['code' => 'Package', 'name' => 'Pacakge'],
            ['code' => 'Thousand cubic metre', 'name' => 'Thousand cubic metre'],
            ['code' => 'Truckload', 'name' => 'Truckload'],
            ['code' => 'Ton (metric)', 'name' => 'Ton (metric)'],
            ['code' => 'Pallet', 'name' => 'Pallet'],
            ['code' => 'Koli', 'name' => 'Koli'],
        ];

        foreach ($units as $unit) {
            \App\Models\Unit::create($unit);
        }
    }
}
