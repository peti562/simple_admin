<?php

namespace App\Models;

use App\Entity\UserSession;
use App\Helpers\DB;
use Carbon\Carbon;
use Cassandra\Date;
use DateTime;
use DateTimeZone;


class User extends BaseModel {

    public function getUser($options)
    {
        $query = $this->db->table('user');

        if (isset($options['username'])) {
            $query->where('u_username', $options['username']);
        }

        $user = $this->asObject($query->first(), 'App\Entity\User');

        if (isset($options['withRoles'])) {
            $user->setRoles($this->getRoles($user));
        }

        return $user;
    }

    /**
     * @param $userId
     * @param int $limit
     * @return array
     * @throws \Pixie\Exception
     * @throws \Exception
     */
    public function getActiveUserSession($userId, $limit = 1) {
        $query = $this->db->table('user_session')
            ->where('fk_user_id', $userId)
            ->where('us_login_successful', true)
            ->orderBy('us_created_at', 'DESC')
            ->limit($limit);

        /** @var UserSession $userSession */
        $userSessions = $this->asObjects($query->get(), 'App\Entity\UserSession');

        if (empty($userSessions)) {
            return [ null, null ];
        }

        // get the last user session for validation
        $userSession = current($userSessions);


        $timeLimit = new DateTime(date('Y-m-d H:i:s'));

        $timeLimit->modify('-'.$this->env->get('session_expiry_minutes').' minutes');

        $sessionTime = $userSession->getCreatedAt();

        if ($sessionTime < $timeLimit) {
            return [ null, null ];
        }

        //return all user sessions
        return count($userSessions) == 1 ? [ current($userSessions), null ] : $userSessions;
    }

    /**
     * @param array $options
     * @return array|string
     * @throws \Pixie\Exception
     */
    public function createUserSession($options)
    {

        $data = [
            'fk_user_id'          => $options['userId'],
            'us_login_successful' => $options['success'],
        ];

        return $this->db->table('user_session')
            ->insert($data);
    }

    /**
     * @param $user
     * @return array
     * @throws \Pixie\Exception
     */
    public function getRoles($user)
    {
        $query = $this->db->table('user_role')
            ->join('role', 'role.r_id', '=', 'user_role.fk_role_id')
            ->select([
                'user_role.*',
                $this->db->raw('r_name AS ur_name'),
            ])
            ->where('fk_user_id', $user->getId());

        return $this->asObjects($query->get(), 'App\Entity\UserRole');
    }

}
