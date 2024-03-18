<h1><?=($this->get('gametracker') != '' ? $this->getTrans('edit') : $this->getTrans('add')) ?></h1>
<form class="form-horizontal" method="POST">
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('name') ? 'has-error' : '' ?>">
        <label for="name" class="col-lg-2 control-label">
            <?=$this->getTrans('name') ?>:
        </label>
        <div class="col-lg-6">
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   placeholder="Name"
                   value="<?=($this->get('gametracker') != '') ? $this->escape($this->get('gametracker')->getName()) : $this->escape($this->originalInput('name')) ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="link" class="col-lg-2 control-label">
            <?=$this->getTrans('link') ?>:
        </label>
        <div class="col-lg-3 <?=$this->validation()->hasError('link') ? 'has-error' : '' ?>">
            <input type="text"
                   class="form-control"
                   id="link"
                   name="link"
                   placeholder="http://"
                   value="<?=($this->get('gametracker') != '') ? $this->escape($this->get('gametracker')->getLink()) : $this->escape($this->originalInput('link')) ?>" />
        </div>
        <div class="col-lg-3">
            <select class="form-control" id="target" name="target">
                <option value="0"<?=($this->get('gametracker') != '' and $this->get('gametracker')->getTarget() == 0) ? ' selected="selected"' : '' ?>><?=$this->getTrans('targetBlank') ?></option>
                <option value="1"<?=($this->get('gametracker') != '' and $this->get('gametracker')->getTarget() == 1) ? ' selected="selected"' : '' ?>><?=$this->getTrans('targetSelf') ?></option>
            </select>
        </div>
    </div>
    <div class="form-group <?=$this->validation()->hasError('banner') ? 'has-error' : '' ?>">
        <label for="selectedImage_1" class="col-lg-2 control-label">
            <?=$this->getTrans('banner') ?>:
        </label>
        <div class="col-lg-6">
            <div class="input-group">
                <input type="text"
                       class="form-control"
                       id="selectedImage_1"
                       name="banner"
                       placeholder="<?=$this->getTrans('httpOrMedia') ?>"
                       value="<?=($this->get('gametracker') != '') ? $this->escape($this->get('gametracker')->getBanner()) : $this->escape($this->originalInput('banner')) ?>" />
                <span class="input-group-addon"><a id="media" href="javascript:media_1()"><i class="fa-regular fa-image"></i></a></span>
            </div>
        </div>
    </div>
    <?=($this->get('gametracker') != '' ? $this->getSaveBar('updateButton') : $this->getSaveBar('addButton')) ?>
</form>

<?=$this->getDialog('mediaModal', $this->getTrans('media'), '<iframe frameborder="0"></iframe>') ?>
<script>
<?=$this->getMedia()
    ->addMediaButton($this->getUrl('admin/media/iframe/index/type/single/input/_1/'))
    ->addInputId('_1')
    ->addUploadController($this->getUrl('admin/media/index/upload'))
?>
</script>
