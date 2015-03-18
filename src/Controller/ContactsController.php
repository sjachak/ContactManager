<?php
namespace ContactManager\Controller;

use ContactManager\Controller\AppController;
use App\Form\ContactForm;

/**
 * Contacts Controller
 *
 * @property \ContactManager\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('contacts', $this->paginate($this->Contacts));
        $this->set('_serialize', ['contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        $this->set('contact', $contact);
        $this->set('_serialize', ['contact']);
    }



    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        /*$contact = $this->Contacts->newEntity(); 
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            pr($contact); exit;
            if ($this->Contacts->save($contact)) {
                $this->Flash->success('The contact has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The contact could not be saved. Please, try again.');
            }
        }
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);*/

        $contact = new ContactForm();
        $contactObj = $this->Contacts->newEntity();

        if ($this->request->is('post')) {
            if ($contact->execute($this->request->data)) {  
                $contactObj = $this->Contacts->patchEntity($contactObj, $this->request->data); 
                if($this->Contacts->save($contactObj)){
                    $this->Flash->success('We will get back to you soon.');
                }
                else{   
                    //$isValid = $contact->validate($this->request->data); pr($isValid);
                   // pr($contact->_$errors);
                    $this->Flash->error('User with given email registered previously.');
                }
               
            } else {
                $this->Flash->error('There was a problem submitting your form.');
            }
        }
        $this->set('contact', $contact);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success('The contact has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The contact could not be saved. Please, try again.');
            }
        }
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success('The contact has been deleted.');
        } else {
            $this->Flash->error('The contact could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    
}
