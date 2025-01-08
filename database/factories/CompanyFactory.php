<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Company;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'vat' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'street' => $this->faker->streetName(),
            'street_number' => $this->faker->regexify('[A-Za-z0-9]{7}'),
            'street_box' => $this->faker->regexify('[A-Za-z0-9]{7}'),
            'active' => $this->faker->boolean(),
            'is_agency' => $this->faker->boolean(),
            'partner' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
