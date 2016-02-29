<?php


namespace TiagoMarciano\Acl\Contracts;


/**
 * Interface UserAcl
 * @package TiagoMarciano\Acl\Contracts
 */
interface UserAcl
{

    /**
     * @return string
     */
    public function getRole():string;
    public function getId():int;

}