<?php

namespace Zakjakub\OswisCoreBundle\Entity\AbstractClass;

use Doctrine\Common\Collections\ArrayCollection;
use Serializable;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\UserTrait;

/**
 * Abstract class containing basic properties for user of application.
 *
 * @author Jakub Zak <mail@jakubzak.eu>
 */
abstract class AbstractAppUser implements UserInterface, Serializable, EquatableInterface
{
    use BasicEntityTrait;
    use UserTrait;

    /** @see \Serializable::serialize() */
    final public function serialize(): string
    {
        return serialize(array($this->id, $this->username, $this->email, $this->password, $this->deleted));
    }

    /**
     * @param string $serialized
     *
     * @return void
     * @see \Serializable::unserialize()
     *
     */
    final public function unserialize(
        /** @noinspection MissingParameterTypeDeclarationInspection */ $serialized
    ): void {
        [
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->deleted,
        ] = unserialize($serialized, array('allowed_classes' => ['AppUser']));
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    final public function isEqualTo(UserInterface $user): bool
    {
        if (!$user || !($user instanceof self)) {
            return false;
        }
        if ($this->id !== $user->getId() || $this->username !== $user->getUsername() || $this->email !== $user->getEmail() || $this->password !== $user->getPassword()) {
            return false;
        }

        return true;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    final public function eraseCredentials(): void
    {
    }

    /**
     * @param string $roleName
     *
     * @return bool
     */
    final public function hasRole(string $roleName): bool
    {
        return $this->containsRole($roleName);
    }

    /**
     * @param string $roleName
     *
     * @return bool
     */
    final public function containsRole(string $roleName): bool
    {
        $roles = new ArrayCollection($this->getRoles());

        return $roles->contains($roleName);
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return array (Role|string)[] The user roles
     */
    abstract public function getRoles(): array;
}
