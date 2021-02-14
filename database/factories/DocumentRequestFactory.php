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
            'document_type' => 'StatusCertificate',     // Might add other document types later
            'created_at' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        ];
    }
}
