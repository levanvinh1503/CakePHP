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
            ->maxLength('username', 191, MAXLENGTH_USER_USERNAME)
            ->requirePresence('username', 'create')
            ->notEmpty('username', REQUIRED_USER_USERNAME)
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => UNIQUE_USER_USERNAME]);

        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 191, MAXLENGTH_USER_FULLNAME)
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name', REQUIRED_USER_FULLNAME);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->maxLength('email', 191, MAXLENGTH_USER_EMAIL)
            ->notEmpty('email', REQUIRED_USER_EMAIL)
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => UNIQUE_USER_EMAIL]);

        $validator
            ->scalar('password')
            ->maxLength('password', 191, MAXLENGTH_USER_PASSWORD)
            ->minLength('password', 8, MINLENGTH_USER_PASSWORD)
            ->requirePresence('password', 'create')
            ->notEmpty('password', REQUIRED_USER_PASSWORD);

        $validator
            ->maxLength('re-password', 191, MAXLENGTH_USER_RE_PASSWORD)
            ->requirePresence('re-password', 'create')
            ->notEmpty('re-password', REQUIRED_USER_RE_PASSWORD)
            ->minLength('re-password', 8, MINLENGTH_USER_RE_PASSWORD)
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
                    'message' => ADD_USER_RE_PASSWORD
                )
            );

        $validator
            ->scalar('phonenumber')
            ->maxLength('phonenumber', 191, MAXLENGTH_USER_PHONENUMBER)
            ->requirePresence('phonenumber', 'create')
            ->notEmpty('phonenumber', REQUIRED_USER_PHONENUMBER)
            ->numeric('phonenumber', NUMBER_USER_PHONENUMBER);

        $validator
            ->scalar('address')
            ->maxLength('address', 191, MAXLENGTH_USER_ADDRESS)
            ->requirePresence('address', 'create')
            ->notEmpty('address', REQUIRED_USER_ADDRESS);

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
