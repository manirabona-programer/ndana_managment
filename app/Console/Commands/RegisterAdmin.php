<?php

    namespace App\Console\Commands;

    use Laravel\Fortify\Rules\Password;
    use Illuminate\Console\Command;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;

    class RegisterAdmin extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'register:admin';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Command description';

        /**
         * Execute the console command.
         */
        public function handle() {
            $name = $this->ask('What is your name?');
            $email = $this->ask('What is your Email?');
            $password = $this->ask('Enter your Password?');

            Validator::make([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ], [
                'name' => ['required', 'string', 'max:255'],
                'email' => [ 'required', 'string', 'email', 'max:255', Rule::unique(User::class) ],
                'password' => ['required', 'string', new Password],
            ])->validate();

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            return $this->info('Admin registered');
        }
    }
