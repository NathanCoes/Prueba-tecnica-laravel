<?php

namespace Database\Seeders;

use App\Models\Clientes;
use App\Models\Envios;
use App\Models\Pedidos;
use App\Models\Productos;
use App\Models\Roles;
use Faker\Factory as Faker;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $faker = Faker::create();

        Roles::create(['rol' => 'Usuario']);
        Roles::create(['rol' => 'Administrador']);

        User::create([
            'nombre' => $faker->firstName,
            'apellido' => $faker->lastName,
            'email' => 'usuario@nova.com',
            'password' => Hash::make('Contraseña')
        ]);
        User::create([
            'nombre' => $faker->firstName,
            'apellido' => $faker->lastName,
            'email' => 'admin@nova.com',
            'password' => Hash::make('Contraseña')
        ]);
        Clientes::create([
            'nombre' => "Publico general",
            'rfc' => "XXXXXXX", // Alterna entre los valores de RFC
            'email' => "admin@nova.com",
            'telefono' => "xxxxxxxx",
            'contacto' => "xxxxxxxx"
        ]);
        $valoresRFC = ['TODJ190723XY2', 'WNBX240328PS7', 'LEEJ350515CC1', 'AIFO670208OX9', 'FJRM700403PP8'];
        $companyName = [];
        for ($i = 0; $i < 5; $i++) {
            $company = $faker->company;
            array_push($companyName, $company);

            Clientes::create([
                'nombre' => $company,
                'rfc' => $valoresRFC[$i % count($valoresRFC)], // Alterna entre los valores de RFC
                'email' => $faker->companyEmail,
                'telefono' => $faker->phoneNumber,
                'contacto' => $faker->name
            ]);
        }

        foreach ($companyName as $key => $value) {
            for ($i=0; $i < 2; $i++) {
                Envios::create([
                    'id_cliente' => $key+1,
                    'nombre' => $value,
                    'direccion' => $faker->streetAddress,
                    'codigo_postal'=> $faker->postcode,
                    'telefono' => $faker->phoneNumber,
                    'contacto' => $faker->name,
                ]);
            }
        }

        $sku = ["TLYD-ZLH4-6RNB-KW6N","VWM7-3A6F-7RLC-853N","Q2G6-Z4VT-9KUQ-4J8H","2QCS-MT4E-627L-MXLE","C348-EJDQ-LAXU-MQ6P","KRKL-B4CE-U86J-S2LS"];
        $descripcion = ["60cm X 90 cm X 40cm", "50cm X 80 cm X 30cm", "40cm X 70 cm X 40cm", "30cm X 60 cm X 50cm", "60cm X 90 cm X 40cm", "35cm X 60 cm X 40cm", ];
        $precio = [25, 54, 23, 44, 100, 85];
        $unidades = [130, 55, 45, 99, 150, 200];

        foreach ($sku as $key => $value) {
            Productos::create([
                'sku' => $value,
                'descripcion' => "Este es una caja de ". $descripcion[$key],
                'unidad_medida' => "Pieza",
                'precio' => $precio[$key],
                'unidades_disponibles' => $unidades[$key]
            ]);
        }

        Pedidos::create([
            'id_productos' => json_encode(
                [
                    0 => [
                        'id_producto' => 1,
                        'cantidad' => 1
                    ],
                    1 => [
                        'id_producto' => 3,
                        'cantidad' => 2
                    ],
                    2 => [
                        'id_producto' => 2,
                        'cantidad' => 1
                    ]
                ]
            ),
            'id_cliente' => 1,
            'id_direccion_envio' => 1,
            'monto' => 125,
            'creado_por' => 1
        ]);

        Pedidos::create([
            'id_productos' => json_encode(
                [
                    0 => [
                        'id_producto' => 4,
                        'cantidad' => 1
                    ],
                    1 => [
                        'id_producto' => 3,
                        'cantidad' => 1
                    ],
                    2 => [
                        'id_producto' => 2,
                        'cantidad' => 1
                    ]
                ]
            ),
            'id_cliente' => 2,
            'id_direccion_envio' => 4,
            'monto' => 121,
            'creado_por' => 2
        ]);
    }
}
