<?php

    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
     */
    class AnswerFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'answer' => Str::random(10),
                'question_id' => rand(1, 10)
            ];
        }

        /**
         * For the fields that will be excluded
         */
        public function unverified(): static {}
    }
