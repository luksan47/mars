<?php

namespace Database\Factories;

use App\Models\DocumentRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentRequestFactory extends Factory
{
    protected $model = DocumentRequest::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'neptun' => $this->faker->regexify('[A-Z0-9]{6}'),
            'document_type' => 'StatusCertificate',     // Might add other document types later
            'date_of_request' => $this->faker->unique()->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        ];
    }
}
