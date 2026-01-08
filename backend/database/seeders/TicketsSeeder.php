<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Cada usuário cria entre 5 a 10 tickets
            Ticket::factory(rand(5, 10))->create([
                'user_id' => $user->id,
                'created_at' => function () {
                    // Gera uma data entre "5 dias atrás" e "agora"
                    return fake()->dateTimeBetween('-5 days', 'now');
                },
                'updated_at' => function (array $attributes) {
                    return $attributes['created_at'];
                },
            ]);
        }
    }
}
