<?php

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class getToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:get {email} {password} {--expire=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get token for API request';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            'email'     => $this->argument('email'),
            'password'  => $this->argument('password'),
            'expire'    => $this->option('expire')
        ];

        $validator = Validator::make($data, [
            'email'     => 'email',
            'expire'    => 'numeric'
        ]);

        if ($validator->fails()) {
            $this->error('Non-correct arguments!');
        } else {
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = (new UserRepository)->getModelForAttributes(['email' => $data['email']]);
                $expiresAt = Carbon::now()->addMinute($data['expire']);
                $token = $user->createToken('test', ['*'], $expiresAt)->plainTextToken;

                $this->comment('Token for user email ' . $data['email'] . ': ' . $token);
            } else {
                $this->error('These credentials do not match our records!');
            }
        }
    }
}
