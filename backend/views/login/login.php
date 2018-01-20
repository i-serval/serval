<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login - Serval';

?>

<div class="position-wrapper">
    <section class="login-form-wrapper">

        <header>
            <h1 style = "text-align:center; font-size:45px; margin-top: 0px; font-family: 'UbuntuBold'">
                <span style="font-weight: 800; color: #F48024; text-decoration: none; letter-spacing: 5px;">SERVAL</span>
            </h1>
        </header>

        <h5>
            <span>Account Login</span>
        </h5>

        <div class="col-lg-25">

            <?php $form = ActiveForm::begin( ['id' => 'login-form'] ); ?>

            <?=$form->field( $model, 'email', [

                            'template' => '
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    {input}
                                </div>
                                {hint}
                                {error}'

                            ])

                    ->textInput( ['placeholder' => 'email', 'autofocus' => true ] );
            ?>

            <?=$form->field( $model, 'password',[

                            'template' => '
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    {input}
                                </div>
                                {hint}
                                {error}'

                            ])

                    ->passwordInput( ['placeholder' => 'password'] );
            ?>

            <div id="remember-me-wrapper">
                <?=$form->field( $model, 'remember_me')
                        ->checkbox( ['checked' => false ] )
                        ->label( 'Remember me' )
                ?>
            </div>

            <div class="flex-container">
                <div class="form-group" id="login-button-wrapper">
                    <?=Html::submitButton(
                        'LOGIN',
                        ['class' => 'btn btn-success', 'name' => 'login-button']
                       );
                    ?>
                </div>

                <span class="forgot-password"><a href="/login/forgot-password" class="">Forgot you password?</a></span>

            <?php ActiveForm::end(); ?>

        </div>

        <?php

            $copyright_year = 2017;

            if( date( 'Y' ) > $copyright_year ) {
                $copyright_year .= '-' . date( 'Y' );
            }
        ?>

        <footer class="login-footer">
            Copyright &copy; <?=$copyright_year?> <a class="link-copyright" href="http://google.com" target="_blank" title="Google">Serval</a>. All rights reserved.
        </footer>

    </section>
</div>
