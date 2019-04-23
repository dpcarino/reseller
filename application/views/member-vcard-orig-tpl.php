<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Trimatrix Lab">
    <meta name="description" content="">
    <meta name="keywords" content="">


    <title>Essensa Elite Membership Information</title>
    <link rel="icon" href="images/fav-icon.png">

    <!--APPLE TOUCH ICON-->
    <link rel="apple-touch-icon" href="<?php echo base_url('assets/vcard/images/apple-touch-icon.png'); ?>">


    <!-- GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>


    <!-- MATERIAL ICON FONT -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/font-awesome.min.css'); ?>" rel="stylesheet">


    <!-- ANIMATION -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/animate.min.css'); ?>" rel="stylesheet">


    <!-- MATERIALIZE -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/materialize.css'); ?>" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/bootstrap.min.css'); ?>" rel="stylesheet">


    <!-- CUSTOM STYLE -->
    <link href="<?php echo base_url('assets/vcard/stylesheets/style.css'); ?>" id="switch_style" rel="stylesheet">

</head>
<body>


<!--==========================================
                  PRE-LOADER
===========================================-->
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="box-holder animated bounceInDown">
                <span class="load-box"><span class="box-inner"></span></span>
            </div>
            <!-- NAME & STATUS -->
            <div class="text-holder text-center">
                <h2><?php echo $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name; ?></h2>
                <!-- <h6>Software Engineer & UI/UX Expert</h6> -->
            </div>
        </div>
    </div>
</div>

<!--==========================================
                    HEADER
===========================================-->
<header id="home">
    <nav id="theMenu" class="menu">

        <!--MENU-->
        <div id="menu-options" class="menu-wrap">

            <!--PERSONAL LOGO-->
            <div class="logo-flat">
                <img alt="personal-logo" class="img-responsive" src="<?php echo base_url('assets/vcard/images/john.png'); ?>">
            </div>
            <br>

            <!--OPTIONS-->
            <a href="#home"><i class="title-icon fa fa-user"></i>Home</a>
            <a href="#about"><i class="title-icon fa fa-dashboard"></i>About</a>
            <a href="#education"><i class="title-icon fa fa-graduation-cap"></i>Education</a>
            <a href="#skills"><i class="title-icon fa fa-sliders"></i>Skills</a>
            <a href="#experience"><i class="title-icon fa fa-suitcase"></i>Experience</a>
            <a href="#portfolios"><i class="title-icon fa fa-archive"></i>Portfolios</a>
            <a href="#interest"><i class="title-icon fa fa-heart"></i>Interest</a>
            <a href="#testimonials"><i class="title-icon fa fa-users"></i>Testimonials</a>
            <a href="#pricing-table"><i class="title-icon fa fa-money"></i>Pricing</a>
            <a href="#blog"><i class="title-icon fa fa-pencil-square"></i>Blog</a>
            <a href="#contact"><i class="title-icon fa fa-envelope"></i>Contact</a>
        </div>

        <!-- MENU BUTTON -->
        <div id="menuToggle">
            <div class="toggle-normal">
                <i class="material-icons top-bar">remove</i>
                <i class="material-icons middle-bar">remove</i>
                <i class="material-icons bottom-bar">remove</i>
            </div>
        </div>
    </nav>

    <div class="header-background section">
        <div id="v-card-holder">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <!-- V-CARD -->
                        <div id="v-card" class="card">

                            <!-- PROFILE PICTURE -->
                            <div id="profile" class="right">
                                <img alt="profile-image" class="img-responsive" src="<?php echo site_url('uploads') . '/members/image/' . $member_details_info->authorized_id_img_1; ?>">
                                <div class="slant"></div>
                                <div class="btn-floating btn-large add-btn">
                                    <i class="material-icons">add</i></div>
                            </div>

                            <div class="card-content">

                                <!-- NAME & STATUS -->
                                <div class="info-headings">
                                    <h4 class="text-uppercase left"><?php echo $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name; ?></h4>
                                    <h6 class="text-capitalize left">Dealer</h6>
                                </div>

                                <!-- CONTACT INFO -->
                                <div class="infos">
                                    <ul class="profile-list">
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">email</i></span>
                                            <span class="content"><?php echo $member_info->email; ?></span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">language</i></span>
                                            <span class="content">yourpersonalwebsite.com</span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="fa fa-skype" aria-hidden="true"></i></span>
                                            <span class="content">yourusername@skype.com</span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">phone</i></span>
                                            <span class="content">+152 25634 254 846</span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="title"><i class="material-icons">place</i></span>
                                            <span class="content">LampStreet 34/3, London, UK</span>
                                        </li>

                                    </ul>
                                </div>

                                <!--LINKS-->
                                <div class="links">
                                    <!-- FACEBOOK-->
                                    <a href="#" id="first_one"
                                       class="social btn-floating indigo"><i
                                            class="fa fa-facebook"></i></a>
                                    <!-- TWITTER-->
                                    <a href="#" class="social  btn-floating blue"><i
                                            class="fa fa-twitter"></i></a>
                                    <!-- GOOGLE+-->
                                    <a href="#" class="social  btn-floating red"><i
                                            class="fa fa-google-plus"></i></a>
                                    <!-- LINKEDIN-->
                                    <a href="#" class="social  btn-floating blue darken-3"><i
                                            class="fa fa-linkedin"></i></a>
                                    <!-- RSS-->
                                    <a href="#" class="social  btn-floating orange darken-3"><i
                                            class="fa fa-rss"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!--==========================================
                   ABOUT
===========================================-->
<div id="about" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- DETAILS -->
                <div id="about-card" class="card">
                    <div class="card-content">
                        <!-- ABOUT PARAGRAPH -->
                        <p>
                            Hello! I’m John Doe. Senior Web Developer with over 13 years of experience
                            specializing in front end development. Experienced with all stages of the
                            development cycle for dynamic web projects.Having an in-depth knowledge
                            including advanced HTML5, CSS, CSS3, SASS, LESS, JSON, XML, Java, JavaScript,
                            JQuery, Angular JS. Strong background in management and leadership.
                        </p>
                    </div>

                    <!-- BUTTONS -->
                    <div id="about-btn" class="card-action">
                        <div class="about-btn">
                            <!-- DOWNLOAD CV BUTTON -->
                            <a href="#" class="btn waves-effect">Download CV</a>
                            <!-- CONTACT BUTTON -->
                            <a href="#contact" class="btn waves-effect">Contact Me</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--==========================================
                   EDUCATION
===========================================-->
<section id="education" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-graduation-cap"></i>Education</h4>
        </div>

        <div id="timeline-education">

            <!-- FIRST TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>P</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Preparatory Education</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>Fedrick School</small>
                            </h6>
                            <h6>
                                <small>Jan 1997 - Mar 2000</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I completed my preparatory education from this prestigious institution.
                            I successful completed all the credits without any fallout and got A grade overall.
                        </p>
                        <!-- BUTTON TRIGGER MODAL -->
                        <a href="#" class="modal-dot" data-toggle="modal" data-target="#myModal-1">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECOND TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>H</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">High School</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>RedStreet College</small>
                            </h6>
                            <h6>
                                <small>Jan 2000 - Mar 2005</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I completed my high school degree from this prestigious institution.
                            I successful completed all the credits without any fallout and got A grade overall.
                        </p>
                    </div>
                </div>
            </div>

            <!-- THIRD TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>C</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Computer Science</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>Down Street College</small>
                            </h6>
                            <h6>
                                <small>Jan 2006 - Mar 2008</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I completed my computer science degree from this prestigious institution.
                            I successful completed all the credits without any fallout and got A grade overall.
                        </p>

                    </div>
                </div>
            </div>

            <!-- FOURTH TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><i class="fa fa-graduation-cap"></i></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Software Engineering</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>Oxford University</small>
                            </h6>
                            <h6>
                                <small>Jan 2009 - Mar 2010</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I completed this degree from this prestigious institution.
                            I successful completed all the credits without any fallout and got A grade overall.
                        </p>

                    </div>
                </div>
            </div>
            <!-- FIFTH TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>U</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">UI/UX Workshop</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>IT Next Academy</small>
                            </h6>
                            <h6>
                                <small>Jan 2010 - Mar 2011</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I completed this course from this prestigious institution.
                            I successful completed all the credits without any fallout and got A grade overall.
                        </p>
                        <!-- BUTTON TRIGGER MODAL -->
                        <a href="#" class="modal-dot" data-toggle="modal" data-target="#myModal-2">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- SIXTH TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><i class="fa fa-globe"></i></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Web Development</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>Lipro University</small>
                            </h6>
                            <h6>
                                <small>Jan 2011 - Mar 2012</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I completed this course from this prestigious institution.
                            I successful completed all the credits without any fallout and got A grade overall.
                        </p>
                        <!-- BUTTON TRIGGER MODAL -->
                        <a href="#" class="modal-dot" data-toggle="modal" data-target="#myModal-3">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!--==========================================
                   SKILLS
===========================================-->
<section id="skills" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-sliders"></i>Skills</h4>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="skills-card" class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <!-- FIRST SKILL SECTION -->
                                <div class="skills-title">
                                    <h6 class="text-center">Professional</h6>
                                </div>
                                <!-- FIRST SKILL BAR -->
                                <div class="skillbar" data-percent="90%">
                                    <div class="skillbar-title"><span>HTML5</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">90%</div>
                                </div>
                                <!-- SECOND SKILL BAR  -->
                                <div class="skillbar" data-percent="90%">
                                    <div class="skillbar-title"><span>CSS3</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">90%</div>
                                </div>
                                <!-- THIRD SKILL BAR  -->
                                <div class="skillbar" data-percent="70%">
                                    <div class="skillbar-title"><span>jQuery</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">70%</div>
                                </div>
                                <!-- FOURTH SKILL BAR  -->
                                <div class="skillbar" data-percent="68%">
                                    <div class="skillbar-title"><span>PHP</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">68%</div>
                                </div>
                            </div>


                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <!-- SECOND SKILL SECTION -->
                                <div class="skills-title">
                                    <h6 class="text-center">Personal</h6>
                                </div>
                                <!-- FIRST SKILL BAR -->
                                <div class="skillbar" data-percent="80%">
                                    <div class="skillbar-title"><span>Communication</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">80%</div>
                                </div>
                                <!-- SECOND SKILL BAR  -->
                                <div class="skillbar" data-percent="60%">
                                    <div class="skillbar-title"><span>Teamwork</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">60%</div>
                                </div>
                                <!-- THIRD SKILL BAR  -->
                                <div class="skillbar" data-percent="70%">
                                    <div class="skillbar-title"><span>Creativity</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">70%</div>
                                </div>
                                <!-- FOURTH SKILL BAR  -->
                                <div class="skillbar" data-percent="70%">
                                    <div class="skillbar-title"><span>Dedication</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">70%</div>
                                </div>
                            </div>


                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <!-- THIRD SKILL SECTION -->
                                <div class="skills-title">
                                    <h6 class="text-center">Software</h6>
                                </div>
                                <!-- FIRST SKILL BAR -->
                                <div class="skillbar" data-percent="80%">
                                    <div class="skillbar-title"><span>Adobe Illustrator</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">80%</div>
                                </div>
                                <!-- SECOND SKILL BAR  -->
                                <div class="skillbar" data-percent="70%">
                                    <div class="skillbar-title"><span>Adobe InDesign</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">70%</div>
                                </div>
                                <!-- THIRD SKILL BAR  -->
                                <div class="skillbar" data-percent="60%">
                                    <div class="skillbar-title"><span>PHP Storm</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">60%</div>
                                </div>
                                <!-- FOURTH SKILL BAR  -->
                                <div class="skillbar" data-percent="80%">
                                    <div class="skillbar-title"><span>Dev Console</span></div>
                                    <div class="skillbar-bar"></div>
                                    <div class="skill-bar-percent">80%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--==========================================
                   EXPERIENCE
===========================================-->
<section id="experience" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-suitcase"></i>Experience</h4>
        </div>

        <div id="timeline-experience">

            <!-- FIRST TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>D</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Designer</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>RulerSoft</small>
                            </h6>
                            <h6>
                                <small>Jan 2010 - Mar 2012</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I started my designing carrier here, spent tow years learning and working
                            in various designing aspects..
                        </p>
                        <!-- BUTTON TRIGGER MODAL -->
                        <a href="#" class="modal-dot" data-toggle="modal" data-target="#myModal-4">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECOND TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>F</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Frontend Developer</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>Micro IT</small>
                            </h6>
                            <h6>
                                <small>Jan 2012 - Mar 2014</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I started my frontend carrier here, spent tow years learning and working
                            in various frontend aspects. I worked on about 40+ projects local and online.
                        </p>

                    </div>
                </div>
            </div>

            <!-- THIRD TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>U</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">UI/UX Expert</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>Libra IT Solutions</small>
                            </h6>
                            <h6>
                                <small>Jan 2014 - Mar 2015</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I started my expertise carrier here, spent tow years learning and working
                            in various UX/UI aspects. I worked on about 70+ projects local and online.
                        </p>

                    </div>
                </div>
            </div>

            <!-- FOURTH TIMELINE -->
            <div class="timeline-block">
                <!-- DOT -->
                <div class="timeline-dot"><h6>S</h6></div>
                <!-- TIMELINE CONTENT -->
                <div class="card timeline-content">
                    <div class="card-content">
                        <!-- TIMELINE TITLE -->
                        <h6 class="timeline-title">Senior Developer</h6>
                        <!-- TIMELINE TITLE INFO -->
                        <div class="timeline-info">
                            <h6>
                                <small>WebStyle Technologies</small>
                            </h6>
                            <h6>
                                <small>Jan 2016 - Continue..</small>
                            </h6>
                        </div>
                        <!-- TIMELINE PARAGRAPH -->
                        <p>
                            I recently joined here, currently working on various development
                            aspects. I already worked on about..
                        </p>
                        <!-- BUTTON TRIGGER MODAL -->
                        <a href="#" class="modal-dot" data-toggle="modal" data-target="#myModal-5">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--==========================================
                  MODALS
===========================================-->

<!--MODAL ONE-->
<div class="modal fade" id="myModal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header  text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">EDUCATION AT X </h4>
                <h6>
                    <small>Jan 2014 - Mar 2015</small>
                </h6>
            </div>
            <!--MODAL BODY-->
            <div class="modal-body">
                <p>
                    I have learned a great many things from participating in varsity football.
                    It has changed my entire outlook on and attitude toward life. Before my
                    freshman year at [high-school], I was shy, had low self-esteem and turned
                    away from seemingly impossible challenges. Football has altered all of these
                    qualities. On the first day of freshman practice, the team warmed up with a
                    game of touch football. The players were split up and the game began. However,
                    during the game, I noticed that I didn't run as hard as I could, nor did I try
                    to evade my defender and get open. The fact of the matter is that I really did
                    not want to be thrown the ball. I didn't want to be the one at fault if I dropped
                    the ball and the play didn't succeed. I did not want the responsibility of helping
                    the team because I was too afraid of making a mistake. That aspect of my character
                    led the first years of my high school life. All the while, I went to practice.
                </p>
            </div>
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL TWO-->
<div class="modal fade" id="myModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-2">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header  text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-2">EDUCATION AT Y</h4>
                <h6>
                    <small>Jan 2014 - Mar 2015</small>
                </h6>
            </div>
            <!--MODAL BODY-->
            <div class="modal-body">
                <p>
                    I have learned a great many things from participating in varsity football.
                    It has changed my entire outlook on and attitude toward life. Before my
                    freshman year at [high-school], I was shy, had low self-esteem and turned
                    away from seemingly impossible challenges. Football has altered all of these
                    qualities. On the first day of freshman practice, the team warmed up with a
                    game of touch football. The players were split up and the game began. However,
                </p>
            </div>
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL THREE-->
<div class="modal fade" id="myModal-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-3">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header  text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-3">EDUCATION AT Z</h4>
                <h6>
                    <small>Jan 2014 - Mar 2015</small>
                </h6>
            </div>
            <!--MODAL BODY-->
            <div class="modal-body">
                <p>
                    I have learned a great many things from participating in varsity football.
                    It has changed my entire outlook on and attitude toward life. Before my
                    freshman year at [high-school], I was shy, had low self-esteem and turned
                    away from seemingly impossible challenges. Football has altered all of these
                    qualities. On the first day of freshman practice, the team warmed up with a
                    game of touch football. The players were split up and the game began. However,
                </p>
            </div>
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL FOUR-->
<div class="modal fade" id="myModal-4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-4">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header  text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-4">EXPERIENCE AT Z</h4>
                <h6>
                    <small>Jan 2014 - Mar 2015</small>
                </h6>
            </div>
            <!--MODAL BODY-->
            <div class="modal-body">
                <p>
                    I have learned a great many things from participating in varsity football.
                    It has changed my entire outlook on and attitude toward life. Before my
                    freshman year at [high-school], I was shy, had low self-esteem and turned
                    away from seemingly impossible challenges. Football has altered all of these
                    qualities. On the first day of freshman practice, the team warmed up with a
                    game of touch football. The players were split up and the game began. However,
                </p>
            </div>
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--MODAL FIVE-->
<div class="modal fade" id="myModal-5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header  text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-5">EXPERIENCE AT M</h4>
                <h6>
                    <small>Jan 2014 - Mar 2015</small>
                </h6>
            </div>
            <!--MODAL BODY-->
            <div class="modal-body">
                <p>
                    I have learned a great many things from participating in varsity football.
                    It has changed my entire outlook on and attitude toward life. Before my
                    freshman year at [high-school], I was shy, had low self-esteem and turned
                    away from seemingly impossible challenges. Football has altered all of these
                    qualities. On the first day of freshman practice, the team warmed up with a
                    game of touch football. The players were split up and the game began. However,
                </p>
            </div>
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--==========================================
                  PORTFOLIOS
===========================================-->
<section id="portfolios" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-archive"></i>Portfolios</h4>
        </div>
        <div id="portfolios-card" class="row">

            <!--OPTIONS-->
            <ul class="nav nav-tabs">
                <!--ALL CATEGORIES-->
                <li class="active waves-effect list-shuffle"><a id="all-sample" class="active" href="#all" data-toggle="tab">ALL</a>
                    <!--CATEGORIES-->
                <li class="waves-effect list-shuffle"><a class="cate" href="#a" data-toggle="tab">LOGO</a></li>
                <li class="waves-effect list-shuffle"><a class="cate" href="#b" data-toggle="tab">DRIBBLE</a></li>
                <li class="waves-effect list-shuffle"><a class="cate" href="#c" data-toggle="tab">WEBSITES</a></li>
            </ul>

            <!--CATEGORIES CONTENT-->
            <div class="tab-content">

                <!--All CATEGORIES-->
                <div id="all"></div>

                <!--CATEGORY 1-->
                <div id="a">

                    <!--CATEGORY CONTENT ONE BIG-->
                    <div class="col-md-4 col-sm-12 col-xs-12 grid big inLeft">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Personal <span>LOGO</span></h2>
                                <p>Designed this logo in a competition. It was chosen as a winner.</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                    <!--CATEGORY CONTENT TWO SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inRight">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Cafe <span>LOGO</span></h2>
                                <p>I designed this for a clint for his cafe.</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                    <!--CATEGORY CONTENT THREE SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inRight">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Cafe <span>LOGO</span></h2>
                                <p>I designed this for a clint for his cafe.</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <!--CATEGORY 2-->
                <div id="b">

                    <!--CATEGORY CONTENT ONE BIG-->
                    <div class="col-md-4 col-sm-12 col-xs-12 grid big inRight">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>T-shirt <span>BRAND</span></h2>
                                <p>A brand logo designed by me for Silicon Brand</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                    <!--CATEGORY CONTENT TWO SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inLeft">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>V-Card <span>MATERIAL</span></h2>
                                <p>Used latest material design to made this sample</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>


                    <!--CATEGORY CONTENT THREE SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inLeft">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Cafe <span>LOGO</span></h2>
                                <p>I designed this for a clint for his cafe.</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <!--CATEGORY 3-->
                <div id="c">
                    <!--CATEGORY CONTENT ONE SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inLeft">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>T-shirt <span>BRAND</span></h2>
                                <p>A brand logo designed by me for Silicon Brand</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                    <!--CATEGORY CONTENT TWO SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inRight">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Sport <span>WEBSITE</span></h2>
                                <p>Made this for DECo Sports LTD.</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                    <!--CATEGORY CONTENT THREE SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inRight">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Corporate <span>WEBSITE</span></h2>

                                <p>Made this for Lance Corporation UK</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                    <!--CATEGORY CONTENT FOUR SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inLeft">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>T-shirt <span>BRAND</span></h2>
                                <p>A brand logo designed by me for Silicon Brand</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                    <!--CATEGORY CONTENT FIVE SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inRight">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Sport <span>WEBSITE</span></h2>
                                <p>Made this for DECo Sports LTD.</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                    <!--CATEGORY CONTENT SIX SMALL-->
                    <div class="col-md-4 col-sm-6 col-xs-12 grid inLeft">
                        <figure class="port-effect">
                            <img src="images/portfolio.png" class="img-responsive" alt="portfolio-demo"/>
                            <figcaption>
                                <h2>Corporate <span>WEBSITE</span></h2>

                                <p>Made this for Lance Corporation UK</p>
                                <a href="#">View more</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <!--PORTFOLIOS ADD GALLERY BUTTON-->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button id="add-more" class="center-block btn-large waves-effect"><i id="port-add-icon" class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>


<!--==========================================
                   INTEREST
===========================================-->
<section id="interest" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-heart"></i>Interest</h4>
        </div>

        <div id="interest-card" class="card">
            <!--INTEREST TEXT-->
            <div class="card-content">
                <p>
                    First of all I love music, country music is my favorite. Love watching
                    football, movies and playing games with my buddies. I spend quite a lot of time
                    in traveling and photography, these keeps me fresh for working environment.
                    I also spend time volunteering at the Red Cross in London, UK each month.
                </p>
            </div>

            <!--INTEREST ICONS-->
            <div class="row no-gutters">

                <!--INTEREST ICON ONE-->
                <div class="col-md-2 col-sm-4 col-xs-6  box text-center">
                    <div class="interest-icon">
                        <i class="fa fa-music"></i>
                        <span>Music</span>
                    </div>
                </div>
                <!--INTEREST ICON TWO-->
                <div class="col-md-2 col-sm-4 col-xs-6 box text-center">
                    <div class="interest-icon-even">
                        <i class="fa fa-gamepad"></i>
                        <span>Gaming</span>
                    </div>
                </div>
                <!--INTEREST ICON THREE-->
                <div class="col-md-2 col-sm-4 col-xs-6 box text-center">
                    <div class="interest-icon">
                        <i class="fa fa-camera"></i>
                        <span>Photography</span>
                    </div>
                </div>
                <!--INTEREST ICON FOUR-->
                <div class="col-md-2 col-sm-4 col-xs-6 box text-center">
                    <div class="interest-icon-even">
                        <i class="fa fa-futbol-o"></i>
                        <span>Football</span>
                    </div>
                </div>
                <!--INTEREST ICON FIVE-->
                <div class="col-md-2 col-sm-4 col-xs-6 box text-center">
                    <div class="interest-icon">
                        <i class="fa fa-plane"></i>
                        <span>Traveling</span>
                    </div>
                </div>
                <!--INTEREST ICON SIX-->
                <div class="col-md-2 col-sm-4 col-xs-6 box text-center">
                    <div class="interest-icon-even">
                        <i class="fa fa-film"></i>
                        <span>Movies</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<!--==========================================
             TESTIMONIALS AND CLIENTS
===========================================-->
<section id="testimonials" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-users"></i>Testimonials</h4>
        </div>
        <div id="testimonials-card" class="row card">
            <div class="col-md-12 col-xs-12">
                <!-- CLIENTS SLIDER-->
                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <!-- INDICATORS -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>
                    <!-- WRAPPER FOR SLIDES -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <div class="col-md-12">
                                <!--CLIENT IMAGE-->
                                <div class="ben center-block">
                                    <img alt="client-image" class="center-block" src="images/client.png">
                                </div>
                                <!--CLIENT QUOTE-->
                                <blockquote>
                                    I work with John on several web development projects and I find him to be extremely
                                    creative and a technical Front End Developer. Jone expertise involves building
                                    complex
                                    Responsive Design layouts using HTML 5, CSS3, and JavaScript.
                                    <cite>Mike, CEO, IT World.</cite>
                                </blockquote>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-12">
                                <!--CLIENT IMAGE-->
                                <div class="ben center-block">
                                    <img alt="client-image" class="center-block" src="images/client.png">
                                </div>
                                <!--CLIENT QUOTE-->
                                <blockquote>
                                    I work with John on several web development projects and I find him to be extremely
                                    creative and a technical Front End Developer. Jone expertise involves building
                                    complex
                                    Responsive Design layouts using HTML 5, CSS3, and JavaScript.
                                    <cite>Mike, CEO, IT World.</cite>
                                </blockquote>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-12">
                                <!--CLIENT IMAGE-->
                                <div class="ben center-block">
                                    <img alt="client-image" class="center-block" src="images/client.png">
                                </div>
                                <!--CLIENT QUOTE-->
                                <blockquote>
                                    I work with John on several web development projects and I find him to be extremely
                                    creative and a technical Front End Developer. Jone expertise involves building
                                    complex
                                    Responsive Design layouts using HTML 5, CSS3, and JavaScript.
                                    <cite>Mike, CEO, IT World.</cite>
                                </blockquote>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-md-12">
                                <!--CLIENT IMAGE-->
                                <div class="ben center-block">
                                    <img alt="client-image" class="center-block" src="images/client.png">
                                </div>
                                <!--CLIENT QUOTE-->
                                <blockquote>
                                    I work with John on several web development projects and I find him to be extremely
                                    creative and a technical Front End Developer. Jone expertise involves building
                                    complex
                                    Responsive Design layouts using HTML 5, CSS3, and JavaScript.
                                    <cite>Mike, CEO, IT World.</cite>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="clients">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="clients-wrap">
                            <!--CLIENT LOGO'S-->
                            <ul id="clients-list" class="clearfix">
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                                <li><img src="images/logo.png" alt="client-logo"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==========================================
             PRICING TABLE
===========================================-->
<section id="pricing-table" class="section">
    <div class="container">
        <!--SECTION TITLE-->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-money"></i>Pricing</h4>
        </div>
        <!--PRICING TABLES-->
        <div id="pricing-card" class="row">
            <!--PRICING ONE-->
            <div id="p-one" class="col-md-4 col-sm-4 col-xs-12">
                <div class="pricing">
                    <div class="card">
                        <!--PRICING TOP-->
                        <div class="pricing-top">
                            <p><sup>$</sup><em>50</em>/mo</p>
                            <span>Starter</span>
                        </div>
                        <!--PRICING DETAILS-->
                        <div class="pricing-bottom text-center text-capitalize">
                            <ul>
                                <li>2 GB Bandwidth</li>
                                <li>5 GB Disk Space</li>
                                <li>5 Databases</li>
                                <li>Free Domain</li>
                                <li>5 Subdomain</li>
                            </ul>
                        </div>
                        <!--BUTTON-->
                        <div class="card-action text-center">
                            <a class="waves-effect btn">Purchase</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--PRICING TWO-->
            <div id="p-three" class="col-md-4 col-sm-4 col-xs-12">
                <div class="pricing">
                    <div class="card">
                        <!--PRICING TOP-->
                        <div class="pricing-top">
                            <p><sup>$</sup><em>200</em>/mo</p>
                            <span>Ultimate</span>
                        </div>
                        <!--PRICING DETAILS-->
                        <div class="pricing-bottom text-center text-capitalize">
                            <ul>
                                <li>∞ Bandwidth</li>
                                <li>∞ Disk Space</li>
                                <li>∞ Databases</li>
                                <li>Free Domain</li>
                                <li>∞ Subdomain</li>
                            </ul>
                        </div>
                        <!--BUTTON-->
                        <div class="card-action text-center">
                            <a class="waves-effect btn">Purchase</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--PRICING THREE-->
            <div id="p-two" class="col-md-4 col-sm-4 col-xs-12">
                <div class="pricing">
                    <div class="card">
                        <!--PRICING TOP-->
                        <div class="pricing-top">
                            <p><sup>$</sup><em>100</em>/mo</p>
                            <span>Business</span>
                        </div>
                        <!--PRICING DETAILS-->
                        <div class="pricing-bottom text-center text-capitalize">
                            <ul>
                                <li>5 GB Bandwidth</li>
                                <li>25 GB Disk Space</li>
                                <li>10 Databases</li>
                                <li>Free Domain</li>
                                <li>15 Subdomain</li>
                            </ul>
                        </div>
                        <!--BUTTON-->
                        <div class="card-action text-center">
                            <a class="waves-effect btn">Purchase</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!--==========================================
             BLOG
===========================================-->
<section id="blog" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-pencil-square"></i>Blog</h4>
        </div>
        <div id="blog-card" class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <!--BLOG ODD-->
                    <div class="blog odd">
                        <!--IMAGE-->
                        <div class="image">
                            <img alt="blog-image" src="images/blog.png"/>
                            <div class="image-overlay"></div>
                        </div>
                        <!--DETAILS-->
                        <div class="content">
                            <ol class="breadcrumb">
                                <li><a href="#">Frontend</a></li>
                                <li><a href="#">Design</a></li>
                                <li class="active">Material</li>
                            </ol>
                            <h6>Material Design</h6>
                            <p>
                                Web design encompasses many different skills and disciplines in the production
                                of websites.Web design include web graphic design, interface design etc.
                            </p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <!--BLOG EVEN-->
                    <div class="blog even">
                        <!--IMAGE-->
                        <div class="image">
                            <img alt="blog-image" src="images/blog.png"/>
                            <div class="image-overlay"></div>
                        </div>
                        <!--DETAILS-->
                        <div class="content">
                            <ol class="breadcrumb">
                                <li><a href="#">Backend</a></li>
                                <li><a href="#">Dev</a></li>
                                <li class="active">Shortcuts</li>
                            </ol>
                            <h6>Development Shortcut</h6>
                            <p>
                                Web development is a broad term for the work involved in developing a web site
                                for the Internet or an intranet. Now lets get a bit deeper in this topic
                            </p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                    <!--BLOG ODD-->
                    <div class="blog odd">
                        <!--IMAGE-->
                        <div class="image">
                            <img alt="blog-image" src="images/blog.png"/>
                            <div class="image-overlay"></div>
                        </div>
                        <!--DETAILS-->
                        <div class="content">
                            <ol class="breadcrumb">
                                <li><a href="#">Frontend</a></li>
                                <li><a href="#">Specs</a></li>
                                <li class="active">UI</li>
                            </ol>
                            <h6>A Good UI</h6>
                            <p>
                                The user interface (UI), in the industrial design field of human–machine
                                interaction, is the space where interactions between humans and machines occur.
                            </p>
                            <a href="#">Read More</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!--==========================================
                  CONTACT
===========================================-->
<section id="contact" class="section">
    <div class="container">
        <!-- SECTION TITLE -->
        <div class="section-title">
            <h4 class="text-uppercase text-center"><i class="title-icon fa fa-envelope"></i>Contact</h4>
        </div>
        <div class="row">
            <div id="contact-card" class="col-md-5 col-sm-12 col-xs-12">
                <!-- CONTACT FORM -->
                <div class="card">
                    <div class="card-content">
                        <form id="contact-form" name="c-form">
                            <!-- NAME -->
                            <div class="input-field">
                                <input id="first_name" type="text" class="validate" name="first_name" required>
                                <label for="first_name">Name</label>
                            </div>
                            <!--SUBJECT-->
                            <div class="input-field">
                                <input id="sub" type="text" class="validate" name="sub">
                                <label for="sub">Subject</label>
                            </div>
                            <!--EMAIL-->
                            <div class="input-field">
                                <input id="email" type="email" class="validate" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            <!--MESSAGE-->
                            <div class="input-field">
                                <textarea id="textarea1" class="materialize-textarea" name="message"
                                          required></textarea>
                                <label for="textarea1">Message</label>
                            </div>
                            <!-- SEND BUTTON -->
                            <div class="contact-send">
                                <button id="submit" name="contactSubmit" type="submit" value="Submit"
                                        class="btn waves-effect">Send
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--FORM LOADER-->
                    <div id="form-loader" class="progress is-hidden">
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-sm-12 col-xs-12">
                <!-- CONTACT MAP -->
                <div id="map-card" class="card">
                    <!-- MAP -->
                    <div id="myMap"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<!--SCROLL TO TOP-->
<div id="scroll-top">
    <div id="scrollup"><i class="fa fa-angle-up"></i></div>
</div>

<!--==========================================
                      FOOTER
===========================================-->

<footer>
    <div class="container">
        <!--FOOTER DETAILS-->
        <p class="text-center">
            © Material CV. All right reserved
        </p>
    </div>
</footer>

<!-- ================== SCRIPTS ================== -->
<script src="<?php echo base_url('assets/vcard/javascript/jquery-2.1.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/materialize.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY"></script>
<script src="<?php echo base_url('assets/vcard/javascript/markerwithlabel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/retina.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/scrollreveal.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/jquery.touchSwipe.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vcard/javascript/custom.js'); ?>"></script>


</body>
</html>