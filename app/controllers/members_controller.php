<?php
class MembersController extends AppController {

	var $name = 'Members';
	var $uses = array('Member', 'Project', 'StatusMessage', 'Ticket', 'TicketComment', 'CommentReply');
	
	// member landing point
	function member_landing() {
	  $this->layout = 'mindtrack';
	  $session_user = $this->Session->read('Auth.User');
	  $options['conditions'] = array('Member.user_id =' => $session_user['id']);
	  $options['contain'] = array('Project' => array('StatusMessage' => array('Member'), 'Client', 'Ticket' => array('TicketComment' => array('Client', 'CommentReply' => array('Member')))));
    $member = $this->Member->find('first', $options);
    //debug($member);
    $this->set("title_for_layout", "MDX MindTracker");
	  $this->set("member", $member);
	}
	
	// posts a CommentReply
	function reply_to_comment() {
		if (!empty($this->data)) {
			$this->CommentReply->create();
			if ($this->CommentReply->save($this->data)) {
				$this->Session->setFlash(__('The comment reply has been saved', true));
			} else {
				$this->Session->setFlash(__('The comment reply could not be saved. Please, try again.', true));
			}
		}
		$this->redirect(array('action' => 'member_landing'));
	}
	
	function post_status_message() {
		if (!empty($this->data)) {
			$this->StatusMessage->create();
			if ($this->StatusMessage->save($this->data)) {
				$this->Session->setFlash(__('The status message has been saved', true));
			} else {
				$this->Session->setFlash(__('The status message could not be saved. Please, try again.', true));
			}
		}
		$this->redirect(array('action' => 'member_landing'));
	}

	function index() {
	  $this->layout = 'admin';
		$this->Member->recursive = 0;
		$this->set('members', $this->paginate());
	}

	function view($id = null) {
	  $this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid member', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('member', $this->Member->read(null, $id));
	}

	function add() {
	  $this->layout = 'admin';
		if (!empty($this->data)) {
			$this->Member->create();
			if ($this->Member->save($this->data)) {
				$this->Session->setFlash(__('The member has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Member->User->find('list');
		$projects = $this->Member->Project->find('list');
		$tickets = $this->Member->Ticket->find('list');
		$this->set(compact('users', 'projects', 'tickets'));
	}

	function edit($id = null) {
	  $this->layout = 'admin';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid member', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Member->save($this->data)) {
				$this->Session->setFlash(__('The member has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Member->read(null, $id);
		}
		$users = $this->Member->User->find('list');
		$projects = $this->Member->Project->find('list');
		$tickets = $this->Member->Ticket->find('list');
		$this->set(compact('users', 'projects', 'tickets'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for member', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Member->delete($id)) {
			$this->Session->setFlash(__('Member deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Member was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
