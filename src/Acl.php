<?php
declare(strict_types=1);

namespace TiagoMarciano\Acl;


use TiagoMarciano\Acl\Contracts\UserAcl;
use TiagoMarciano\Acl\Entities\Resource;
use TiagoMarciano\Acl\Entities\Role;

/**
 * Class Acl
 * @package TiagoMarciano\Acl
 */
class Acl
{

    protected $roles;
    protected $resources;
    protected $user;

    /**
     * Acl constructor.
     */
    public function __construct(array $roles, array $resources)
    {
        foreach ($roles as $role) {
            if(!$role instanceof Role) {
                trow \InvalidArgumentException("Invalid Role");
            }
        }
        $this->roles = $roles;

        foreach ($resources as $resource) {
            if(!$resource instanceof Resource) {
                trow \InvalidArgumentException("Invalid Resource");
            }
        }
        $this->resources = $resources;
    }

    /**
     * @param UserAcl $user
     * @return Acl
     */
    public function setUser(UserAcl $user):Acl
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        foreach ($this->roles as $r) {
            if($r->getName() == $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $role
     * @param string $permission
     * @return role
     */
    public function hasPermission(string $role, string $permission): bool
    {
        foreach ($this->roles as $r) {
            if($r->getName() == $role) {
                foreach ($r->getPermissions() as $p) {
                    if($p->getName() == $permission) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param string $permission
     * @param UserAcl|null $user
     * @return bool
     */
    public function can(string $permission, UserAcl $user = null): bool
    {
        if($user) {
            return $this->hasPermission($user->getRole(), $permission);
        }

        if($this->user) {
            return $this->hasPermission($this->user->getRole(), $permission);
        }

        return false;
    }

    /**
     * @param string $permission
     * @param UserAcl|null $user
     * @return bool
     */
    public function cannot(string $permission, UserAcl $user = null):bool
    {
        return !$this->can($permission, $user);
    }

    /**
     * @param $resource
     * @param UserAcl|null $user
     * @return bool
     */
    public function isOwner($resource, UserAcl $user = null): bool
    {
        if($user){
            $this->setUser($user);
        }

        foreach ($this->resources as $r) {
            if(is_a($resource, $r->getName())) {
                if($user){
                    return $resource->{$r->getOwnerField()}() == $user->getId();
                }
                return $resource->{$r->getOwnerField()}() == $this->user->getId();
            }
        }

        return false;
    }

}