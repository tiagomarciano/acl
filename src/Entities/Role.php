<?php
declare(strict_types=1);

namespace TiagoMarciano\Acl\Entities;


/**
 * Class Role
 * @package TiagoMarciano\Acl\Entities
 */
class Role
{
    protected $name;
    protected $permissions;

    /**
     * Role constructor.
     * @param $name
     */
    public function __construct(string $name = null)
    {
        $this->name = $name;
        $this->permissions = [];
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Role
     */
    public function setName(string $name): Role
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param Permission $permission
     * @return Role
     */
    public function addPermissions(Permission $permission): Role
    {
        $this->permissions[] = $permission;
        return $this;
    }

}