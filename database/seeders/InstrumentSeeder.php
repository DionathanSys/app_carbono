<?php

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\Property;
use App\Models\User;
use App\Enum\InstrumentTypeEnum;
use App\Enum\StatusDiversosEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::with('user')->get();

        if ($properties->isEmpty()) {
            $this->command->warn('Nenhuma propriedade encontrada. Execute primeiro o PropertySeeder.');
            return;
        }

        $instrumentTypes = InstrumentTypeEnum::toSelectArray();
        $units = ['ha', 'm²'];
        $statuses = StatusDiversosEnum::toSelectArray();

        // Criar instrumentos para cada propriedade
        foreach ($properties as $property) {
            $numInstruments = rand(2, 5);

            for ($i = 1; $i <= $numInstruments; $i++) {
                Instrument::create([
                    'user_id' => $property->user_id,
                    'property_id' => $property->id,
                    'type' => $instrumentTypes[array_rand($instrumentTypes)],
                    'amount' => rand(10, 1000),
                    'unit' => $units[array_rand($units)],
                    'value' => rand(500, 50000) + (rand(0, 99) / 100), // Valores em reais
                    'description' => $this->getRandomDescription(),
                    'status' => $statuses[array_rand($statuses)],
                    'is_active' => rand(0, 10) > 1, // 90% chance de estar ativo
                ]);
            }
        }

        // Criar alguns instrumentos específicos
        $firstProperty = $properties->first();

        Instrument::create([
            'user_id' => $firstProperty->user_id,
            'property_id' => $firstProperty->id,
            'type' => $instrumentTypes[array_rand($instrumentTypes)],
            'amount' => 10.00,
            'unit' => $units[array_rand($units)],
            'value' => 15000.00,
            'description' => $this->getRandomDescription(),
            'status' => $statuses[array_rand($statuses)],
            'is_active' => true,
        ]);

        Instrument::create([
            'user_id' => $firstProperty->user_id,
            'property_id' => $firstProperty->id,
            'type' => $instrumentTypes[array_rand($instrumentTypes)],
            'amount' => 5.00,
            'unit' => $units[array_rand($units)],
            'value' => 250.00,
            'description' => $this->getRandomDescription(),
            'status' => $statuses[array_rand($statuses)],
            'is_active' => true,
        ]);

        if ($properties->count() > 1) {
            $secondProperty = $properties->skip(1)->first();

            Instrument::create([
                'user_id' => $secondProperty->user_id,
                'property_id' => $secondProperty->id,
                'type' => $instrumentTypes[array_rand($instrumentTypes)],
                'amount' => 1.00,
                'unit' => $units[array_rand($units)],
                'value' => 35000.00,
                'description' => $this->getRandomDescription(),
                'status' => $statuses[array_rand($statuses)],
                'is_active' => true,
            ]);
        }
    }

    private function getRandomDescription(): string
    {
        $descriptions = [
            'ATIVO TESTE 0010',
            'ATIVO TESTE 0011',
            'ATIVO TESTE 0012',
            'ATIVO TESTE 0013',
            'ATIVO TESTE 0014',
            'ATIVO TESTE 0015',
            'ATIVO TESTE 0016',
            'ATIVO TESTE 0017',
            'ATIVO TESTE 0018',
            'ATIVO TESTE 0019',
        ];

        return $descriptions[array_rand($descriptions)];
    }
}
