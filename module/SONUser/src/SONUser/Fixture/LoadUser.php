<?php
    namespace SONUser\Fixture;

    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\Persistence\ObjectManager;

    use SONUser\Entity\User;


    class LoadUser extends AbstractFixture {
        public function load(ObjectManager $manager) {
            try {
                $user = new User();
                $user->setNome('Deivid Network')
                     ->setEmail('deividnetwork@gmail.com')
                     ->setPassword(123456)
                     ->setActive(true);

                $manager->persist($user);
                $manager->flush();

                // store reference of admin-user for other Fixtures
                $this->addReference('sonuser_users', $user);
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }