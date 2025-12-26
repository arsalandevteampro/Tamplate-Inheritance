<?php $this->extend('layouts/main'); ?>

<?php $this->section('title'); ?>
About Page
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <h2>About Page</h2>
    <p>This page is rendered using our custom <strong>MiniBlade</strong> engine.</p>
    <p>Message from controller: <?php echo $message; ?></p>
<?php $this->endSection(); ?>
