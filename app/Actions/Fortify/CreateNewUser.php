<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'whatsappno' => ['required', 'string','max:12'],
            'whatsappno' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
        
        $whatsappno = $input['whatsappno'];

        if($whatsappno[0] == "0"){
            $whatsappno = substr_replace($whatsappno,'62',0,1);
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'whatsappno' => $whatsappno,
            'wali' => $input['wali'],
            'password' => Hash::make($input['password']),
        ]);

        

    }
}
