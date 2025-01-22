<?php

namespace Database\Factories;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
  
    protected $model = Holiday::class;

    public function definition(): array
    {
        $startDate = now()->addMonths(9);
        $endDate = now()->addMonths(9)->addDays(2);
        return [
            'stars' => $this->faker->numberBetween(1,5),
            'reader_trip' => $this->faker->numberBetween(0,1),
            'flash_deal' => $this->faker->numberBetween(0,1),
            'longitude' => 4.387555,
            'latitude' => 50.8166301,
            'startdate' => $startDate,
            'enddate' => $endDate,
            'holiday_type_id' => $this->faker->numberBetween(1,2),
        ];
    }
}
