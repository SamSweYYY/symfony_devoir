<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Level;
use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // ============================== ADMIN ============================
        $admin = new User();
        $admin->setUsername('pierre');
        $admin->setNom('Dupont');
        $admin->setPrenom('Pierre');
        $admin->setRoles(['ROLE_ADMIN']);   // rôle admin
        $admin->setIsAdmin(true);           // si ton entité a un booléen isAdmin
        $admin->setPassword($this->hasher->hashPassword($admin, 'dupont123'));
        $manager->persist($admin);

        // ============================== UTILISATEUR ======================
        $user = new User();
        $user->setUsername('jean');
        $user->setNom('Durand');
        $user->setPrenom('Jean');
        $user->setRoles(['ROLE_USER']);     // rôle normal
        $user->setIsAdmin(false);
        $user->setPassword($this->hasher->hashPassword($user, 'durand123'));
        $manager->persist($user);


        $categories = [];
        foreach (['Football', 'Basketball', 'Handball'] as $nom) {
            $cat = new Categorie();
            $cat->setNom($nom);
            $manager->persist($cat);
            $categories[] = $cat;
        }

        $levels = [];
        foreach (['Ligue 1', 'Ligue 2', 'National 1', 'National 2'] as $lvl) {
            $level = new Level();
            $level->setNom($lvl);
            $manager->persist($level);
            $levels[] = $level;
        }

        $players = [];
        for ($i = 1; $i <= 20; $i++) {
            $player = new Player();
            $player->setNom('Nom' . $i);
            $player->setPrenom('Prenom' . $i);
            $player->setBirthdate(new \DateTime(sprintf('1990-01-%02
d', $i)));
            $manager->persist($player);
            $players[] = $player;
        }
        // ============================== SAUVEGARDE =======================
        $manager->flush();
    }
}