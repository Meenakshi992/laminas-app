<?php 
namespace User\Controller;

use User\Form\AlbumForm;
use User\Model\Album;

use User\Model\AlbumTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{

     // Add this property:
     private $table;

     public function init()
     {
     // define the actions that should consider different contexts
     $this->_helper->contextSwitch()
     ->addActionContext('get.user', 'json')
     ->initContext();
     }

     
     // Add this constructor:
     public function __construct(AlbumTable $table)
     {
         $this->table = $table;
     }

     /**
      * this indexAction method is for Reading the data from database.
      */
     public function indexAction()
     {
          /**
         * fetchAll() user made function is used by controller class to fetch all data from database using select query 
         */
         return new ViewModel([
             'albums' => $this->table->fetchAll(),
         ]);
     }
     /**
      * AddAction method is for adding new row from add.phtml into database.
      */
     public function addAction()
     {
         $form = new AlbumForm();
         $form->get('submit')->setValue('Add');
 
         $request = $this->getRequest();
 
         if (! $request->isPost()) {
             return ['form' => $form];
         }
 
         $album = new Album();
         $form->setInputFilter($album->getInputFilter());
         $form->setData($request->getPost());
        //  $form->params()->fromPost();
         if (! $form->isValid()) {
             return ['form' => $form];
         }
 
         $album->exchangeArray($form->getData());
          /**
         * saveAlbum(data) is albumtable class method made is used by addAction to save new entry into database
         */

         $this->table->saveAlbum($album);
         return $this->redirect()->toRoute('album');
     }
      /**
      * this is editAction method to edit any row data using its ID in database ENTRY.
      */
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
 
         if (0 === $id) {
             return $this->redirect()->toRoute('album', ['action' => 'add']);
         }
 
         // Retrieve the album with the specified id. Doing so raises
         // an exception if the album is not found, which should result
         // in redirecting to the home page.
         try {
               /**
             * getAlbum(id) is albumtable class method is used by editAction method to get row from id to update from database table.
             */
             $album = $this->table->getAlbum($id);
         } catch (\Exception $e) {
             return $this->redirect()->toRoute('album', ['action' => 'index']);
         }
 
         $form = new AlbumForm();
         $form->bind($album);
         $form->get('submit')->setAttribute('value', 'Edit');
 
         $request = $this->getRequest();
         $viewData = ['id' => $id, 'form' => $form];
 
         if (! $request->isPost()) {
             return $viewData;
         }
 
         $form->setInputFilter($album->getInputFilter());
         $form->setData($request->getPost());
 
         if (! $form->isValid()) {
             return $viewData;
         }
 
         $this->table->saveAlbum($album);
 
         // Redirect to album list
         return $this->redirect()->toRoute('album', ['action' => 'index']);
     }
     /**
      * this is deleteAction method to delete any row data from database.
      */
     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album');
         }
 
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
 
             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                    /**
                 * deleteAlbum(id) is albumtable class method is used by deleteAction method to get row from id to delete from database table.
                 */
                 $this->table->deleteAlbum($id);
             }
 
             // Redirect to list of albums
             return $this->redirect()->toRoute('album');
         }
 
         return [
             'id'    => $id,
             'album' => $this->table->getAlbum($id),
         ];
     }
}
?>
