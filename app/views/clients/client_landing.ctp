<div class="client-welcome">
<p>Welcome, <?php echo($client['name']); ?>!</p>
</div>

<div id="work">
<ul class="projects">
  <h3 class="my-projects">My Projects</h3>
  <?
    $projects = $user['Project'];
    foreach($projects as $project):
  ?>
  <li class="project">
  <div class="project-info">
  <div class="project-name">Project: <? echo($project['name']); ?></div>
  <div class="project-link">Link: <? echo($this->Html->link($project['link'], $project['link'])); ?></div>
  <div class="project-description">Description: <? echo($project['description']); ?></div>
  <div class="edit-my-project"><a href="/clients/edit_my_project/<? echo($project['id']); ?>">Edit Project</a></div>
  </div>
  <ul class="statuses">
  <h4 class="status-messages">Project Messages</h4>
  <?
    $statuses = $project['StatusMessage'];
    foreach($statuses as $status):
  ?>
  <li class="status">
  <div class="status-message"><? echo($status['message']); ?> - <? echo($status['User']['username']); ?></div>
  </li>
  <?
    endforeach;
  ?>
  </ul>
  <ul class="tickets">
  <h4 class="my-tickets">Tickets</h4>
  <div class="new-ticket"><a href="/clients/new_ticket/<? echo($project['id']); ?>">New Ticket</a></div>
    <?
      $tickets = $project['Ticket'];
      foreach($tickets as $ticket):
    ?>
    <?php $tstatus = (strtolower($ticket['status']) == "done") ? "done" : "not done" ?>
    <? if($tstatus != "done") { ?>
    <li class="ticket">
    <div class="ticket-info">
    <h4 class="ticket-header">Ticket #<? echo($ticket['id']); ?>: <? echo($ticket['name']); ?></h4>
    <div class="ticket-description">Description: <? echo($ticket['description']); ?></div>
    <div class="ticket-status">Status: <? echo($ticket['status']); ?> <a href="/clients/mark_as_done/<? echo($ticket['id']); ?>">Mark as Done</a></div>
    </div>
    <ul class="images">
    <?
      $images = $ticket['Image'];
      foreach($images as $image):
    ?>
    <li><? echo($this->Html->link($image['name'], "http://s3.amazonaws.com".$image['s3_url'])); ?></li>
    <?
      endforeach;
    ?>
    </ul>
    <ul class="comments">
    <?
      $ticket_comments = $ticket['TicketComment'];
      foreach($ticket_comments as $comment):
    ?>
    <li class="comment">
    <div class="comment-text">Comment: <? echo($comment['comment']); ?> <br/ > Status: <? echo($comment['status']); ?> <br/ > Posted by: <? echo($comment['User']['username']); ?></div>
    
    <ul class="replies">
      <?
        $comment_replies = $comment['CommentReply'];
        foreach($comment_replies as $reply):
      ?>
      <li class="reply">
      <div class="reply-text"><? echo($reply['reply']); ?> - <? echo($reply['User']['username']); ?> </div>
      </li>
      <?
        endforeach;
      ?>
      <div class="comment-reply-form">
      <?php echo $this->Form->create('CommentReply', array('url' => '/clients/reply_to_comment'));?>
	      <?php
		      echo $this->Form->textarea('reply', array('label' => ""));
		      echo $this->Form->hidden('ticket_comment_id', array('value' => $comment['id']));
		      echo $this->Form->hidden('user_id', array('value' => $user_id));
	      ?>
      <?php echo $this->Form->end('Submit');?>
      </div>
    </ul>
    </li>
    <?
      endforeach;
    ?>
    <div class="create-comment-form">
    <?php echo $this->Form->create('TicketComment', array('url' => '/clients/add_comment'));?>
	    <?php
		    echo $this->Form->input('comment');
		    echo $this->Form->hidden('user_id', array('value' => $user_id));
		    echo $this->Form->hidden('ticket_id', array('value' => $ticket['id']));
		    echo $this->Form->input('status');
	    ?>
    <?php echo $this->Form->end(__('Submit', true));?>
    </div>
    <div class="add-file-form">
    <?php echo $this->Form->create('Image', array('url' => '/clients/add_file_to_ticket', 'enctype' => 'multipart/form-data'));?>
	    <?php
	      echo $this->Form->hidden('s3_url');
	      echo $this->Form->hidden('Ticket.ticket_id', array('value' => $ticket['id']));
		    echo $this->Form->hidden('user_id', array('value' => $user_id));
		    echo $this->Form->file('name');
	    ?>
	    </fieldset>
    <?php echo $this->Form->end(__('Submit', true));?>
    </div>
    </ul>
    </li>
    <?
      }
      endforeach;
    ?>
    <div class="status-message-form">
    <h4 class="status-header">Post a Project Message</h4>
    <?php echo $this->Form->create('StatusMessage', array('url' => '/clients/post_status_message'));?>
      <?php
        echo $this->Form->textarea('message', array('label' => ""));
        echo $this->Form->hidden('project_id', array('value' => $project['id']));
        echo $this->Form->hidden('user_id', array('value' => $user_id));
      ?>
    <?php echo $this->Form->end('Submit');?>
    </div>
  </ul>
  </li>
  <?
    endforeach;
  ?>
</ul>

</div>


