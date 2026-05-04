<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = ['James', 'Mary', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda', 'William', 'Barbara',
                       'David', 'Susan', 'Richard', 'Jessica', 'Joseph', 'Sarah', 'Thomas', 'Karen', 'Charles', 'Lisa'];

        $lastNames  = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Wilson', 'Taylor',
                       'Anderson', 'Thomas', 'Jackson', 'White', 'Harris', 'Martin', 'Thompson', 'Robinson', 'Clark', 'Lewis'];

        $domains = ['example.com'];

        $orders = [];
        $now = now();

        for ($i = 0; $i < 2000; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName  = $lastNames[array_rand($lastNames)];
            $name      = $firstName . ' ' . $lastName;
            $email     = strtolower($firstName . '.' . $lastName . rand(1, 999)) . '@' . $domains[array_rand($domains)];

            $orders[] = [
                'customer_name'  => $name,
                'customer_email' => $email,
                'order_amount'   => rand(10, 10000),
                'created_at'     => $now,
                'updated_at'     => $now,
            ];
        }

        // Insert in chunks of 500 for performance
        foreach (array_chunk($orders, 500) as $chunk) {
            DB::table('orders')->insert($chunk);
        }
    }
}