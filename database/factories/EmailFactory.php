<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Email;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{
    protected $model = Email::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'          => $this->faker->unique()->safeEmail(),
            'subject'        => $this->faker->sentence(6),
            'body'           => $this->faker->paragraph(3),
            'attachment_path'=> null, // mặc định không có file
            'status'         => 'pending', // default status
            'attempts'       => 0,
        ];
    }
}
