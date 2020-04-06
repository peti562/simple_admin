<?php

namespace App\Models;

use App\Entity\UserRole;

class Page extends BaseModel {

    public function getPagesForUser(\App\Entity\User $user)
    {
        $roleIds = [];

        /** @var UserRole $role */
        foreach ($user->getRoles() as $role) {
            $roleIds[] = $role->getRoleId();
        }

        $query = $this->db->table('page_role')
            ->join('page', 'page.p_id', '=', 'page_role.fk_page_id')
            ->select([
                'page.*',
            ])
            ->whereIn('fk_role_id', $roleIds);

        $pages = $this->asObjects($query->get(), 'App\Entity\Page');

        $user->setPages($pages);

        return $user;
    }

}
