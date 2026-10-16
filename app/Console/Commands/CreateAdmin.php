<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-user';

    protected $description = 'Buat akun pengguna untuk masuk ke aplikasi perpustakaan';

    public function handle(): int
    {
        $name = trim($this->ask('Nama lengkap'));
        $username = trim($this->ask('Username'));

        if ($name === '' || $username === '') {
            $this->error('Nama dan username wajib diisi.');
            return self::FAILURE;
        }

        if (User::where('username', $username)->exists()) {
            $this->error('Username tersebut sudah digunakan.');
            return self::FAILURE;
        }

        $password = $this->secret('Password (minimal 8 karakter)');
        $confirmation = $this->secret('Ulangi password');

        if (strlen((string) $password) < 8 || $password !== $confirmation) {
            $this->error('Password minimal 8 karakter dan kedua input harus sama.');
            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $this->info("Akun '{$username}' berhasil dibuat.");
        return self::SUCCESS;
    }
}
