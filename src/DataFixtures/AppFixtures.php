<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $role_super_admin = new Profil();
        $role_super_admin->setLibelle("ROLE_SUPER_ADMIN");
        $manager->persist($role_super_admin);

        $role_admin = new Profil();
        $role_admin->setLibelle("ROLE_ADMIN");
        $manager->persist($role_admin);

        $role_caissier = new Profil();
        $role_caissier->setLibelle("ROLE_CAISSIER");
        $manager->persist($role_caissier);

        $role_partenaire = new Profil();
        $role_partenaire->setLibelle("ROLE_ PARTENAIRE");
        $manager->persist($role_partenaire);
/*
        $this->addReference('role_super_admin',$role_super_admin);
        $this->addReference('role_admin',$role_admin);
        $this->addReference('role_caissier',$role_caissier);
        $this->addReference('role_partenaire',$role_partenaire);
        
        $roleAdmdinSystem = $this->getReference('role_super_admin');
        $roleAdmin = $this->getReference('role_admin');
        $roleAaissier = $this->getReference('role_caissier');
        $rolePartenaire = $this->getReference('role_partenaire');
*/
        $user = new User();
        $user->setUsername("gueyesoda56@gmail.com")
            
            ->setPrenom("soda")
            ->setNom("gueye")
            ->setIsActive(true)
            ->setPassword($this->encoder->encodePassword($user, "3868"));
         $user->setProfil($role_super_admin);
        $manager->persist($user);
        $manager->flush();
    }
}