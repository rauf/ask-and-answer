<h2> <?php echo $title; ?> </h2>

	<div id="question-item">
    <div id="qid" class="hidden"><?php echo $qid; ?></div>
        <h3><?php echo $question['title']; ?></h3>
        
        <div>
                <span>By : </span><strong><?php echo $question_owner_name;?></strong>
        </div>

        <div>
                <span>Description : </span><strong><?php echo $question['description'];?></strong>
        </div>

        <div>
                <span>Answers : </span><strong><?php echo count($answers);?></strong>
        </div>

        <div>
                <span>Views : </span><strong><?php echo $question['views'];?></strong>
        </div> 

        <div>
                <span>Asked at : </span> <strong><?php echo $question['posted_time']; ?></strong>
        </div>
    </div>

<h2>Answers</h2>
<hr>

<?php 
    if (count($answers) == 0) {
        echo '<h3><strong>This question does not have any answers. Be the first to answer it!</strong></h3>';
    }
?>

<?php foreach ($answers as $ans): ?>
    <div id="question-item">
        <h3><?php echo $ans['text']; ?></h3>

        <div>
                <span>By : </span><strong><?php echo $owner_name[$ans['ownerId']]['first_name'];?></strong>
        </div>

        <div>
                <span>At : </span> <strong><?php echo $ans['posted_time']; ?></strong>
        </div>
        <hr>
    </div>
<?php endforeach; ?>

<textarea id="answerArea" rows="4" cols="50"></textarea>
<br/>
<div id="answerAreaStatus"></div>
<input id="submitAnswerButton" type="submit" value="Submit your Answer" onclick="submitAnswerButton()" />
<input id="cancelAnswerButton" type="submit" value="Cancel" onclick="cancelAnswerButton()" />