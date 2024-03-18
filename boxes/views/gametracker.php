<link href="<?=$this->getBaseUrl('application/modules/gametracker/static/css/gametrackers.css') ?>" rel="stylesheet">
<link href="<?=$this->getBaseUrl('application/modules/gametracker/static/js/jquery.bxslider/jquery.bxslider.min.css') ?>" rel="stylesheet">
<style>
.gametracker-box .gametrackersslider .bx-viewport {
    height: <?=$this->get('boxHeight') ?>px !important;
}
</style>

<div class="gametracker-box">
    <?php if ($this->get('slider') == 0): ?>
        <?php foreach ($this->get('gametrackers') as $gametracker): ?>
            <div class="gametracker-item">
                <?php
                $userMapper = new Modules\User\Mappers\User();
                $link = $userMapper->getHomepage($gametracker->getLink());
                if (strncmp($gametracker->getBanner(), 'application', 11) === 0) {
                    $banner = $this->getBaseUrl($gametracker->getBanner());
                } else {
                    $banner = $gametracker->getBanner();
                }
                ?>
                <a href="<?=$link ?>" target=<?=($gametracker->getTarget() == 0) ? '"_blank" rel="noopener"' : '"_self"' ?>><img src="<?=$banner ?>" title="<?=$this->escape($gametracker->getName()) ?>" border="0" alt="<?=$this->escape($gametracker->getName()) ?>"/></a>
        <?php endforeach; ?>
    <?php else: ?>
        <?php if (!empty($this->get('gametrackers'))) : ?>
            <div class="gametrackersslider">
                <div class="bxslider<?=($this->get('sliderMode') === 'horizontal' ? ' h-slide' : '') ?>">
                    <?php
                    foreach ($this->get('gametrackers') as $gametracker):
                        $userMapper = new Modules\User\Mappers\User();
                        $link = $userMapper->getHomepage($gametracker->getLink());
                        if (strncmp($gametracker->getBanner(), 'application', 11) === 0) {
                            $banner = $this->getBaseUrl($gametracker->getBanner());
                        } else {
                            $banner = $gametracker->getBanner();
                        }
                        ?>

                        <div class="gametracker-item">
                            <a href="<?=$link ?>" target=<?=($gametracker->getTarget() == 0) ? '"_blank" rel="noopener"' : '"_self"' ?>><img src="<?=$banner ?>" title="<?=$this->escape($gametracker->getName()) ?>" border="0" alt="<?=$this->escape($gametracker->getName()) ?>"/></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="<?=$this->getBaseUrl('application/modules/gametracker/static/js/jquery.bxslider/jquery.bxslider.min.js') ?>"></script>
<script>
$('.bxslider').bxSlider({
    mode: '<?=$this->get('sliderMode') ?>',
    ticker: true,
    slideMargin: 10,
    speed: <?=$this->get('sliderSpeed') ?>,
    tickerHover: true
});
</script>
