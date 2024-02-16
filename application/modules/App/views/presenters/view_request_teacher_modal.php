    

    <label for="teacher_name">Teacher Name:</label>
        <input type="text" class="form-control" name ="teacher_name" id="teacher_name" placeholder="Enter Teacher Name" required/>
    <?php  if(isset($is_grade_present)){ ?>
        <label for="grade">Grade:</label>
        <input type="text" class="form-control" name ="grade_name" id="grade_name" placeholder="Enter Grade Name" required/>
    <?php }else{ ?>
        <label for="grade">Grade:</label>
        <select name="grade_name" id="grade_name" class="form-control grades">
            <option value="">Select</option>
            <?php foreach ($teacher_grades as $item) {?>
                <option value="<?php echo $item->grade_name;?>" data-slug="<?php echo $item->school_id; ?>" ><?php echo $item->grade_name;?></option>
            <?php } ?>
        </select>
    <?php } ?>

   
   