<h1 class="dashboard">Main Dashboard</h1>

<div class="member">
<p>Welcome, MDX | <?php echo($member['Member']['name']); ?>!</p>
<p>You are a <?php echo($member['Member']['user_rank']); ?> and have <?php echo($member['Member']['karma_points']); ?> points!</p>
</div>

<div id="work">
<ul class="projects">
  <h3 class="my-projects">Show All Tickets for My Projects</h3>
  <?
    $projects = $member['Project'];
    foreach($projects as $project):
  ?>
  <div class="project-name item_head"><? echo($project['name']); ?></div>
  <li class="project item_body">
  <div class="project-timestamps"><div class="project-created">created on: <?= $this->Time->timeAgoInWords($project['created']); ?> (<?= $this->Time->niceShort($project['created']); ?>)</div><div class="project-updated">updated at: <?= $this->Time->timeAgoInWords($project['updated']); ?> (<?= $this->Time->niceShort($project['updated']); ?>)</div></div>
  <div class="item_head">Project Messages</div>
  <ul class="statuses item_body">
    <h4 class="status-messages">Project Messages</h4>
    <h4 class="status-header item_head">New Project Message</h4>
    <div class="status-message-form item_body"> 
      <?php echo $this->Form->create('StatusMessage', array('url' => '/members/post_status_message'));?>
        <?php
          echo $this->Form->hidden('project_id', array('value' => $project['id']));
          echo $this->Form->hidden('user_id', array('value' => $user_id));
          echo $this->Form->text('message', array('label' => ""));
        ?>
      <?php echo $this->Form->end('Submit');?>
    </div>
    <?
      $statuses = $project['StatusMessage'];
      foreach($statuses as $status):
    ?>
    <li class="status">
      <div class="status-message"><? echo($status['message']); ?> - <? echo($status['User']['username']); ?> - <?= $this->Time->timeAgoInWords($status['created']); ?></div>
    </li>
    <?
      endforeach;
    ?>
  </ul>
  <div class="item_head">My <? echo($project['name']); ?> Tickets</div>
  <ul class="tickets item_body">
    <?
      $tickets = $project['Ticket'];
      foreach($tickets as $ticket):
    ?>
    <?php $tstatus = (strtolower($ticket['status']) == "done") ? "done" : "not done" ?>
    <? if($tstatus != "done") { ?>
    <h4 class="ticket-header item_head">#<? echo($ticket['id']); ?>:  <? echo($ticket['name']); ?></h4>
    <li class="ticket item_body">
    <div class="ticket-status">
    Status: <? echo($ticket['status']); ?> (<? echo($tstatus); ?>)
    <a href="/members/mark_as_done/<? echo($ticket['id']); ?>">Mark as Done</a>
    </div>
    <div class="ticket-description"><div class="the-description"><?= $textile->process($ticket['description']); ?></div>
    <div class="ticket-timestamps"><div class="ticket-created">created on: <?= $this->Time->timeAgoInWords($ticket['created']); ?> (<?= $this->Time->niceShort($ticket['created']); ?>)</div><div class="ticket-updated">updated at: <?= $this->Time->timeAgoInWords($ticket['updated']); ?> (<?= $this->Time->niceShort($ticket['updated']); ?>)</div></div>
    <ul class="images">
    <div class="file-list">Attached Files:</div>
    <?
      $images = $ticket['Image'];
      foreach($images as $image):
    ?>
    <li class="image-file"><? echo($this->Html->link($image['name'], "http://s3.amazonaws.com".$image['s3_url'])); ?> - uploaded at <?= $this->Time->timeAgoInWords($image['created']); ?> (<?= $this->Time->niceShort($image['created']); ?>)</li>
    <?
      endforeach;
    ?>
    </ul>
    </div>
    <ul class="comments">
    <?
      $ticket_comments = $ticket['TicketComment'];
      foreach($ticket_comments as $comment):
    ?>
    <li class="comment">
    <div class="comment-text"><?= $textile->process($comment['comment']); ?></div>
    <div class="comment-author"> - <? echo($comment['User']['username']); ?> (Status: <? echo($comment['status']); ?>)</div>
    <div class="comment-timestamps"><div class="comment-created">posted at: <?= $this->Time->timeAgoInWords($comment['created']); ?> (<?= $this->Time->niceShort($comment['created']); ?>)</div><div class="comment-updated">modified at: <?= $this->Time->timeAgoInWords($comment['updated']); ?> (<?= $this->Time->niceShort($comment['updated']); ?>)</div></div> 
    <ul class="replies">
      <?
        $comment_replies = $comment['CommentReply'];
        foreach($comment_replies as $reply):
      ?>
      <li class="reply">
      <div class="reply-text"><?= $textile->process($reply['reply']); ?></div>
      <div class="reply-author">- <? echo($reply['User']['username']); ?></div>
      <div class="reply-timestamps"><div class="reply-created">posted at: <?= $this->Time->timeAgoInWords($reply['created']); ?> (<?= $this->Time->niceShort($reply['created']); ?>)</div><div class="reply-updated">modified at: <?= $this->Time->timeAgoInWords($reply['updated']); ?> (<?= $this->Time->niceShort($reply['updated']); ?>)</div></div> 
      </li>
      <?
        endforeach;
      ?>
      <div class="comment-reply-form">
      <div class="post-reply">Post a reply</div>
      <?php echo $this->Form->create('CommentReply', array('url' => '/members/reply_to_comment'));?>
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
    <div class="post-comment">Post a comment</div>
    <?php echo $this->Form->create('TicketComment', array('url' => '/members/add_comment'));?>
	    <?php
		    echo $this->Form->input('comment');
		    echo $this->Form->hidden('user_id', array('value' => $user_id));
		    echo $this->Form->hidden('ticket_id', array('value' => $ticket['id']));
		    echo $this->Form->input('status');
	    ?>
    <?php echo $this->Form->end(__('Submit', true));?>
    </div>
    <div class="add-file-form">
    <div class="attach">Attach a file</div>
    <?php echo $this->Form->create('Image', array('url' => '/members/add_file_to_ticket', 'enctype' => 'multipart/form-data'));?>
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
  </ul>
  </li>
  <?
    endforeach;
  ?>
</ul>

</div>

<script type="text/javascript">
$(document).ready(function()
{
  //hide the all of the element with class item_body
  $(".item_body").hide();
  //toggle the componenet with class item_body
  $(".item_head").click(function()
  {
    if ($(this).css('background-image').match(/redplus.png/))
      $(this).css('background-image', 'url("/img/greenminus.png")');
    else
      $(this).css('background-image', 'url("/img/redplus.png")');
    $(this).next(".item_body").slideToggle(100);
  });
});
</script>
