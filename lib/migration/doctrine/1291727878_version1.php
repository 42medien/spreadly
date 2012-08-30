<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version1 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('cms_category_translation');
        $this->dropTable('cms_translation');
        $this->dropTable('cms');
        $this->dropTable('cms_category');
        $this->createTable('coupon', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'deal_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'code' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('deal', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'domain_profile_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'sf_guard_user_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'type' => 
             array(
              'type' => 'enum',
              'length' => '10',
              'default' => 'commercial',
              'values' => 
              array(
              0 => 'commercial',
              1 => 'charity',
              ),
             ),
             'coupon_type' => 
             array(
              'type' => 'enum',
              'length' => '10',
              'default' => 'single',
              'values' => 
              array(
              0 => 'single',
              1 => 'multiple',
              ),
             ),
             'coupon_quantity' => 
             array(
              'type' => 'integer',
              'default' => '0',
              'length' => '8',
             ),
             'coupon_claimed_quantity' => 
             array(
              'type' => 'integer',
              'default' => '0',
              'length' => '8',
             ),
             'start_date' => 
             array(
              'type' => 'timestamp',
              'length' => '',
             ),
             'end_date' => 
             array(
              'type' => 'timestamp',
              'length' => '',
             ),
             'summary' => 
             array(
              'type' => 'string',
              'length' => '40',
             ),
             'description' => 
             array(
              'type' => 'string',
              'length' => '80',
             ),
             'button_wording' => 
             array(
              'type' => 'string',
              'length' => '35',
             ),
             'terms_of_deal' => 
             array(
              'type' => 'string',
              'length' => '512',
             ),
             'redeem_url' => 
             array(
              'type' => 'string',
              'length' => '512',
             ),
             'tos_accepted' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'deal_state' => 
             array(
              'default' => 'submitted',
              'values' => 
              array(
              0 => 'submitted',
              1 => 'approved',
              2 => 'denied',
              3 => 'trashed',
              4 => 'paused',
              ),
              'type' => 'enum',
              'length' => '',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('domain_profile', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'url' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'protocol' => 
             array(
              'type' => 'enum',
              'length' => '5',
              'default' => 'http',
              'values' => 
              array(
              0 => 'http',
              1 => 'https',
              ),
             ),
             'state' => 
             array(
              'type' => 'enum',
              'length' => '10',
              'default' => 'pending',
              'values' => 
              array(
              0 => 'pending',
              1 => 'verified',
              ),
             ),
             'verification_token' => 
             array(
              'type' => 'string',
              'unique' => '1',
              'length' => '255',
             ),
             'verification_count' => 
             array(
              'type' => 'integer',
              'default' => '0',
              'length' => '8',
             ),
             'sf_guard_user_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'imprint_url' => 
             array(
              'type' => 'string',
              'length' => '512',
             ),
             'tos_url' => 
             array(
              'type' => 'string',
              'length' => '512',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('supported_services', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'name' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'slug' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'url' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'tutorial_url' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'download_url' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('visit', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'host' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'uri' => 
             array(
              'type' => 'string',
              'length' => '',
             ),
             'cult' => 
             array(
              'type' => 'string',
              'length' => '5',
             ),
             'is_like' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'is_dislike' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'c' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_forgot_password', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'unique_key' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'expires_at' => 
             array(
              'type' => 'timestamp',
              'notnull' => '1',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_group', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'name' => 
             array(
              'type' => 'string',
              'unique' => '1',
              'length' => '255',
             ),
             'description' => 
             array(
              'type' => 'string',
              'length' => '1000',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_group_permission', array(
             'group_id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '8',
             ),
             'permission_id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '8',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'group_id',
              1 => 'permission_id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_permission', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'name' => 
             array(
              'type' => 'string',
              'unique' => '1',
              'length' => '255',
             ),
             'description' => 
             array(
              'type' => 'string',
              'length' => '1000',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_remember_key', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'remember_key' => 
             array(
              'type' => 'string',
              'length' => '32',
             ),
             'ip_address' => 
             array(
              'type' => 'string',
              'length' => '50',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_user', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'first_name' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'last_name' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'email_address' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'unique' => '1',
              'length' => '255',
             ),
             'username' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'unique' => '1',
              'length' => '128',
             ),
             'algorithm' => 
             array(
              'type' => 'string',
              'default' => 'sha1',
              'notnull' => '1',
              'length' => '128',
             ),
             'salt' => 
             array(
              'type' => 'string',
              'length' => '128',
             ),
             'password' => 
             array(
              'type' => 'string',
              'length' => '128',
             ),
             'is_active' => 
             array(
              'type' => 'boolean',
              'default' => '1',
              'length' => '25',
             ),
             'is_super_admin' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'last_login' => 
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'indexes' => 
             array(
              'is_active_idx' => 
              array(
              'fields' => 
              array(
               0 => 'is_active',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_user_group', array(
             'user_id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '8',
             ),
             'group_id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '8',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'user_id',
              1 => 'group_id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_user_permission', array(
             'user_id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '8',
             ),
             'permission_id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '8',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'user_id',
              1 => 'permission_id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->createTable('sf_guard_user_profile', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'email' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'unique' => '1',
              'length' => '80',
             ),
             'email_new' => 
             array(
              'type' => 'string',
              'unique' => '1',
              'length' => '80',
             ),
             'firstname' => 
             array(
              'type' => 'string',
              'length' => '30',
             ),
             'lastname' => 
             array(
              'type' => 'string',
              'length' => '70',
             ),
             'validate_at' => 
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'validate' => 
             array(
              'type' => 'string',
              'length' => '33',
             ),
             'tos_accepted' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'indexes' => 
             array(
              'user_id_unique' => 
              array(
              'fields' => 
              array(
               0 => 'user_id',
              ),
              'type' => 'unique',
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'UTF8',
             ));
        $this->addColumn('yiid_activity', 'd_id', 'integer', '4', array(
             ));
        $this->addColumn('yiid_activity', 'c_code', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->createTable('cms', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'category_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'page' => 
             array(
              'type' => 'string',
              'length' => '64',
             ),
             'link' => 
             array(
              'type' => 'string',
              'length' => '512',
             ),
             'active' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('cms_category', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'page' => 
             array(
              'type' => 'string',
              'length' => '64',
             ),
             'footer' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('cms_translation', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'primary' => '1',
             ),
             'headline' => 
             array(
              'type' => 'string',
              'length' => '128',
             ),
             'text' => 
             array(
              'type' => 'string',
              'length' => '512',
             ),
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('cms_category_translation', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'primary' => '1',
             ),
             'title' => 
             array(
              'type' => 'string',
              'length' => '128',
             ),
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->dropTable('coupon');
        $this->dropTable('deal');
        $this->dropTable('domain_profile');
        $this->dropTable('supported_services');
        $this->dropTable('visit');
        $this->dropTable('sf_guard_forgot_password');
        $this->dropTable('sf_guard_group');
        $this->dropTable('sf_guard_group_permission');
        $this->dropTable('sf_guard_permission');
        $this->dropTable('sf_guard_remember_key');
        $this->dropTable('sf_guard_user');
        $this->dropTable('sf_guard_user_group');
        $this->dropTable('sf_guard_user_permission');
        $this->dropTable('sf_guard_user_profile');
        $this->removeColumn('yiid_activity', 'd_id');
        $this->removeColumn('yiid_activity', 'c_code');
    }
}