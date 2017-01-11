<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/header-cms', TEMPLATE_INCLUDEPATH));?>
<section class="scroll">
    <!-- Swiper -->
    <div class="swiper-container swiper-container-banner">
        <div class="swiper-wrapper">
            <?php  if(!empty($mbcopyright['slides'])) { ?>
					<?php  $i = 1;?>
					<?php  if(is_array($mbcopyright['slides'])) { foreach($mbcopyright['slides'] as $slide) { ?>
					<div class="swiper-slide">
						<img src="<?php  echo tomedia($slide);?>" width="100%">
					</div>
					<?php  $i++;?>
					<?php  } } ?>
			<?php  } else { ?>					
            <div class="swiper-slide">
                <img src="./resource/mobile/images/gw-bg.jpg" width="100%">
            </div>
            <?php  } ?> 
        </div>
        <div class="swiper-pagination swiper-pagination-banner"></div>
    </div>
    <script>
        var swiper = new Swiper('.swiper-container-banner', {
            loop:true,
            autoplay: 5000,//可选选项，自动滑动
            // 如果需要分页器
            pagination: '.swiper-pagination-banner'
        });
    </script>
</section>

<section class="product">
    <div class="title">
        <a href="<?php  echo url('article/product-show/list');?>" class="more fr">更多 >></a>
        <h2>服务项目</h2>
    </div>

    <div class="proList clearfix">
        <ul>
            <?php  if(is_array($product)) { foreach($product as $product) { ?>
            <li>
                <a href="<?php  echo url('article/product-show/detail', array('id' => $product['id']));?>">
                    <div class="iconbox">
                    <img src="<?php  echo tomedia($product['thumb']);?>"/>
                    </div>
                    <h3><?php  echo $product['title'];?></h3>
                    <p><?php  echo cutstr_html($product['content'],'38');?></p>
                </a>
            </li>
			<?php  } } ?>
		</ul>
    </div>
</section>

<section class="news mt20">
    <div class="title">
        <a href="<?php  echo url('article/news-show/list');?>" class="more fr">更多 >></a>
        <h2>新闻动态</h2>
    </div>
    <div class="newsLsit">
        <ul>
            <?php  if(is_array($news)) { foreach($news as $new) { ?>
            <li>
                <small class="time fr"><?php  echo date('Y-m-d', $new['createtime']);?></small>
                <a href="<?php  echo url('article/news-show/detail', array('id' => $new['id']));?>" target="_blank"><?php  echo $new['title'];?></a>
            </li>
			<?php  } } ?>
            </ul>   
			</div>
</section>

<section class="scroll-foot mt20">
    <div class="title">
	    <a href="<?php  echo url('article/case-show/list');?>" class="more fr">更多 >></a>
        <h2>客户案例</h2>
    </div>

    <!-- Swiper -->
    <div class="swiper-container swiper-container-foot">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <ul>    
					<?php  if(is_array($case)) { foreach($case as $case) { ?>				
                        <li>
                            <img src="<?php  echo tomedia($case['thumb']);?>"/>
                            <h3><?php  echo $case['title'];?></h3>
                        </li>
					<?php  } } ?>
                </ul>

            </div>
            <div class="swiper-slide">
                <ul>                                   
                <?php  if(is_array($case2)) { foreach($case2 as $case) { ?>				
                        <li>
                            <img src="<?php  echo tomedia($case['thumb']);?>"/>
                            <h3><?php  echo $case['title'];?></h3>
                        </li>
				<?php  } } ?>                                        
                </ul>
            </div>
            <div class="swiper-slide">
                <ul>                                   
                <?php  if(is_array($case3)) { foreach($case3 as $case) { ?>				
                        <li>
                            <img src="<?php  echo tomedia($case['thumb']);?>"/>
                            <h3><?php  echo $case['title'];?></h3>
                        </li>
				<?php  } } ?>                                        
                </ul>
            </div>
        </div>
        <div class="swiper-pagination swiper-pagination-foot mt10 mb10" style="position: static"></div>
    </div>
    <script>
        var swiperFoot = new Swiper('.swiper-container-foot', {
            loop:false,
            autoplay: 8000,//可选选项，自动滑动
            // 如果需要分页器
            pagination: '.swiper-pagination-foot'
        });
    </script>
</section>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-cms', TEMPLATE_INCLUDEPATH));?>