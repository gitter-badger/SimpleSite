<?php

namespace App\Console\Commands;

use Ldap;
use App\User;
use Illuminate\Console\Command;

class UpdateUserProfile extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldap:profiles:update';

    public function handle()
    {
        if ($users = Ldap::search()->all()) {
            $updatedIds = [];
            foreach ($users as $ldapUser) {
                if (isset($ldapUser['mail']) and $user = User::withTrashed()->firstOrCreate(['email' => $ldapUser['mail']])) {
                    $user->name           = array_get($ldapUser, 'name');
                    $user->position       = array_get($ldapUser, 'title');
                    $user->phone_internal = array_get($ldapUser, 'telephonenumber');
                    $user->phone_mobile   = array_get($ldapUser, 'mobile');
                    $user->is_ldap        = true;
                    $user->save();

                    if (! $user->trashed()) {
                        $updatedIds[] = $user->id;
                    }
                }
            }

            User::whereNotIn('id', $updatedIds)->ldap()->get()->each(function (User $user) {
                $user->delete();
            });
        }
    }
}