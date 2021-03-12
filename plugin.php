<?php
        $url = "https://remoteok.io/remote-jobs.rss";
        $invalidurl = false;
        if(@simplexml_load_file($url)){
            $feeds = simplexml_load_file($url);
        }else{
            $invalidurl = true;
            $message = "Invalid RSS feed URL.";
        }

        if(!empty($feeds)){
            $site = $feeds->channel->title;
            $sitelink = $feeds->channel->link;
            foreach ($feeds->channel->item as $item) {

                $title = $item->title;
                $company = $item->company;
                $description = strip_tags($item->description);   
                $link = $item->link;
                $tags = $item->tags;
                $postDate = $item->pubDate;
                $pubDate = date('D, d M Y',strtotime($postDate));
                $image = $item->image;
?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                    <img class="card-img-top" src="<?php echo $image?>" alt="<?php echo $title; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text">Company: <?php echo $company; ?></p>
                        <p class="card-text"><?php echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "..."; ?></p>
                        <p class="card-text">Tags: <?php echo $tags; ?></p>
                        <a href="<?php echo $link; ?>" class="btn btn-primary">Read More</a>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo $pubDate; ?>
                    </div>
                    </div>
                </div>
<?php
    }
}else{
    if(!$invalidurl){
        echo "<h2>No item found</h2>";
    }
}
?>