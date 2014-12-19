<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <!-- AddThis Button BEGIN -->        
         <div class="addthis_toolbox addthis_default_style ">            
             <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>            
             <a class="addthis_button_tweet"></a>            
             <a class="addthis_button_pinterest_pinit"></a>            
             <a class="addthis_counter addthis_pill_style"></a>            
         </div>            
         <!-- AddThis Button END -->
    </div>
</div>
<div class="row">
  <div class="col-md-12">
	<div class="embed-responsive embed-responsive-16by9">
		<iframe src="//www.youtube.com/embed/<?= $code; ?>" frameborder="0" allowfullscreen></iframe>
	</div>
</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3>Comentários</h3>
		<div class="fb-comments" 
            data-href="<?= site_url('video/'.$code); ?>" 
            data-num-posts="15" data-width="100%"></div>
	</div>
</div>