<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['code' => 'TRY', 'name' => 'Türk Lirası'],
            ['code' => 'USD', 'name' => 'Amerikan Doları'],
            ['code' => 'EUR', 'name' => 'Euro'],
            ['code' => 'GBP', 'name' => 'İngiliz Sterlini'],
            ['code' => 'JPY', 'name' => 'Japon Yeni'],
            ['code' => 'RUB', 'name' => 'Rus Rublesi'],
            ['code' => 'CNY', 'name' => 'Çin Yuanı'],
            ['code' => 'INR', 'name' => 'Hindistan Rupisi'],
            ['code' => 'AUD', 'name' => 'Avustralya Doları'],
            ['code' => 'CAD', 'name' => 'Kanada Doları'],
            ['code' => 'CHF', 'name' => 'İsviçre Frangı'],
            ['code' => 'SEK', 'name' => 'İsveç Kronu'],
            ['code' => 'NOK', 'name' => 'Norveç Kronu'],
            ['code' => 'DKK', 'name' => 'Danimarka Kronu'],
            ['code' => 'SAR', 'name' => 'Suudi Arabistan Riyali'],
            ['code' => 'QAR', 'name' => 'Katar Riyali'],
            ['code' => 'AED', 'name' => 'Birleşik Arap Emirlikleri Dirhemi'],
            ['code' => 'KWD', 'name' => 'Kuveyt Dinarı'],
            ['code' => 'BHD', 'name' => 'Bahreyn Dinarı'],
            ['code' => 'OMR', 'name' => 'Umman Riyali'],
            ['code' => 'JOD', 'name' => 'Ürdün Dinarı'],
            ['code' => 'ILS', 'name' => 'İsrail Şekeli'],
            ['code' => 'ZAR', 'name' => 'Güney Afrika Randı'],
            ['code' => 'BRL', 'name' => 'Brezilya Reali'],
            ['code' => 'ARS', 'name' => 'Arjantin Pezosu'],
            ['code' => 'MXN', 'name' => 'Meksika Pezosu'],
            ['code' => 'COP', 'name' => 'Kolombiya Pezosu'],
            ['code' => 'CLP', 'name' => 'Şili Pezosu'],
            ['code' => 'PEN', 'name' => 'Peru Solu'],
            ['code' => 'EGP', 'name' => 'Mısır Lirası'],
            ['code' => 'ZMW', 'name' => 'Zambiya Kvaçası'],
            ['code' => 'KES', 'name' => 'Kenya Şilini'],
            ['code' => 'GHS', 'name' => 'Gana Sedisi'],
            ['code' => 'NGN', 'name' => 'Nijerya Nairası'],
            ['code' => 'MAD', 'name' => 'Fas Dirhemi'],
            ['code' => 'TND', 'name' => 'Tunus Dinarı'],
            ['code' => 'DZD', 'name' => 'Cezayir Dinarı'],
            ['code' => 'LYD', 'name' => 'Libya Dinarı'],
            ['code' => 'SYP', 'name' => 'Suriye Lirası'],
            ['code' => 'IQD', 'name' => 'Irak Dinarı'],
            ['code' => 'LBP', 'name' => 'Lübnan Lirası'],
        ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::create($currency);
        }
    }
}
