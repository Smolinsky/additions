<?php echo $header; ?>
<div class="container">
<div class="review-wrap">
<nav aria-label="breadcrumb">
<ul class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
<?php } ?>
</ul>
</nav>
<div class="page-title">
<span><?php echo $heading_title; ?></span>
</div>
<?php if ($reviews) { ?>
<div class="review">
<div class="card-review-wrap">
<?php foreach ($reviews as $review) { ?>   
<?php if($review['image']) { ?>
<a href="<?php echo $review['href']; ?>">
<div class="card-review__item">
<img class="review-img" src="image/<?php echo $review['image']; ?>">
<div>
<p class="review-name"><?php echo $review['name']; ?></p>
<p class="card-review__text"><?php echo $review['text']; ?></p>
<div class="card-review__flex">
<div class="card-review__date">
<span><?php echo $review['author']; ?> <?php echo $review['date_added']; ?></span>
</div>
<div class="product-star">
<?php for ($i = 1; $i <= 5; $i++) { ?>
<?php if ($review['rating'] < $i) { ?>
<span class="product-star__item"></span>
<?php } else { ?>
<span class="product-star__item checked"></span>
<?php } ?>
<?php } ?>
</div>
</div>
</div>
</div>
</a>
<?php } ?>
<?php } ?>
</div>
<?php echo $pagination; ?>
</div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
</div>
</div>

<?php echo $footer; ?>
