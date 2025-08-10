<?php

namespace Database\Seeders;

use App\Enum\BiomaEnum;
use App\Models\Property;
use App\Models\User;
use App\Enum\PropertyTypeEnum;
use App\Enum\StatusDiversosEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Execute primeiro o UserSeeder.');
            return;
        }

        $propertyTypes = PropertyTypeEnum::toSelectArray();
        $biomas = BiomaEnum::toSelectArray();
        $statuses = StatusDiversosEnum::toSelectArray();

        // Criar propriedades para cada usuário
        foreach ($users as $user) {
            $numProperties = rand(1, 3);

            for ($i = 1; $i <= $numProperties; $i++) {
                Property::create([
                    'user_id' => $user->id,
                    'name' => "Propriedade {$i} - {$user->name}",
                    'area' => rand(1000, 50000) / 10, // Entre 100 e 5000 m²
                    'location' => $this->getRandomLocation(),
                    'property_type' => $propertyTypes[array_rand($propertyTypes)],
                    'bioma' => $biomas[array_rand($biomas)],
                    'car_code' => 'CAR-' . str_pad(rand(1, 9999999), 7, '0', STR_PAD_LEFT),
                    'is_active' => rand(0, 10) > 2, // 80% chance de estar ativo
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }

        // Criar algumas propriedades específicas
        Property::create([
            'user_id' => $users->first()->id,
            'name' => 'Fazenda São José',
            'area' => 1250.75,
            'location' => 'Mato Grosso do Sul, Brasil',
            'property_type' => $propertyTypes[array_rand($propertyTypes)],
            'bioma' => $biomas[array_rand($biomas)],
            'car_code' => 'CAR-1234567',
            'is_active' => true,
            'status' => $statuses[array_rand($statuses)],
        ]);

        Property::create([
            'user_id' => $users->skip(1)->first()->id ?? $users->first()->id,
            'name' => 'Sítio Boa Esperança',
            'area' => 85.50,
            'location' => 'Goiás, Brasil',
            'property_type' => $propertyTypes[array_rand($propertyTypes)],
            'bioma' => $biomas[array_rand($biomas)],
            'car_code' => 'CAR-7654321',
            'is_active' => true,
            'status' => $statuses[array_rand($statuses)],
        ]);
    }

    private function getRandomLocation(): string
    {
        $locations = [
            'Mato Grosso, Brasil',
            'Mato Grosso do Sul, Brasil',
            'Goiás, Brasil',
            'Minas Gerais, Brasil',
            'São Paulo, Brasil',
            'Bahia, Brasil',
            'Tocantins, Brasil',
            'Pará, Brasil',
            'Rondônia, Brasil',
            'Acre, Brasil',
        ];

        return $locations[array_rand($locations)];
    }
}
