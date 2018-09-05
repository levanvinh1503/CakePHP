<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 */
class PostsTable extends Table
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
        $this->setTable('posts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Category')->setForeignKey('category_id_fkey')->setJoinType('INNER');
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
            ->nonNegativeInteger('category_id_fkey')
            ->requirePresence('category_id_fkey', 'create')
            ->notEmpty('category_id_fkey');

        $validator
            ->scalar('post_title')
            ->maxLength('post_title', 191)
            ->requirePresence('post_title', 'create')
            ->notEmpty('post_title');

        $validator
            ->scalar('post_description')
            ->maxLength('post_description', 16777215)
            ->requirePresence('post_description', 'create')
            ->notEmpty('post_description');

        $validator
            ->scalar('post_slug')
            ->maxLength('post_slug', 191)
            ->requirePresence('post_slug', 'create')
            ->notEmpty('post_slug')
            ->add('post_slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('post_content')
            ->requirePresence('post_content', 'create')
            ->notEmpty('post_content');

        $validator
            ->scalar('post_image')
            ->maxLength('post_image', 191)
            ->requirePresence('post_image', 'create')
            ->notEmpty('post_image');

        $validator
            ->integer('post_view')
            ->requirePresence('post_view', 'create')
            ->notEmpty('post_view');

        $validator
            ->scalar('post_status')
            ->maxLength('post_status', 191)
            ->requirePresence('post_status', 'create')
            ->notEmpty('post_status');

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
        $rules->add($rules->isUnique(['post_slug']));

        return $rules;
    }
}
