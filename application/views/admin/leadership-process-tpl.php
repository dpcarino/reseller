<?php include('includes/header.php'); ?>

<div class="page-container">
    <?php include("includes/sidebar.php"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">Leadership Process</h3>

            <!-- BEGIN PAGE HEADER-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('/admin'); ?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Leadership</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->

            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                        <div class="visual">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="counter-up-members">0</span>
                            </div>
                            <div class="desc"> Members </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                        <div class="visual">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="counter-up-heads">0</span>
                            </div>
                            <div class="desc"> Heads </div>
                        </div>
                    </a>
                </div>                
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
<script>   
$(document).ready(function() {
    App.blockUI({
        message: 'PREPARING MEMBERS FOR LEADERSHIP PROCESSING',
    });


    setTimeout(function(){ 
       $('#counter-up-members').html(<?php echo $member_count; ?>);

        App.blockUI({
            message: 'PREPARING HEADS FOR LEADERSHIP PROCESSING',
        });        
    }, 5000);

    setTimeout(function(){ 
        $('#counter-up-heads').html(<?php echo $head_count; ?>);

        App.blockUI({
            message: 'PREPARING HEADS FOR LEADERSHIP PROCESSING',
        });

        preProcess();
    }, 10000);

});

function preProcess(){

    App.blockUI({
        message: 'PROCESSING PRE-PROCESS INFORMATIONS',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/preprocess-information",
        success: function(data) {           
            if(data.status == 'success'){
                processWeeklyIncome();
            }else{
                // window.location.href = base_url+'admin/encashments';
            }                
        },
        type: 'POST',
    });

}

function processWeeklyIncome(){
    App.blockUI({
        message: 'PROCESSING WEEKLY INCOME',
    });    

    $.ajax({
        url: base_url+"admin/leadership/ajax/process-weekly-income",
        success: function(data) {           
            if(data.status == 'success'){
                 processLevel1();                
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel1(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 1',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level1",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel2();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }
        },
        type: 'POST',
    });    
}

function processLevel2(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 2',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level2",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel3();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel3(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 3',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level3",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel4();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel4(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 4',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level4",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel5();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel5(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 5',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level5",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel6();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel6(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 6',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level6",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel7();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel7(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 7',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level7",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel8();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel8(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 8',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level8",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel9();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel9(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 9',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level9",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel10();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel10(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 10',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level10",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel11();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel11(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 11',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level11",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel12();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel12(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 12',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level12",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel13();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel13(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 13',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level13",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel14();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel14(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 14',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level14",
        success: function(data) {           
            if(data.status == 'success'){
                processLevel15();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLevel15(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP LEVEL 15',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-level15",
        success: function(data) {           
            if(data.status == 'success'){
                processLeadershipIncome();
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function processLeadershipIncome(){
    App.blockUI({
        message: 'PROCESSING LEADERSHIP INCOME AND CREDITING',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/leadership-income",
        success: function(data) {           
            if(data.status == 'success'){
                finalizeProcess();               
            }else{
                App.blockUI({
                    message: data.msg,
                });
            }                
        },
        type: 'POST',
    });    
}

function finalizeProcess(){
    App.blockUI({
        message: 'FINALIZING DATABASE UPDATES AND UPDATING INFORMATIONS',
    });

    $.ajax({
        url: base_url+"admin/leadership/ajax/process-information",
        success: function(data) {           
            if(data.status == 'success'){
                window.location.href = base_url+'admin/leadership/history';        
            }                
        },
        type: 'POST',
    });    
}
</script>