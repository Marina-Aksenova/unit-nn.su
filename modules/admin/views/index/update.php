<?php
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */

$this->registerJs("
    tinymce.init({
        selector: 'textarea',
        height: '400',
        language: 'ru',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        setup: function(editor) {
            editor.on('change', function(e) {
                $('textarea').val(tinymce.activeEditor.getBody().innerHTML);
            });
        }
    });
");

?>

<div class="container">
    <?php
    $form = ActiveForm::begin([
        'id' => 'update-form',
    ]) ?>
    <?= $form->field($page, 'name') ?>
    <?= $form->field($page, 'text')->textarea(['rows' => 20]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
