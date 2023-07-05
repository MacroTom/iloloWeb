<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         *  Land
         *  1 Month
         *  Basic - Free
         */

         \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => null,
            'icon' => 'bx-cookie',
            'title' => 'Basic',
            'price' => 0,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 1,
                'autorenew' => false,
                'sms' => false,
                'badge' => null,
                'links' => false
            ])
        ]);

        /**
         *  Land
         *  1 Month
         *  Regular - #6999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => null,
            'icon' => 'bx-trending-up',
            'title' => 'Regular',
            'price' => 6999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 5,
                'autorenew' => 24,
                'sms' => false,
                'badge' => null,
                'links' => false
            ])
        ]);

        /**
         *  Land
         *  1 Month
         *  Premium - #9999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 9999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Land
         *  1 Month
         *  Gold - #25999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 25999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Land
         *  1 Month
         *  Diamond - #37999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 37999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);

        /**
         *  Land
         *  3 Months
         *  Premium - #26999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 26999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Land
         *  3 Months
         *  Gold - #58999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 58999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Land
         *  3 Months
         *  Diamond - #81999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'L',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 81999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);


        /**
         *  Cars
         *  1 Month
         *  Basic - Free
         */

         \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => null,
            'icon' => 'bx-cookie',
            'title' => 'Basic',
            'price' => 0,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 1,
                'autorenew' => false,
                'sms' => false,
                'badge' => null,
                'links' => false
            ])
        ]);

        /**
         *  Cars
         *  1 Month
         *  Regular - #5999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => null,
            'icon' => 'bx-trending-up',
            'title' => 'Regular',
            'price' => 5999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 5,
                'autorenew' => 24,
                'sms' => false,
                'badge' => null,
                'links' => false
            ])
        ]);

        /**
         *  Cars
         *  1 Month
         *  Premium - #33999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 33999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Cars
         *  1 Month
         *  Gold - #55999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 55999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Cars
         *  1 Month
         *  Diamond - #126999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 126999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);

        /**
         *  Cars
         *  3 Months
         *  Premium - #104999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 104999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Cars
         *  3 Months
         *  Gold - #131999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 131999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Cars
         *  3 Months
         *  Diamond - #291999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'C',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 291999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);



        /**
         *  Others
         *  1 Month
         *  Basic - Free
         */

         \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => null,
            'icon' => 'bx-cookie',
            'title' => 'Basic',
            'price' => 0,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 1,
                'autorenew' => false,
                'sms' => false,
                'badge' => null,
                'links' => false
            ])
        ]);

        /**
         *  Others
         *  1 Month
         *  Regular - #6999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => null,
            'icon' => 'bx-trending-up',
            'title' => 'Regular',
            'price' => 6999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 5,
                'autorenew' => 24,
                'sms' => false,
                'badge' => null,
                'links' => false
            ])
        ]);

        /**
         *  Others
         *  1 Month
         *  Premium - #8999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 8999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Others
         *  1 Month
         *  Gold - #17999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 17999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Others
         *  1 Month
         *  Diamond - #31999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 31999,
            'discount' => 0,
            'duration' => 1,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);

        /**
         *  Others
         *  3 Months
         *  Premium - #50999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 50999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Others
         *  3 Months
         *  Gold - #81999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 81999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Others
         *  3 Months
         *  Diamond - #94999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 94999,
            'discount' => 0,
            'duration' => 3,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);



        /**
         *  Others
         *  6 Months
         *  Premium - #144999
         */

         \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Most Popular',
            'icon' => 'bx-crown',
            'title' => 'Premium',
            'price' => 144999,
            'discount' => 0,
            'duration' => 6,
            'properties' => json_encode([
                'count' => 20,
                'autorenew' => 12,
                'sms' => true,
                'badge' => 'Premium',
                'links' => false
            ])
        ]);

        /**
         *  Others
         *  6 Months
         *  Gold - #184999
         *
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Recommended',
            'icon' => 'bx-trophy',
            'title' => 'Gold',
            'price' => 184999,
            'discount' => 0,
            'duration' => 6,
            'properties' => json_encode([
                'count' => 100,
                'autorenew' => 6,
                'sms' => true,
                'badge' => 'Gold',
                'links' => true
            ])
        ]);

        /**
         *  Others
         *  6 Months
         *  Diamond - #225999
         */

        \App\Models\Plan::factory()->create([
            'category_type' => 'O',
            'tag' => 'Best value',
            'icon' => 'bx-diamond',
            'title' => 'Diamond',
            'price' => 225999,
            'discount' => 0,
            'duration' => 6,
            'properties' => json_encode([
                'count' => 300,
                'autorenew' => 3,
                'sms' => true,
                'badge' => 'Diamond',
                'links' => true
            ])
        ]);
    }
}
