 
<!-- breadcrumbs section starts here -->
        
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url('backoffice'); ?>">Dashboard</a>
                </li>
                <?php 
                    if(!empty($breadcrumb)){
                        if(is_array($breadcrumb)){
                            foreach($breadcrumb as $row){
                ?>              
                    <li class="breadcrumb-item active">
                        <a href="<?php if(isset($row['url'])){echo $row['url'];}else{echo '#';} ?>">
                            <?php if(isset($row['name'])){echo $row['name'];}else{echo ' ';} ?>
                        </a>
                    </li>
                <?php
                    }}else{
                ?>       
                    <li class="breadcrumb-item active"><?php if(!empty($breadcrumb)){echo $breadcrumb;} ?></li>
                <?php
                    }}
                ?>
            </ol>
        </div>
        <!-- breadcrumbs section Ends here -->