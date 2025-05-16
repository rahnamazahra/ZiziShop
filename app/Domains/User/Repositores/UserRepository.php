<?php
namespace App\Domains\User\Repositories;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository 
{
    public function model()
    {
        return User::class;
    }
}