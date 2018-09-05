<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $category_id_fkey
 * @property string $post_title
 * @property string $post_description
 * @property string $post_slug
 * @property string $post_content
 * @property string $post_image
 * @property int $post_view
 * @property string $post_status
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 */
class Post extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'category_id_fkey' => true,
        'post_title' => true,
        'post_description' => true,
        'post_slug' => true,
        'post_content' => true,
        'post_image' => true,
        'post_view' => true,
        'post_status' => true,
        'created_at' => true,
        'updated_at' => true
    ];
}
