<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 👑 ادمین
        User::updateOrCreate(
            ['email' => 'admin@bookstore.test'],
            [
                'name' => 'مدیر کتابستان',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'phone' => '09120000000',
                'bio' => 'مدیر کل فروشگاه کتابستان',
            ]
        );

        // 👤 کاربر عادی نمونه
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'کاربر کتابستان',
                'password' => Hash::make('user123'),
                'is_admin' => false,
                'phone' => '09123456789',
                'bio' => 'عاشق کتاب‌های رمان و شعر',
            ]
        );

        $this->command->info('✅ کاربران ساخته شدند:');
        $this->command->info('   👑 ادمین: admin@bookstore.test / admin123');
        $this->command->info('   👤 کاربر: user@example.com / user123');
    }
}