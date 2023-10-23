<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'nip' => '000001',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                'foto' => 'master_user.png',
                'jabatan' => 'admin'
            ],
            [
                'name' => 'user',
                'nip' => '11111',
                'email' => 'user@user.com',
                'password' => Hash::make('123456'),
                'foto' => 'master_user.png',
                'jabatan' => 'user'
            ],

        ];

        foreach ($data as $row) {
            try {
                $user = User::create([
                    'name' => $row["name"],
                    'nip' => $row["nip"],
                    'email' => $row["email"],
                    'jabatan' => $row["jabatan"],
                    'password' => $row["password"],
                ]);

                // Assign to
                $user->assignRole($row['role']);
            } catch (\Exception $exception) {
                $message = '  Email ' . $row['email'] . ' already exists. Do you want to update this email? [y/n]';
                $ask = $this->command->ask($message);

                if ($ask == 'yes' || $ask == 'y') {
                    $user = User::where('email', $row['email'])->first();

                    $user->update([
                        'name' => $row["name"],
                        'password' => $row["password"],
                    ]);
                    // Assign to

                }
            }
        }
    }
}
