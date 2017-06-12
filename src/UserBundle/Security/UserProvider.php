<?php
/**
 * Created by PhpStorm.
 * User: andrzej
 * Date: 04.06.17
 * Time: 16:42
 */

namespace UserBundle\Security;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use UserBundle\Entity\User;
use UserBundle\Entity\UserRepository;

class UserProvider implements UserProviderInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        /** @var UserRepository $repo */
        $repo = $this->em->getRepository(User::class);
        /** @var User $user */
        $user = $repo->findOneBy(['username' => $username]);
        return $user;
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Expected an instance of %s, but got "%s".', User::class, get_class($user)));
        }
        /** @var UserRepository $repo */
        $repo = $this->em->getRepository(User::class);
        /** @var User $user */
        if (null === $reloadedUser = $repo->findOneBy(array('id' => $user->getId()))) {
            throw new UsernameNotFoundException(sprintf('User with ID "%s" could not be reloaded.', $user->getId()));
        }
        /** @var User $reloadedUser */
        return $reloadedUser;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}