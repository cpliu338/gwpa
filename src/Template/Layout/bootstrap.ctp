<?php
$cakeDescription = 'GWPA';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/le-frog/jquery-ui.css"/>
    <?= $this->Html->script('jquery.datetimepicker.js') ?>
    <?= $this->Html->css('gwpa.css') ?>
    <?= $this->Html->css('jquery.datetimepicker.css') ?>

    <?= $this->fetch('script') ?>
    <style>
div.message {
  border-style: solid;
  border-width: 1px;
  display: block;
  font-weight: normal;
  position: relative;
  padding: 0.875rem 1.5rem 0.875rem 20%;
  transition: opacity 300ms ease-out 0s;
  background-color: green;
  border-color: green;
  color: white;
}

div.message.error {
  background-color: #C3232D;
  border-color: #C3232D;
  color: #FFF;
}

div.message:before {
  line-height: 0px;
  font-size: 20px;
  height: 12px;
  width: 12px;
  border-radius: 15px;
  text-align: center;
  vertical-align: middle;
  display: inline-block;
  position: relative;
  left: -11px;
  background-color: #FFF;
  padding: 12px 14px 12px 10px;
  content: "i";
  color: #DCE47E;
}

div.message.error:before {
  padding: 11px 16px 14px 7px;
  color: #C3232D;
  content: "x";
}

    </style>
</head>
<body>
    <div class="container">
        <h2>
            <?= $this->fetch('title') ?>
        </h2>
<div class="col-md-2">
    <div class="btn-group-vertical">
        <?= $this->element('nav', ['nav'=>$nav]) ?>
    </div>
</div>
<div class="col-md-10">
        <section>
            <?= $this->Flash->render() ?>
        </section>
        <section>
            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
            
        </section>
        <footer>
        </footer>
    </div>
</div>
</body>
</html>
