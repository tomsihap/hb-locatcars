<?php
namespace App\Controller;

class UsersController {

    public static function list() {
        //$users = $userManager->findAll();
        $users = [
            [
                'firstname' => 'john',
                'lastname' => 'doe',
            ],
            [
                'firstname' => 'emma',
                'lastname' => 'watson',
            ]
        ];

        foreach($users as $user) {
            foreach($user as $key => $value) {
                $user[$key] = ucfirst($value);
            }
        }

        // Inclure un fichier qui contient du HTML
        // Dans le fichier HTML "users/list.php"

        foreach($users as $u) {
            echo $u['firstname'] . ' ' . $u['lastname'] . '<br>';
        }
    }


    public static function show($userId) {
        $user = $userManager->findOneById($userId);

        include 'templates/users/show.php';
    }
}