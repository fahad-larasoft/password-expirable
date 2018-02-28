<?php

namespace Larasoft\PasswordExpiry\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Larasoft\PasswordExpiry\Notifications\ResetExpiredPassword;

class CheckPasswordExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:password-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expires the user password if more than expiry_days days mentioned in config/password-expiry.php';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all()->filter(function ($user) {
            if ($user->isPasswordExpired()) {
                return true;
            } else {
                return false;
            }
        });

        foreach ($users as $user) {
            $token = str_random(60);
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]);

            Notification::send($users, new ResetExpiredPassword($token));
        }
    }
}
