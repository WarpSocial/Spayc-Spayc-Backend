<section class="content-wrapper content-filter">
  <div class="no-data-wrapper">
        <div class="no-data no-user error-page" >  
            <?php echo $this->Html->image('oops.png', ["alt" => "", 'class' =>'mb-30' ]);?>
            <h2>Error <?= $code ?></h2>
            <?php if($code != 400): ?>
            <p><?=  h($message) ?></p>
            <?php else: ?>
            <p>The page you are looking either removed or not exist.</p>
            <?php endif; ?>
            
            <p>back to <a href="<?= $admin_url ?>" ><span class="underline">Home Page</span></a></p>
        </div>
      </div>
</section>