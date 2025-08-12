<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Session;
use App\Models\Trainer;
use App\Models\Skill;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur admin
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@yels.cm',
            'password' => bcrypt('password'),
        ]);

        // Créer des compétences
        $skill1 = Skill::create(['name' => 'Entrepreneuriat agricole']);
        $skill2 = Skill::create(['name' => 'Comptabilité pour PME']);

        // Créer des formations
        $formation1 = Formation::create([
            'name' => 'Gestion des Finances pour PME',
            'level' => 'Intermédiaire',
            'presentation' => 'Apprenez à gérer les finances des petites et moyennes entreprises au Cameroun.',
            'youtube_link' => 'https://www.youtube.com/watch?v=example',
            'photo' => 'formations/finance_pme.jpg',
            'is_active' => true,
        ]);
        $formation1->skills()->attach([$skill1->id, $skill2->id]);

        $formation2 = Formation::create([
            'name' => 'Introduction à l’Agribusiness',
            'level' => 'Débutant',
            'presentation' => 'Découvrez les bases de l’agribusiness et des opportunités au Cameroun.',
            'youtube_link' => 'https://www.youtube.com/watch?v=example2',
            'photo' => 'formations/agribusiness.jpg',
            'is_active' => true,
        ]);
        $formation2->skills()->attach([$skill1->id]);

        // Créer des formateurs
        $trainer1 = Trainer::create([
            'first_name' => 'Jean-Pierre',
            'last_name' => 'Nguélé',
            'email' => 'jeanpierre.nguele@yels.cm',
            'phone' => '+237690123456',
            'is_active' => true,
        ]);

        $trainer2 = Trainer::create([
            'first_name' => 'Marie-Claire',
            'last_name' => 'Ngo Bayi',
            'email' => 'marieclaire.ngobayi@yels.cm',
            'phone' => '+237677987654',
            'is_active' => true,
        ]);

        // Créer des sessions
        $session1 = Session::create([
            'formation_id' => $formation1->id,
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-07',
            'country' => 'Cameroun',
            'city' => 'Yaoundé',
            'type' => 'Présentiel',
            'price' => 100000,
            'status' => 'cloturé',
        ]);
        $session1->trainers()->attach([$trainer1->id, $trainer2->id]);

        $session2 = Session::create([
            'formation_id' => $formation2->id,
            'start_date' => '2025-08-01',
            'end_date' => '2025-08-10',
            'country' => 'Cameroun',
            'city' => 'Douala',
            'type' => 'En ligne',
            'price' => 75000,
            'status' => 'en cours',
        ]);
        $session2->trainers()->attach([$trainer1->id]);

        $session3 = Session::create([
            'formation_id' => $formation1->id,
            'start_date' => '2025-09-01',
            'end_date' => '2025-09-07',
            'country' => 'Cameroun',
            'city' => 'Bamenda',
            'type' => 'Présentiel',
            'price' => 100000,
            'status' => 'en cours',
        ]);
        $session3->trainers()->attach([$trainer2->id]);

        $session4 = Session::create([
            'formation_id' => $formation2->id,
            'start_date' => '2025-10-01',
            'end_date' => '2025-10-05',
            'country' => 'Cameroun',
            'city' => 'Garoua',
            'type' => 'En ligne',
            'price' => 75000,
            'status' => 'désactivée',
        ]);
        $session4->trainers()->attach([$trainer1->id, $trainer2->id]);

        // Créer 5 commandes
        $orders = [
            [
                'first_name' => 'Aminatou',
                'last_name' => 'Mbah',
                'email' => 'aminatou.mbah@example.cm',
                'phone' => '+237699876543',
                'company' => 'AgroPlus Cameroun',
                'country' => 'Cameroun',
                'total_price' => 175000,
                'status' => 'completed',
                'order_details' => [
                    [
                        'formation_id' => $formation1->id,
                        'session_id' => $session1->id,
                        'price' => 100000,
                    ],
                    [
                        'formation_id' => $formation2->id,
                        'session_id' => $session2->id,
                        'price' => 75000,
                    ],
                ],
                'payment' => [
                    'amount' => 175000,
                    'status' => 'completed',
                    'payment_method' => 'Mobile Money',
                ],
            ],
            [
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'email' => 'jean.dupont@example.cm',
                'phone' => '+237690123456',
                'company' => 'Entreprise Dupont',
                'country' => 'Sénégal',
                'total_price' => 100000,
                'status' => 'completed',
                'order_details' => [
                    [
                        'formation_id' => $formation1->id,
                        'session_id' => $session1->id,
                        'price' => 100000,
                    ],
                ],
                'payment' => [
                    'amount' => 100000,
                    'status' => 'completed',
                    'payment_method' => 'Carte bancaire',
                ],
            ],
            [
                'first_name' => 'Marie',
                'last_name' => 'Nguyen',
                'email' => 'marie.nguyen@example.cm',
                'phone' => '+237691234567',
                'company' => 'Nguyen Consulting',
                'country' => 'Côte d\'Ivoire',
                'total_price' => 75000,
                'status' => 'completed',
                'order_details' => [
                    [
                        'formation_id' => $formation2->id,
                        'session_id' => $session2->id,
                        'price' => 75000,
                    ],
                ],
                'payment' => [
                    'amount' => 75000,
                    'status' => 'completed',
                    'payment_method' => 'Mobile Money',
                ],
            ],
            [
                'first_name' => 'Pierre',
                'last_name' => 'Tchalla',
                'email' => 'pierre.tchalla@example.cm',
                'phone' => '+237692345678',
                'company' => 'Tchalla SARL',
                'country' => 'Mali',
                'total_price' => 175000,
                'status' => 'completed',
                'order_details' => [
                    [
                        'formation_id' => $formation1->id,
                        'session_id' => $session3->id,
                        'price' => 100000,
                    ],
                    [
                        'formation_id' => $formation2->id,
                        'session_id' => $session2->id,
                        'price' => 75000,
                    ],
                ],
                'payment' => [
                    'amount' => 175000,
                    'status' => 'completed',
                    'payment_method' => 'Virement bancaire',
                ],
            ],
            [
                'first_name' => 'Luc',
                'last_name' => 'Mballa',
                'email' => 'luc.mballa@example.cm',
                'phone' => '+237694567890',
                'company' => 'Mballa Tech',
                'country' => 'Gabon',
                'total_price' => 100000, // 100 000
                'status' => 'completed',
                'order_details' => [
                    [
                        'formation_id' => $formation1->id,
                        'session_id' => $session3->id,
                        'price' => 100000,
                    ],
                ],
                'payment' => [
                    'amount' => 100000,
                    'status' => 'completed',
                    'payment_method' => 'Mobile Money',
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $order = Order::create(array_merge([
                'created_at' => now(),
                'updated_at' => now(),
            ], array_diff_key($orderData, array_flip(['order_details', 'payment']))));

            foreach ($orderData['order_details'] as $detail) {
                OrderDetail::create(array_merge([
                    'order_id' => $order->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], $detail));
            }

            Payment::create(array_merge([
                'order_id' => $order->id,
                'created_at' => now(),
                'updated_at' => now(),
            ], $orderData['payment']));
        }
    }
}
