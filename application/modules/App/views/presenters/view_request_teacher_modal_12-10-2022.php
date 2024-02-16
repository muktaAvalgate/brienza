    

    <label for="teacher_name">Teacher Name:</label>
        <input type="text" class="form-control" name ="teacher_name" id="teacher_name" placeholder="Enter Teacher Name" required/>
    <label for="grade">Grade:</label>
    <?php  if(!isset($grade_name->name)){ ?>
        <input type="text" class="form-control" name ="grade_name" id="grade_name" placeholder="Enter Grade Name" required/>
    <?php }else{ ?>
        <input type="text" class="form-control" name ="grade_name" id="grade_name" value="<?php echo $grade_name->name; ?>" readonly>
    <?php } ?>

   
   