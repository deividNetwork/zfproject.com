<?php

    namespace SONUser\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Math\Rand;
    use Zend\Crypt\Key\Derivation\Pbkdf2;
    use Zend\Stdlib\Hydrator;

    /**
     * SonuserUsers
     *
     * @ORM\Table(name="sonuser_users")
     * @ORM\Entity
     * @ORM\HasLifecycleCallbacks
     */
    class User {
        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer", nullable=false)
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $id;

        /**
         * @var string
         *
         * @ORM\Column(name="nome", type="string", length=255, nullable=false)
         */
        private $nome;

        /**
         * @var string
         *
         * @ORM\Column(name="email", type="string", length=255, nullable=false)
         */
        private $email;

        /**
         * @var string
         *
         * @ORM\Column(name="password", type="string", length=255, nullable=false)
         */
        private $password;

        /**
         * @var string
         *
         * @ORM\Column(name="salt", type="string", length=255, nullable=false)
         */
        private $salt;

        /**
         * @var bool
         *
         * @ORM\Column(name="active", type="boolean", nullable=false)
         */
        private $active;

        /**
         * @var string
         *
         * @ORM\Column(name="activation_key", type="string", length=255, nullable=false)
         */
        private $activationKey;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="update_at", type="date", nullable=false)
         */
        private $updateAt;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="created_at", type="date", nullable=false)
         */
        private $createdAt;

        public function __construct(array $options = array()) {
//            $hidrator = new Hydrator\ClassMethods;
//            $hidrator->hydrate($options = array(), $this);

            (new Hydrator\ClassMethods)->hydrate($options = array(), $this);

            $this->createdAt = new \DateTime('now');
            $this->updateAt = new \DateTime('now');
            $this->salt = base64_encode(Rand::getBytes(8, true));
            $this->activationKey = md5($this->email . $this->salt);
        }

        /**
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         * @param int $id
         * @return User
         */
        public function setId($id) {
            $this->id = $id;

            return $this;
        }

        /**
         * @return string
         */
        public function getNome() {
            return $this->nome;
        }

        /**
         * @param string $nome
         * @return User
         */
        public function setNome($nome) {
            $this->nome = $nome;

            return $this;
        }

        /**
         * @return string
         */
        public function getEmail() {
            return $this->email;
        }

        /**
         * @param string $email
         * @return User
         */
        public function setEmail($email) {
            $this->email = $email;

            return $this;
        }

        /**
         * @return string
         */
        public function getPassword() {
            return $this->password;
        }

        /**
         * @param string $password
         * @return User
         */
        public function setPassword($password) {
            $this->password = $this->encryptPassword($password);

            return $this;
        }

        public function encryptPassword($password) {
            return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, (strlen($password) * 2)));
        }

        /**
         * @return string
         */
        public function getSalt() {
            return $this->salt;
        }

        /**
         * @param string $salt
         * @return User
         */
        public function setSalt($salt) {
            $this->salt = $salt;

            return $this;
        }

        /**
         * @return boolean
         */
        public function isActive() {
            return $this->active;
        }

        /**
         * @param boolean $active
         * @return User
         */
        public function setActive($active) {
            $this->active = $active;

            return $this;
        }

        /**
         * @return string
         */
        public function getActivationKey() {
            return $this->activationKey;
        }

        /**
         * @param string $activationKey
         * @return User
         */
        public function setActivationKey($activationKey) {
            $this->activationKey = $activationKey;

            return $this;
        }

        /**
         * @return \DateTime
         */
        public function getUpdateAt() {
            return $this->updateAt;
        }

        /**
         * @param \DateTime $updateAt
         * @ORM\prePersist
         * @return User
         */
        public function setUpdateAt() {
            $this->updateAt = new \DateTime('now');

            return $this;
        }

        /**
         * @return \DateTime
         */
        public function getCreatedAt() {
            return $this->createdAt;
        }

        /**
         * @param \DateTime $createdAt
         * @return User
         */
        public function setCreatedAt() {
            $this->createdAt = new \DateTime('now');

            return $this;
        }


    }

