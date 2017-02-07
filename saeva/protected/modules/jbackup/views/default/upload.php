
<h1><?php echo JBackupTranslator::t('backup','Upload Backup'); ?></h1>

<div class="form">


<?php
    /**
     * @var $form CActiveForm 
     */
    $form = $this->beginWidget($this->module->bootstrap ? 'bootstrap.widgets.BsActiveForm': 'CActiveForm', array(
            'id' => 'install-form',
            'enableAjaxValidation' => false,
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    if($this->module->bootstrap)
        $form->layout = BsHtml::FORM_LAYOUT_HORIZONTAL;
?>
    <?php 
        if($this->module->bootstrap) {
            echo $form->fileFieldControlGroup($model,'upload_file',array(
                'controlOptions' => array(
                    'class' => 'col-lg-10'
                ),
                'groupOptions' => array(
                    'class' => 'col-lg-12'
                )
            ));
        }else{
    ?>
        <div class="row">
                <?php echo $form->labelEx($model,'upload_file'); ?>
                <?php echo $form->fileField($model,'upload_file'); ?>
                <?php echo $form->error($model,'upload_file'); ?>
        </div><!-- row -->
    <?php }?>
<?php
    echo BsHtml::formActions(array(
        $this->getButtonSend(JBackupTranslator::t('backup', 'Upload'))
    ));
	$this->endWidget();
?>
</div><!-- form -->