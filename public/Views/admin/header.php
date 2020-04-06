<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $this->title ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= $this->env->get('url') ?>public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?= $this->env->get('url') ?>public/admin/bower_components/metisMenu/dist/metisMenu.min.css"
          rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= $this->env->get('url') ?>public/admin/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?= $this->env->get('url') ?>public/admin/bower_components/font-awesome/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Focim</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            <li>
                Felhasznalonev:
                <?= $this->user->getUsername(); ?>
            </li>
            Jogosultsagok:
            <? foreach ($this->user->getRoles() as $role):?>
                <li>
                    <?=$role->getName();?>
                </li>
            <?endforeach;?>
            <?if(is_null($this->user->getLastSeen())):?>
                <li>
                    Ez az elso bejelentkezes
                </li>
            <?else:?>
                <li>
                    Legutobbi bejelentkezes: <?= $this->user->getLastSeen()->format('Y-m-d H:i:s') ?>
                </li>
            <?endif;?>
            <li>
                <a href="<?= $this->env->get('url') ?>admin/index/logout"><i class="fa fa-sign-out fa-fw"></i>
                    Kijelentkezes
                </a>
            </li>
        </ul>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? /** @var \App\Entity\Page $page */
                    foreach ($this->user->getPages() as $page): ?>
                        <li>
                            <a href="<?= $this->env->get('url') ?>admin/<?= $page->getUrl() ?>"><i
                                    class="fa fa-dashboard fa-fw"></i> <?= $page->getFormattedName() ?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
