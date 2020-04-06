<?php

namespace App\Helpers;

class Mapping {
    const PAGE_MAPPING = [
        'p_id',
        'p_name',
        'p_formatted_name',
        'p_title',
        'p_url',
    ];

    const PAGE_ROLE_MAPPING = [
        'pr_id',
        'fk_page_id',
        'fk_role_id',
    ];

    const ROLE_MAPPING = [
        'r_id',
        'r_name',
    ];

    const USER_MAPPING = [
        'u_id',
        'u_username',
        'u_password',
        'u_login_attempts',
    ];

    const USER_ROLE_MAPPING = [
        'ur_id',
        'fk_user_id',
        'fk_role_id',
        'ur_name',
    ];

    const USER_SESSION_MAPPING = [
        'us_id',
        'fk_user_id',
        'us_created_at',
        'us_login_successful',
    ];
}
