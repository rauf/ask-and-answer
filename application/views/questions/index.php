<h2> <?php echo $title; ?> </h2>

<div class="hidden" id="pageIndicator">0</div>
<div class="hidden" id="pageEndReached">0</div>
<div class="hidden" id="pageFetchAllowed">1</div>

<?php 
    if (count($questions) == 0) {
        echo '<h3><strong>There are no questiosn. Use Ask Question Button to ask a question</strong></h3>';
    }
?>

<hr>
<div id="questionsList">
    <?php foreach ($questions as $ques): ?>
    	<div id="question-item">
            <h3><a href="<?php echo '/question/detail/'.$ques['qid']; ?>">
            	<?php echo $ques['title']; ?>
              	</a>
             </h3>
             
            <div>
                    <span>By : </span><strong><?php echo $owner_name[$ques['ownerId']]['first_name'];?></strong>
            </div>

            <div>
                    <span>Answers : </span><strong><?php 
                        $c = $answer_counts[$ques['qid']];

                        if (strlen($c) != 0) echo $c;
                        else echo '0';
                    ;?></strong>
            </div>

            <div>
                    <span>Views : </span><strong><?php echo $ques['views'];?></strong>
            </div>

            <div>
                    <span>Asked at : </span> <strong><?php echo $ques['posted_time']; ?></strong>
            </div>
            <hr>
        </div>
    <?php endforeach; ?>
</div>