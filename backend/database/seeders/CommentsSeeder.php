<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = Ticket::all();
        $managers = User::where('role', 'manager')->get();

        foreach ($tickets as $ticket) {
            $possibleAuthors = $managers->push($ticket->user);
            $numComments = rand(1, 5);

            for ($i = 0; $i < $numComments; $i++) {

                $user = $possibleAuthors->random();

                Comment::factory()->create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
