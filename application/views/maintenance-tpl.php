<?php include('includes/header-login.php'); ?>

<!-- <body style="background-image: url(<?php echo base_url('assets/35674-O062WT.jpg'); ?>); background-repeat: no-repeat; background-size: 100% 100%; background-attachment: fixed;"> -->
<body class=" page-404-3" cz-shortcut-listen="true">
    <div class="page-inner">
        <img src="<?php echo base_url('assets/maintenance.jpg'); ?>" class="img-responsive" alt=""> 
    </div>
    <div class="container error-404">
        <h2>Maintenance is On-going</h2>
        <p><?php echo $maintenance_settings['message']; ?></p>
        <p> Meanwhile you can visit our website by clicking the button below. </p>
        <p>
            <a href="http://essensanaturale.org/" class="btn red btn-outline"> Go To Essensa Naturale Inc. </a>
            <br> 
        </p>
    </div>
</body>
<!-- </body> -->
</html>