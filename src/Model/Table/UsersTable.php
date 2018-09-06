<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 191, 'Tên đăng nhập tối đa 191 kí tự')
            ->requirePresence('username', 'create')
            ->notEmpty('username', 'Tên đăng nhập không được bỏ trống')
            ->add('username', 'unique', array('rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Tên đăng nhập đã có người sử dụng'));

        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 191, 'Họ tên tối đa 191 kí tự')
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name', 'Họ tên không được bỏ trống');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->maxLength('email', 191, 'Email tối đa 191 kí tự')
            ->notEmpty('email', 'Email không được bỏ trống')
            ->add('email', 'unique', array('rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Email đã có người sử dụng'));

        $validator
            ->scalar('password')
            ->maxLength('password', 191, 'Mật khẩu tối đa 191 kí tự')
            ->minLength('password', 8, 'Mật khẩu ít nhất 8 kí tự')
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Mật khẩu không được bỏ trống');

        $validator
            ->maxLength('re-password', 191, 'Mật khẩu tối đa 191 kí tự')
            ->requirePresence('re-password', 'create')
            ->notEmpty('re-password', 'Nhập lại mật khẩu không được bỏ trống')
            ->minLength('re-password', 8, 'Mật khẩu ít nhất 8 kí tự')
            ->add(
                're-password',
                'custom',
                array(
                    'rule' => function ($value, $context) {
                        if (isset($context['data']['password']) && $value == $context['data']['password']) {
                            return true;
                        }
                        return false;
                    },
                    'message' => 'Mật khẩu và xác nhận mật khẩu không khớp'
                )
            );

        $validator
            ->scalar('phonenumber')
            ->maxLength('phonenumber', 191, 'Số điện thoại tối đa 191 kí tự')
            ->requirePresence('phonenumber', 'create')
            ->notEmpty('phonenumber', 'Số điện thoại không được bỏ trống')
            ->numeric('phonenumber', 'Số điện thoại phải là số');

        $validator
            ->scalar('address')
            ->maxLength('address', 191, 'Địa chỉ tối đa 191 kí tự')
            ->requirePresence('address', 'create')
            ->notEmpty('address', 'Địa chỉ không được bỏ trống');

        $validator
            ->scalar('remember_token')
            ->maxLength('remember_token', 100)
            ->allowEmpty('remember_token');

        $validator
            ->dateTime('created_at')
            ->allowEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmpty('updated_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
