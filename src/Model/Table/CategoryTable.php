<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Category Model
 *
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoryTable extends Table
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
        $this->hasMany('Posts')->setForeignKey('category_id_fkey');
        $this->setTable('category');
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
            ->scalar('category_name')
            ->maxLength('category_name', 191, 'Tên chuyên mục tối đa 191 kí tự')
            ->requirePresence('category_name', 'create')
            ->notEmpty('category_name', 'Tên chuyên mục không được bỏ trống')
            ->add('category_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Tên chuyên mục đã có']);
        
        $validator
            ->scalar('category_slug')
            ->maxLength('category_slug', 191)
            ->requirePresence('category_slug', 'create')
            ->notEmpty('category_slug', 'Đường dẫn chuyên mục không được bỏ trống')
            ->add('category_slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Trùng đường dẫn']);

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
        $rules->add($rules->isUnique(['category_name']));
        $rules->add($rules->isUnique(['category_slug']));

        return $rules;
    }
}
