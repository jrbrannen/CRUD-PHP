<?php

require_once('../inc/NewsArticles.class.php');

// create object
$newsArticle = new NewsArticles();
$requestArray = $newsArticle->sanitize($_REQUEST); // $_REQUEST is both $_GET and $_POST

// checks to see if there is a record to load
if (isset($requestArray['article_id']) && !empty($requestArray['article_id'])){
    $newsArticle->load($requestArray['article_id']);
    $dataArray = $newsArticle->dataArray;
}

// checks to see if the save button was pushed
if (isset($requestArray["Save"])){
    
    // sanitize the data
    $requestArray = $newsArticle->sanitize($_REQUEST); // $_REQUEST is both $_GET and $_POST
    
    // pass new data to the instance
    // set data array to the object array property
    $newsArticle->set($requestArray);

    // validate the data
    if ($newsArticle->validate()){
        //save
        if ($newsArticle->save()){
            header("location: article-save-success.php"); // prevents double posting
            exit;   // ends server processing
        }else{
            
        }
    }else{
        //errors
        $errorsArray = $newsArticle->errors;
        $dataArray = $newsArticle->dataArray;
    }
}
?>
<html>
    <body>
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
            <?php if (isset($errorsArray['article_title'])) { ?>
                <div><?php echo $errorsArray['article_title']; ?></div>
            <?php }elseif (isset($errorsArray['article_author'])) { ?>
                <div><?= $errorsArray['article_author']; ?></div>
            <?php }elseif (isset($errorsArray['article_content'])) { ?>
                <div><?= $errorsArray['article_content']; ?></div>
            <?php }elseif (isset($errorsArray['article_date'])) { ?>
                <div><?= $errorsArray['article_date']; ?></div>
            <?php } ?>

            title: <input type="text" name="article_title" value="<?php echo (isset($dataArray['article_title']) ? $dataArray['article_title'] : ''); ?>"/><br>
            content: <textarea name="article_content"><?php echo (isset($dataArray['article_content']) ? $dataArray['article_content'] : ''); ?></textarea><br>
            author: <input type="text" name="article_author" value="<?php echo (isset($dataArray['article_author']) ? $dataArray['article_author'] : ''); ?>"/><br>
            date: <input type="text" name="article_date" value="<?php echo (isset($dataArray['article_date']) ? $dataArray['article_date'] : ''); ?>"/><br>
            <input type="hidden" name="article_id" value="<?php echo (isset($dataArray['article_id']) ? $dataArray['article_id'] : ''); ?>"/>
            <input type="submit" name="Save" value="Save"/>
            <input type="submit" name="Cancel" value="Cancel"/>            
        </form>        
    </body>
</html>