<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'phone' => $this->faker->phoneNumber(),
            'lang' => $this->faker->regexify('[A-Za-z0-9]{2}'),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'street' => $this->faker->streetName(),
            'street_number' => $this->faker->regexify('[A-Za-z0-9]{7}'),
            'street_box' => $this->faker->regexify('[A-Za-z0-9]{7}'),
            'avatar' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'more_info' => $this->faker->word(),
            'password' => $this->faker->password(),
            'remember_token' => $this->faker->uuid(),
            'code' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'active' => $this->faker->boolean(),
            'optin_newsletter' => $this->faker->boolean(),
            'company_id' => $this->faker->randomNumber(),
        ];
    }
}
