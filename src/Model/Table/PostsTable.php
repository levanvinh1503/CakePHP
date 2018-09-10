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
            ->scalar('post_title')
            ->maxLength('post_title', 191, MAXLENGTH_POST_TITLE)
            ->requirePresence('post_title', 'create')
            ->notEmpty('post_title', REQUIRED_POST_TITLE)
            ->add('post_title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => UNIQUE_POST_TITLE]);

        $validator
            ->scalar('post_slug')
            ->maxLength('post_slug', 191, MAXLENGTH_POST_SLUG)
            ->requirePresence('post_slug', 'create')
            ->notEmpty('post_slug', REQUIRED_POST_SLUG)
            ->add('post_slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => UNIQUE_POST_SLUG]);
        $validator
            ->scalar('post_description')
            ->maxLength('post_description', 16777215, MAXLENGTH_POST_DESCRIPTION)
            ->requirePresence('post_description', 'create')
            ->notEmpty('post_description', REQUIRED_POST_DESCRIPTION);


        $validator
            ->scalar('post_content')
            ->requirePresence('post_content', 'create')
            ->notEmpty('post_content', REQUIRED_POST_CONTENT);

        $validator
            ->requirePresence('post_image', 'create')
            ->notEmpty('post_image', REQUIRED_POST_IMAGE);

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
        $rules->add($rules->isUnique(['post_title']));
        $rules->add($rules->isUnique(['post_slug']));

        return $rules;
    }
}
