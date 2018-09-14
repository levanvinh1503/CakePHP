<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Validation\Validator;
use Cake\Filesystem\File;
use Cake\ORM\Query;
use Cake\Datasource\ConnectionManager;
use Cake\Collection\Collection;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('FunctionLb');
    }
    /**
     * Register user
     * 
     * @return \Cake\Http\Response|void
     */
    public function register()
    {
        //Use layout Layout/login.ctp
        $this->viewBuilder()->setLayout('login');
        //Load model Users
        $this->loadModel('Users');

        //Get the current time and format datetime
        $dateCreate = $this->FunctionLb->getCurrentTime();
        //Create a new user entity
        $newUser = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $messageValidation = '';
            //Validate form data
            $checkValidation = $this->Users->newEntity($this->request->getData());
            //Show message validation
            foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                    if (!empty($messageValidation)) {
                        $messageValidation .= "<br/>";
                    }
                    $messageValidation .= $valuekeyMessage;
                }
            }

            //
            if (empty($messageValidation)) {
                //Get data
                $reqData = $this->request->getData();

                //Set the creation and update date of the entity
                $reqData['created_at'] = $dateCreate;
                $reqData['updated_at'] = $dateCreate;

                //Merges the passed data
                $dataUser = $this->Users->patchEntity($newUser, $reqData);

                //Add a new user entity
                if ($this->Users->save($dataUser)) {
                    //Set messages success
                    $this->Flash->success(MS_REGISTER_SUCCESS, [
                        'key' => 'register',
                        'params' => []
                    ]);

                    //Redirect Users/register.ctp
                    return $this->redirect(['controller' => 'Users', 'action' => 'register']);
                }
            } else {
                //Set messages errors validate
                $this->Flash->error($messageValidation, [
                    'key' => 'register',
                    'params' => ['escape' => false]
                ]);
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
        //Use layout Layout/login.ctp
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->set(compact('userName'));

                return $this->redirect(['controller' => 'Users', 'action' => 'dashBoard']);
            } else {
                $this->Flash->error(MS_LOGIN_ERR, [
                    'key' => 'login',
                    'params' => []
                ]);
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
        //Use layout Layout/dashboard.ctp
        $this->viewBuilder()->setLayout('dashboard');
        //Load model Category
        $categoryModel = $this->loadModel('Category');
        $countCategory = $categoryModel->find()->count();
        //Load model Posts
        $postModel = $this->loadModel('Posts');
        $countPost = $postModel->find()->count();

        //Set data to view
        $this->set(compact('countPost', 'countCategory'));
    }

    /**
     * List Category
     * 
     * @return \Cake\Http\Response|void
     */
    public function listCategory()
    {
        //Use layout Layout/dashboard.ctp
        $this->viewBuilder()->setLayout('dashboard');
        //Load model Category
        $this->loadModel('Category');
        //Get the keyword "search"
        $keySearch = trim($this->request->getQuery('search'), '%');
        //Set keyword
        $keyWord = '%' . $keySearch . '%';
        //Get, set keyword submit form search
        if ($this->request->is(['post'])) {
            $keySearch = $this->request->getData('search');
            $keyWord = '%' . $keySearch . '%';
        }

        //Search by keyword
        $arrayCategory = $this->paginate($this->Category->find()->where([
            'OR' => [
                'category_name LIKE' => $keyWord,
                'category_slug LIKE' => $keyWord
            ]
        ]), [
            'limit' => 2,
            'contain' => ['Posts']
        ]);

        //Redirect page with keyword
        if ($this->request->is(['post'])) {
            $this->redirect(['controller' => 'Users', 'action' => 'listCategory', 'search' => $keyWord]);
            $this->set(compact('arrayCategory'));
        }

        //Set data to view
        $this->set(compact('arrayCategory', 'keySearch'));
    }

    /**
     * List Post
     * 
     * @return \Cake\Http\Response|void
     */
    public function listPost()
    {
        //Use layout Layout/dashboard;
        $this->viewBuilder()->setLayout('dashboard');
        //Load model Posts
        $this->loadModel('Posts');
        //Cut the % character in the keyword
        $keySearch = trim($this->request->getQuery('search'), '%');
        //Get the keyword "search"
        $keyWord = '%' . $keySearch . '%';
        //Get, set keyword submit form search
        if ($this->request->is(['post'])) {
            $keySearch = $this->request->getData('search');
            $keyWord = '%' . $keySearch . '%';
        }

        //Search by keyword
        $arrayPost = $this->paginate($this->Posts->find()->where([
            'OR' => [
                'Category.category_name LIKE' => $keyWord,
                'Posts.post_title LIKE' => $keyWord
            ]
        ]), [
            'limit' => 5,
            'contain' => ['Category']
        ]);

        //Redirect page with keyword
        if ($this->request->is(['post'])) {
            $this->redirect(['controller' => 'Users', 'action' => 'listPost', 'search' => $keyWord]);
            $this->set(compact('arrayPost'));
        }

        //Set data to view
        $this->set(compact('arrayPost', 'keySearch'));
    }

    /**
     * Insert new category to database
     *
     * @return \Cake\Http\Response|void
     */
    public function addCategory()
    {
        //Use layout Layout/dashboard.ctp
        $this->viewBuilder()->setLayout('dashboard');
        //Get the current time and Format datetime
        $dateCreate = $this->FunctionLb->getCurrentTime();
        //Load model Category
        $categoryModel = $this->loadModel('Category');
        //Create a new Entity
        $newCategory = $categoryModel->newEntity();
        if ($this->request->is('post')) {
            //validator
            $messageValidation = '';
            //Validate form data
            $checkValidation = $categoryModel->newEntity($this->request->getData());
            //Show message
            foreach ($checkValidation->errors() as $keyArray => $itemArray) {
                foreach ($itemArray as $keyMessage => $valuekeyMessage) {
                    if (!empty($messageValidation)) {
                        $messageValidation .= "<br/>";
                    }
                    $messageValidation .= $valuekeyMessage;
                }
            }

            //Add a new category
            if (empty($messageValidation)) {
                //Get data
                $reqData = $this->request->getData();
                //Set the creation and update date of the entity
                $reqData['created_at'] = $dateCreate;
                $reqData['updated_at'] = $dateCreate;
                //Converts characters to HTML entities
                $reqData['category_name'] = $this->FunctionLb->convertEntity($this->request->getData('category_name'));
                $reqData['category_slug'] = $this->FunctionLb->convertEntity($this->request->getData('category_slug'));
                //Merges the passed data
                $dataCategory = $this->Category->patchEntity($newCategory, $reqData);
                //Add a new category
                if ($categoryModel->save($dataCategory)) {
                    //Set message success
                    $this->Flash->success(MS_ADD_CATEGORY_SUCCESS, [
                        'key' => 'add-category',
                        'params' => []
                    ]);

                    return $this->redirect(['controller' => 'Users', 'action' => 'addCategory']);
                } else {
                    //Set message errors
                    $this->Flash->error(MS_ADD_CATEGORY_ERR, [
                        'key' => 'add-category',
                        'params' => []
                    ]);
                }
            } else {
                //Set message errors validate
                $this->Flash->error($messageValidation, [
                    'key' => 'add-category',
                    'params' => ['escape' => false]
                ]);
            }
        }

        //Set data to view
        $this->set(compact('errorsValidator'));
    }

    /**
     * Insert new post to database
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addPost()
    {
        //Use layout Layout/dashboard.ctp
        $this->viewBuilder()->setLayout('dashboard');
        //Get the current time and Format time
        $dateCreate = $this->FunctionLb->getCurrentTime();
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
            //Add a new post
            if (empty($messageValidation)) {
                //Get data
                $reqData = $this->request->getData();
                //Set the creation and update date of the entity
                $reqData['created_at'] = $dateCreate;
                $reqData['updated_at'] = $dateCreate;

                //Get image
                $fileName = $this->request->getData('post_image');
                $filePath = WWW_ROOT . 'img\\' . $fileName['name'];

                //Move image to webroot/img
                move_uploaded_file($fileName['tmp_name'], $filePath);

                $reqData['post_image'] = $fileName['name'];
                //Converts characters to HTML entities
                $reqData['post_title'] = $this->FunctionLb->convertEntity($this->request->getData('post_title'));
                $reqData['post_slug'] = $this->FunctionLb->convertEntity($this->request->getData('post_slug'));
                $reqData['post_description'] = $this->FunctionLb->convertEntity($this->request->getData('post_description'));
                //Merges the passed data
                $datePost = $this->Posts->patchEntity($newPost, $reqData);
                //Add a new post
                if ($postModel->save($datePost)) {
                    //Set message success
                    $this->Flash->success(MS_ADD_POST_SUCCESS, [
                        'key' => 'add-post',
                        'params' => []
                    ]);
                    return $this->redirect(['controller' => 'Users', 'action' => 'addPost']);
                } else {
                    //Set message error
                    $this->Flash->error(MS_ADD_POST_ERR, [
                        'key' => 'add-post',
                        'params' => []
                    ]);
                }
            } else {
                //Set message errors
                $this->Flash->error($messageValidation, [
                    'key' => 'add-post',
                    'params' => ['escape' => false]
                ]);
            }
        }
        //Set data to view
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
        //Use layout Layout/dashboard
        $this->viewBuilder()->setLayout('dashboard');
        //Get the current time and format datetime
        $dateUpdate = $this->FunctionLb->getCurrentTime();
        //Load model Category
        $this->loadModel('Category');
        //Get data with id = $id
        $editCategory = $this->Category->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //Get data
            $arrayCategory = $this->request->getData();
            $arrayCategory['updated_at'] = $dateUpdate;
            //Converts characters to HTML entities
            $arrayCategory['category_name'] = $this->FunctionLb->convertEntity($this->request->getData('category_name'));
            $arrayCategory['category_slug'] = $this->FunctionLb->convertEntity($this->request->getData('category_slug'));
            //Merges the passed data
            $categoryData = $this->Category->patchEntity($editCategory, $arrayCategory);
            //Update a category
            if ($this->Category->save($categoryData)) {
                //Set message success
                $this->Flash->success(MS_EDIT_CATEGORY_SUCCESS, [
                    'key' => 'edit-category',
                    'params' => []
                ]);
                return $this->redirect(['action' => 'editCategory/'.$id.'']);
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
                //Set message errors
                $this->Flash->error($messageValidation, [
                    'key' => 'edit-category',
                    'params' => ['escape' => false]
                ]);
            }
        }
        //Set data to view
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
        //Use layout Layout/dashboard
        $this->viewBuilder()->setLayout('dashboard');
        //Get the current time and format datetime
        $dateUpdate = $this->FunctionLb->getCurrentTime();
        //Load model Category
        $this->loadModel('Category');
        $listCategory = $this->Category->find();
        //Load model Posts
        $this->loadModel('Posts');
        //Get data with id = $id
        $editPost = $this->Posts->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            //Get data from form
            $arrayPost = $this->request->getData();
            //Set the creation and update date of the entity
            $arrayPost['updated_at'] = $dateUpdate;
            //Converts characters to HTML entities
            $arrayPost['post_title'] = $this->FunctionLb->convertEntity($this->request->getData('post_title'));
            $arrayPost['post_slug'] = $this->FunctionLb->convertEntity($this->request->getData('post_slug'));
            $arrayPost['post_description'] = $this->FunctionLb->convertEntity($this->request->getData('post_description'));
            $fileName = $this->request->getData('post-image');
            //Check upload file
            if (!empty($fileName['name'])) {
                $filePath = WWW_ROOT . 'img\\' . $fileName['name'];
                //Move image to webroot/img
                move_uploaded_file($fileName['tmp_name'], $filePath);
                $arrayPost['post_image'] = $fileName['name'];
            }
            //Merges the passed data
            $postData = $this->Posts->patchEntity($editPost, $arrayPost);
            //Update a post
            if ($this->Posts->save($postData)) {
                //Set message success
                $this->Flash->success(MS_EDIT_POST_SUCCESS, [
                    'key' => 'edit-post',
                    'params' => []
                ]);
                return $this->redirect(['action' => 'editPost/'.$id.'']);
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
                //Set message errors
                $this->Flash->success($messageValidation, [
                    'key' => 'edit-post',
                    'params' => ['escape' => false]
                ]);
            }
        }

        //Set data to view
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
        //Check the method post or delte
        $this->request->allowMethod(['post', 'delete']);
        //Get id category
        $idCategory = $this->request->getData('category-id');
        //Load model Category
        $this->loadModel('Category');
        //Get data with id = $idCategory
        $deleteCategory = $this->Category->get($idCategory);
        //Delete a category
        if ($this->Category->delete($deleteCategory)) {
            //Set message success
            $this->Flash->success(MS_DELETE_CATEGORY_SUCCESS, [
                'key' => 'delete-category',
                'params' => []
            ]);
        } else {
            //Set message error
            $this->Flash->error(MS_DELETE_CATEGORY_ERR, [
                'key' => 'delete-category',
                'params' => []
            ]);

        }

        return $this->redirect(['action' => 'listCategory']);
    }

    /**
     * Delete post method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deletePost()
    {
        //Check the method post or delte
        $this->request->allowMethod(['post', 'delete']);
        //Get id post
        $idPost = $this->request->getData('post-id');
        //Load model posts
        $this->loadModel('Posts');
        //Get data with id = $idPost
        $deletePost = $this->Posts->get($idPost);
        //Delete post
        if ($this->Posts->delete($deletePost)) {
            //Set message success
            $this->Flash->success(MS_DELETE_POST_SUCCESS, [
                'key' => 'delete-post',
                'params' => []
            ]);
        } else {
            //Set message error
            $this->Flash->error(MS_DELETE_POST_ERR, [
                'key' => 'delete-post',
                'params' => []
            ]);
        }

        return $this->redirect(['action' => 'listPost']);
    }

    public function listUser()
    {
        //Use layout Layout/dashboard.ctp
        $this->viewBuilder()->setLayout('dashboard');
        //Load model Category
        $this->loadModel('TblStaff');
        //Get the keyword "search"
        $keySearch = trim($this->request->getQuery('search'), '%');
        //Set keyword
        $keyWord = '%' . $keySearch . '%';
        //Get, set keyword submit form search
        if ($this->request->is(['post'])) {
            $modePost = $this->request->getData('mode');
            if ($modePost === 'search') {
                $keySearch = $this->request->getData('search');
                $keyWord = '%' . $keySearch . '%';
            }
        }

        //Search by keyword
        $arrayUsers = $this->paginate($this->TblStaff->find()->where([
            'OR' => [
                'id LIKE' => $keyWord,
                'name LIKE' => $keyWord,
                'address LIKE' => $keyWord,
                'email LIKE' => $keyWord,
            ]
        ]), [
            'limit' => 50,
        ]);

        //Redirect page with keyword
        if ($this->request->is(['post'])) {
            $modePost = $this->request->getData('mode');
            //Search
            if ($modePost === 'search') {
                $this->redirect(['controller' => 'Users', 'action' => 'listUser', 'search' => $keyWord]);
                $this->set(compact('arrayUsers'));
            }
            //Import file
            if ($modePost === 'import-file') {
                $messageValidate = "";
                //Get file
                $fileImport = $this->request->getData('import-file');
                //Get extension file
                $extFile = pathinfo($fileImport['name'], PATHINFO_EXTENSION);
                if (!empty($fileImport['tmp_name']) && $extFile == 'csv') {
                    //Open file
                    $fileHandle = fopen($fileImport['tmp_name'], 'r');
                    //Get header file
                    $headerFile = fgetcsv($fileHandle);
                    $headerDefault = ['ID', 'Name', 'Email', 'Address'];
                    //Check header file
                    $checkFormatFile = array_diff($headerFile, $headerDefault);
                    //Close file
                    fclose($fileHandle);
                    //Check format file
                    if (!empty($checkFormatFile)) {
                        $this->Flash->error(FORMAT_ERR, [
                            'key' => 'import-file',
                            'params' => [
                                'escape' => false
                            ]
                        ]);
                    } else {
                        //Connect DB
                        $connectDB = ConnectionManager::get('default');
                        //Set auto_increment = 2
                        $connectDB->execute("ALTER TABLE tmp_tbl_staff AUTO_INCREMENT = 2");
                        //Load data file into temp table
                        $connectDB->execute("LOAD DATA INFILE '".$fileImport['name']."' INTO TABLE tmp_tbl_staff FIELDS TERMINATED BY ',' IGNORE 1 LINES");
                        //Check validate duplicate column id
                        $messageValidate .= $this->FunctionLb->validateDuplicate($connectDB, 'tmp_tbl_staff', 'id');
                        //Check validate maxlenght column id
                        $messageValidate .= $this->FunctionLb->validateLenght($connectDB, 'tmp_tbl_staff', 11, 'id');
                        //Check validate numeric column id
                        $messageValidate .= $this->FunctionLb->validateNumeric($connectDB, 'tmp_tbl_staff', 'id');
                        //Check validate duplicate column email
                        $messageValidate .= $this->FunctionLb->validateDuplicate($connectDB, 'tmp_tbl_staff', 'email');
                        //Check validate maxlenght column email
                        $messageValidate .= $this->FunctionLb->validateLenght($connectDB, 'tmp_tbl_staff', 100, 'email');
                        //Check validate format of column email
                        $messageValidate .= $this->FunctionLb->validateEmail($connectDB, 'tmp_tbl_staff', 'email');
                        //Insert data into table tbl_staff
                        if (empty($messageValidate)) {
                            $connectDB->execute("TRUNCATE TABLE tbl_staff");
                            //Insert data into table tbl_staff
                            $connectDB->execute("INSERT INTO tbl_staff (tbl_staff.id,tbl_staff.name,tbl_staff.email,tbl_staff.address)
                              SELECT tmp_tbl_staff.id, tmp_tbl_staff.name, tmp_tbl_staff.email, tmp_tbl_staff.address FROM tmp_tbl_staff
                              ON DUPLICATE KEY UPDATE tbl_staff.id = tmp_tbl_staff.id");
                            //Set message insert success
                            $this->Flash->success(IMPORT_SUCCESS, [
                                'key' => 'import-file',
                                'params' => [
                                    'escape' => false
                                ]
                            ]);
                        } else {
                            $this->Flash->error($messageValidate, [
                                'key' => 'import-file',
                                'params' => [
                                    'escape' => false
                                ]
                            ]);
                        }
                        //Remove data table tmp_tbl_staff
                        $connectDB->execute("TRUNCATE TABLE tmp_tbl_staff");
                    }
                } else {
                    $this->Flash->error(UPLOAD_ERR, [
                        'key' => 'import-file',
                        'params' => [
                            'escape' => false
                        ]
                    ]);
                }
                //Redirect view
                $this->redirect(['controller' => 'Users', 'action' => 'listUser']);
            }
        }

        //Set data to view
        $this->set(compact('arrayUsers', 'keySearch'));
    }

    /**
     * Export data from database into csv file
     */
    public function exportFile()
    {
        //Check the method post or delte
        $this->request->allowMethod(['post']);
        $this->loadModel('TblStaff');
        $arrayUsers = $this->TblStaff->find('all');
        $this->FunctionLb->writeCsv($arrayUsers);
        exit();
    }
}
