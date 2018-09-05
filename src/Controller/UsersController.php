<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Validation\Validator;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Login method
     * 
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        $this->layout = 'login';
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $idUser = $this->Auth->user('id');
                $userInfo = $this->Users->get($idUser);
                $userName = $userInfo['full_name'];
                $this->set(compact('userName'));
                return $this->redirect(['controller' => 'Users', 'action' => 'dashBoard']);
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }

    /**
     * Logout method
     * 
     * @return \Cake\Http\Response|void
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * [dashBoard description]
     * 
     * @return \Cake\Http\Response|void
     */
    public function dashBoard()
    {
        $this->layout = 'dashboard';
        $categoryModel = $this->loadModel('Category');
        $countCategory = $categoryModel->find()->count();
        $postModel = $this->loadModel('Posts');
        $countPost = $postModel->find()->count();
        $this->set(compact('countPost', 'countCategory'));
    }

    /**
     * List Category
     * 
     * @return \Cake\Http\Response|void
     */
    public function listCategory()
    {
        $this->layout = 'dashboard';
        $this->loadModel('Category');
        $arrayCategory = $this->Category->find()->contain(['Posts']);
        $this->set(compact('arrayCategory'));
    }

    /**
     * List Post
     * 
     * @return \Cake\Http\Response|void
     */
    public function listPost()
    {
        $this->layout = 'dashboard';
        $this->loadModel('Posts');
        $arrayPost = $this->paginate($this->Posts, array(
            'contain' => array('Category'), 
            'order' => array('Posts.created_at' => 'desc')
        ));
        $this->set(compact('arrayPost'));
    }

    /**
     * Insert new category to database
     *
     * @return \Cake\Http\Response|void
     */
    public function addCategory()
    {
        $dateNow = Time::now();
        $dateCreate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $this->layout = 'dashboard';
        $categoryModel = $this->loadModel('Category');
        $newCategory = $categoryModel->newEntity();
        if ($this->request->is('post')) {
            //validator
            $validatorForm = new Validator();
            $validatorForm
            ->requirePresence('category-name')
            ->notEmpty('category-name', 'Không được bỏ trống tên chuyên mục')
            ->requirePresence('category-slug')
            ->notEmpty('category-slug', 'Không được bỏ trống đường dẫn chuyên mục');
            $errorsValidator = $validatorForm->errors($this->request->getData());

            //insert category
            if (empty($errorsValidator)) {
                $newCategory->category_name = $this->request->getData('category-name');
                $newCategory->category_slug = $this->request->getData('category-slug');
                $newCategory->created_at = $dateCreate;
                $newCategory->updated_at = $dateCreate;
                if ($categoryModel->save($newCategory)) {
                    $this->Flash->success(__('Thêm chuyên mục thành công'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'addCategory']);
                }
                $this->Flash->error(__('Thêm chuyên mục thất bại. Vui lòng thử lại !'));
            }
        }
        $this->set(compact('errorsValidator'));
    }

    /**
     * Insert new post to database
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addPost()
    {
        $dateNow = Time::now();
        $dateCreate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $this->layout = 'dashboard';
        $categoryModel = $this->loadModel('Category')->find();
        $postModel = $this->loadModel('Posts');
        $newPost = $postModel->newEntity();
        if ($this->request->is('post')) {
            //validator
            $validatorForm = new Validator();
            $validatorForm
            ->requirePresence('post-title')
            ->notEmpty('post-title', 'Không được bỏ trống tên bài viết')
            ->requirePresence('post-slug')
            ->notEmpty('post-slug', 'Không được bỏ trống đường dẫn bài viết')
            ->requirePresence('post-image')
            ->notEmpty('post-image', 'Ảnh đại diện không được bỏ trống');
            $errorsValidator = $validatorForm->errors($this->request->getData());

            //insert post
            if (empty($errorsValidator)) {
                $newPost->category_id_fkey = $this->request->getData('post-category-add');
                $newPost->post_title = $this->request->getData('post-title');
                $newPost->post_slug = $this->request->getData('post-slug');
                $newPost->post_description = $this->request->getData('post-description');
                $newPost->post_content = $this->request->getData('post-content');
                $newPost->post_image = $this->request->getData('post-image');
                $newPost->post_view = 0;
                $newPost->post_status = 0;
                $newPost->created_at = $dateCreate;
                $newPost->updated_at = $dateCreate;
                if ($postModel->save($newPost)) {
                    $this->Flash->success(__('Thêm bài viết thành công'));
                    return $this->redirect(['controller' => 'Users', 'action' => 'addPost']);
                }
                $this->Flash->error(__('Thêm bài viết thất bại. Vui lòng thử lại !'));
            }
        }
        $this->set(compact('categoryModel', 'errorsValidator'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editPost($id = null)
    {
        $dateNow = Time::now();
        $dateUpdate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $this->layout = 'dashboard';
        $this->loadModel('Posts');
        $editPost = $this->Posts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //validator
            $validatorForm = new Validator();
            $validatorForm
            ->requirePresence('post-title')
            ->notEmpty('post-title', 'Không được bỏ trống tên bài viết')
            ->requirePresence('post-slug')
            ->notEmpty('post-slug', 'Không được bỏ trống đường dẫn bài viết');
            $errorsValidator = $validatorForm->errors($this->request->getData());

            //update post
            if (empty($errorsValidator)) {

                $dataImage = $this->request->getData('old-post-image');
                if($this->request->data['post-image']) {
                    $dataImage = $this->request->data['post-image'];
                }
                $arrayPost = array(
                    'category_id_fkey' => $this->request->getData('post-category-update'),
                    'post_title' => $this->request->getData('post-title'),
                    'post_slug' => $this->request->getData('post-slug'),
                    'post_description' => $this->request->getData('post-description'),
                    'post_content' => $this->request->getData('post-content'),
                    'post_image' => $dataImage,
                    'updated_at' => $dateUpdate
                );
                $postData = $this->Posts->patchEntity($editPost, $arrayPost);
                if ($this->Posts->save($postData)) {
                    $this->Flash->set(__('Sửa bài viết thành công'));
                    return $this->redirect(['action' => 'editPost/'.$id.'']);
                }
                $this->Flash->error(__('Sửa bài viết thất bại. Vui lòng thử lại !'));
            }
        }
        
        $this->loadModel('Category');
        $listCategory = $this->Category->find();
        $this->set(compact('editPost', 'listCategory', 'errorsValidator'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
