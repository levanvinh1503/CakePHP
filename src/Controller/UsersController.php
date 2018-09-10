<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Validation\Validator;
use Cake\Filesystem\File;
use Cake\ORM\Query;

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
     * Register user
     * 
     * @return \Cake\Http\Response|void
     */
    public function register()
    {
        $this->set('title', 'Đăng ký');
        $this->viewBuilder()->setLayout('login');
        $this->loadModel('Users');
        $dateNow = Time::now();
        $dateCreate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $newUser = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $messageValidation = '';
            //Validate form data
            $checkValidation = $this->Users->newEntity($this->request->getData());
            foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                    if (!empty($messageValidation)) {
                        $messageValidation .= "<br/>";
                    }
                    $messageValidation .= $valuekeyMessage;
                }
            }
            if (empty($messageValidation)) {
                $reqData = $this->request->getData();
                $reqData['created_at'] = $dateCreate;
                $reqData['updated_at'] = $dateCreate;
                $dataUser = $this->Users->patchEntity($newUser, $reqData);
                if ($this->Users->save($dataUser)) {
                    $this->Flash->success('Đăng ký thành công', array(
                        'key' => 'register',
                        'params' => array()
                    ));
                    return $this->redirect(array('controller' => 'Users', 'action' => 'register'));
                }
            } else {
                $this->Flash->error($messageValidation, array(
                    'key' => 'register',
                    'params' => array('escape' => false)
                ));
            }
        }
    }

    /**
     * Login method
     * 
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        $this->set('title', 'Đăng nhập');
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $idUser = $this->Auth->user('id');
                $userInfo = $this->Users->get($idUser);
                $userName = $userInfo['full_name'];
                $this->set(compact('userName'));
                return $this->redirect(array('controller' => 'Users', 'action' => 'dashBoard'));
            } else {
                $this->Flash->error('Sai tên đăng nhập hoặc mật khẩu, Vui lòng thử lại !', array(
                    'key' => 'login',
                    'params' => array()
                ));
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
     * Admin layout page
     * 
     * @return \Cake\Http\Response|void
     */
    public function dashBoard()
    {
        $this->set('title', 'Dash Board');
        $this->viewBuilder()->setLayout('dashboard');
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
        $this->set('title', 'Danh sách chuyên mục');
        $this->viewBuilder()->setLayout('dashboard');
        $this->loadModel('Category');
        $keySearch = trim($this->request->getQuery('search'), '%');
        //Get the keyword "search"
        $keyWord = '%' . $keySearch . '%';
        
        if ($this->request->is(array('post'))) {
            $keySearch = $this->request->getData('search');
            $keyWord = '%' . $keySearch . '%';
        }

        $arrayCategory = $this->paginate($this->Category->find()->where(array(
            'OR' => array(
                'category_name LIKE' => $keyWord,
                'category_slug LIKE' => $keyWord
            )
        )), array(
            'limit' => 2,
            'contain' => array('Posts')
        ));

        if ($this->request->is(array('post'))) {
            $this->redirect(array('controller' => 'Users', 'action' => 'listCategory', 'search' => $keyWord));
            $this->set(compact('arrayCategory'));
        }
        $this->set(compact('arrayCategory', 'keySearch'));
    }

    /**
     * List Post
     * 
     * @return \Cake\Http\Response|void
     */
    public function listPost()
    {
        $this->set('title', 'Danh sách bài viết');
        $this->viewBuilder()->setLayout('dashboard');
        $this->loadModel('Posts');
        $keySearch = trim($this->request->getQuery('search'), '%');
        //Get the keyword "search"
        $keyWord = '%' . $keySearch . '%';
        //get keyword submit form
        if ($this->request->is(array('post'))) {
            $keySearch = $this->request->getData('search');
            $keyWord = '%' . $keySearch . '%';
        }

        $arrayPost = $this->paginate($this->Posts->find()->where(array(
            'OR' => array(
                'Category.category_name LIKE' => $keyWord,
                'Posts.post_title LIKE' => $keyWord
            )
        )), array(
            'limit' => 5,
            'contain' => array('Category')
        ));

        if ($this->request->is(array('post'))) {
            $this->redirect(array('controller' => 'Users', 'action' => 'listPost', 'search' => $keyWord));
            $this->set(compact('arrayPost'));
        }

        $this->set(compact('arrayPost', 'keySearch'));
    }

    /**
     * Insert new category to database
     *
     * @return \Cake\Http\Response|void
     */
    public function addCategory()
    {
        $this->set('title', 'Thêm chuyên mục');
        $this->viewBuilder()->setLayout('dashboard');
        $dateNow = Time::now();
        $dateCreate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $categoryModel = $this->loadModel('Category');
        $newCategory = $categoryModel->newEntity();
        if ($this->request->is('post')) {
            //validator
            $messageValidation = '';
            //Validate form data
            $checkValidation = $categoryModel->newEntity($this->request->getData());
            foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                    if (!empty($messageValidation)) {
                        $messageValidation .= "<br/>";
                    }
                    $messageValidation .= $valuekeyMessage;
                }
            }

            //insert category
            if (empty($messageValidation)) {
                $reqData = $this->request->getData();
                $reqData['created_at'] = $dateCreate;
                $reqData['updated_at'] = $dateCreate;
                $strCateName = htmlentities($this->request->getData('category_name'), ENT_COMPAT, 'UTF-8');
                $strCateSlug= htmlentities($this->request->getData('category_slug'), ENT_COMPAT, 'UTF-8');
                $reqData['category_name'] = htmlentities($strCateName, ENT_COMPAT, 'UTF-8');
                $reqData['category_slug'] = htmlentities($strCateSlug, ENT_COMPAT, 'UTF-8');

                $dataCategory = $this->Category->patchEntity($newCategory, $reqData);
                if ($categoryModel->save($dataCategory)) {
                    $this->Flash->success('Thêm chuyên mục thành công', array(
                        'key' => 'add-category',
                        'params' => array()
                    ));
                    return $this->redirect(array('controller' => 'Users', 'action' => 'addCategory'));
                } else {
                    $this->Flash->error('Thêm chuyên mục thất bại, vui lòng thử lại !', array(
                        'key' => 'add-category',
                        'params' => array()
                    ));
                }
            } else {
                $this->Flash->error($messageValidation, array(
                    'key' => 'add-category',
                    'params' => array('escape' => false)
                ));
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
        $this->set('title', 'Thêm bài viết');
        $this->viewBuilder()->setLayout('dashboard');
        $dateNow = Time::now();
        $dateCreate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $categoryModel = $this->loadModel('Category')->find();
        $postModel = $this->loadModel('Posts');
        $newPost = $postModel->newEntity();
        if ($this->request->is('post')) {
            //validator
            $messageValidation = '';
            //Validate form data
            $checkValidation = $postModel->newEntity($this->request->getData());
            foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                    if (!empty($messageValidation)) {
                        $messageValidation .= "<br/>";
                    }
                    $messageValidation .= $valuekeyMessage;
                }
            }
            //insert post
            if (empty($messageValidation)) {
                $reqData = $this->request->getData();
                $reqData['created_at'] = $dateCreate;
                $reqData['updated_at'] = $dateCreate;
                $fileName = $this->request->getData('post_image');
                $filePath = WWW_ROOT . 'img\\' . $fileName['name'];
                move_uploaded_file($fileName['tmp_name'], $filePath);
                $reqData['post_image'] = $fileName['name'];

                $strPostTitle = htmlentities($this->request->getData('post_title'), ENT_COMPAT, 'UTF-8');
                $strPostSlug= htmlentities($this->request->getData('post_slug'), ENT_COMPAT, 'UTF-8');
                $strPostDescription= htmlentities($this->request->getData('post_description'), ENT_COMPAT, 'UTF-8');

                $reqData['post_title'] = htmlentities($strPostTitle, ENT_COMPAT, 'UTF-8');
                $reqData['post_slug'] = htmlentities($strPostSlug, ENT_COMPAT, 'UTF-8');
                $reqData['post_description'] = htmlentities($strPostDescription, ENT_COMPAT, 'UTF-8');

                $datePost = $this->Posts->patchEntity($newPost, $reqData);
                if ($postModel->save($datePost)) {
                    $this->Flash->success('Thêm bài viết thành công', array(
                        'key' => 'add-post',
                        'params' => array()
                    ));
                    return $this->redirect(array('controller' => 'Users', 'action' => 'addPost'));
                }
                $this->Flash->error('Thêm bài viết thất bại. Vui lòng thử lại !', array(
                    'key' => 'add-post',
                    'params' => array()
                ));
            } else {
                $this->Flash->error($messageValidation, array(
                    'key' => 'add-post',
                    'params' => array('escape' => false)
                ));
            }
        }
        $this->set(compact('categoryModel', 'errorsValidator'));
    }

    /**
     * Edit the catalog into the database
     * 
     * @param  string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editCategory($id = null)
    {
        $this->set('title', 'Chỉnh sửa chuyên mục');
        $this->viewBuilder()->setLayout('dashboard');
        $dateNow = Time::now();
        $dateUpdate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $this->loadModel('Category');
        $editCategory = $this->Category->get($id, array(
            'contain' => array()
        ));
        if ($this->request->is(array('patch', 'post', 'put'))) {

            //update category
            $arrayCategory = $this->request->getData();
            $arrayCategory['updated_at'] = $dateUpdate;

            $categoryData = $this->Category->patchEntity($editCategory, $arrayCategory);

            if ($this->Category->save($categoryData)) {
                $this->Flash->success('Sửa chuyên mục thành công', array(
                    'key' => 'edit-category',
                    'params' => array()
                ));
                return $this->redirect(array('action' => 'editCategory/'.$id.''));
            } else {
                //validator
                $messageValidation = '';
                //Validate form data
                $checkValidation = $this->Category->newEntity($this->request->getData());
                foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                    foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                        if (!empty($messageValidation)) {
                            $messageValidation .= "<br/>";
                        }
                        $messageValidation .= $valuekeyMessage;
                    }
                }

                $this->Flash->error($messageValidation, array(
                    'key' => 'edit-category',
                    'params' => array('escape' => false)
                ));
            }
        }

        $this->set(compact('editCategory', 'errorsValidator'));
    }

    /**
     * Edit the post into the database
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editPost($id = null)
    {
        $this->set('title', 'Chỉnh sửa bài viết');
        $this->viewBuilder()->setLayout('dashboard');
        $dateNow = Time::now();
        $dateUpdate = $dateNow->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $this->loadModel('Posts');
        $editPost = $this->Posts->get($id, array(
            'contain' => array()
        ));
        if ($this->request->is(array('patch', 'post', 'put'))) {
            $arrayPost = $this->request->getData();
            $arrayPost['updated_at'] = $dateUpdate;
            $fileName = $this->request->getData('post-image');
            if (!empty($fileName['name'])) {
                $filePath = WWW_ROOT . 'img\\' . $fileName['name'];
                move_uploaded_file($fileName['tmp_name'], $filePath);
                $arrayPost['post_image'] = $fileName['name'];
            }
            $postData = $this->Posts->patchEntity($editPost, $arrayPost);
            if ($this->Posts->save($postData)) {
                $this->Flash->success('Sửa bài viết thành công', array(
                    'key' => 'edit-post',
                    'params' => array()
                ));
                return $this->redirect(array('action' => 'editPost/'.$id.''));
            } else {
                //validator
                $messageValidation = '';
                //Validate form data
                $checkValidation = $this->Posts->newEntity($this->request->getData());
                foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                    foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                        if (!empty($messageValidation)) {
                            $messageValidation .= "<br/>";
                        }
                        $messageValidation .= $valuekeyMessage;
                    }
                }
                $this->Flash->success($messageValidation, array(
                    'key' => 'edit-post',
                    'params' => array('escape' => false)
                ));
            }
        }
        
        $this->loadModel('Category');
        $listCategory = $this->Category->find();
        $this->set(compact('editPost', 'listCategory', 'errorsValidator'));
    }

    /**
     * Delete category method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteCategory()
    {
        $this->request->allowMethod(array('post', 'delete'));
        $idCategory = $this->request->getData('category-id');
        $this->loadModel('Category');
        $deleteCategory = $this->Category->get($idCategory);
        if ($this->Category->delete($deleteCategory)) {
            $this->Flash->success('Xóa chuyên mục thành công', array(
                'key' => 'delete-category',
                'params' => array()
            ));
        } else {
            $this->Flash->error('Xóa chuyên mục thất bại. Vui lòng thử lại !', array(
                'key' => 'delete-category',
                'params' => array()
            ));

        }

        return $this->redirect(array('action' => 'listCategory'));
    }

    /**
     * Delete post method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deletePost()
    {
        $this->request->allowMethod(array('post', 'delete'));
        $idPost = $this->request->getData('post-id');
        $this->loadModel('Posts');
        $deletePost = $this->Posts->get($idPost);
        if ($this->Posts->delete($deletePost)) {
            $this->Flash->success('Xóa bài viết thành công', array(
                'key' => 'delete-post',
                'params' => array()
            ));
        } else {
            $this->Flash->error('Xóa bài viết thất bại, vui lòng thử lại !', array(
                'key' => 'delete-post',
                'params' => array()
            ));
        }

        return $this->redirect(array('action' => 'listPost'));
    }
}
