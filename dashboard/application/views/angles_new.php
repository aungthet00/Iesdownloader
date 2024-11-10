<style>
.btn-group-xs>.btn, .btn-xs {
    padding: .15rem .4rem;
    font-size: .675rem;
    line-height: 1.5;
    border-radius: .2rem;
}
</style>

<div class="containerx">
<!-- <h1 style="margin-top:20px;margin-bottom:20px">Compatibility UI</h1> -->
<div style="margin-top:20px" class="row">
  <div class="col-6">
     <div class="form-group">
  <label for="sel1">Groups:</label>
  <select class="form-control dd" id="sel1">
    <option value="">Select Group</option>
    <?php foreach ($groups as $key=>$group): ?>
      <option <?php echo ($group->id == $selected_group_id) ? 'selected' : '' ?> value="<?php echo $group->id ?>"><?php echo $group->title ?></option>
    <?php endforeach; ?>
  </select>
</div>
  </div>
  <div class="col-6">
    <?php if($selected_group_id > 0): ?>
    <table class="table">
    <thead>
      <tr>
        <th>Type</th>
        <th style="color:green;">Vertical Angles (Y)</th>
        <th style="color:orange;">Horizontal Angles (X)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $g->group_type ?></td>
        <td style="color:green;"><?php echo $g->vertical_angles ?> <button class="btn btn-xs btn-light populate-angles">Populate Verticle Angles</button></td>
        <td style="color:orange;"><?php echo $g->horizontal_angles ?></td>
      </tr>
      
    </tbody>
  </table>


  <?php endif; ?>

  </div>

  <?php if($selected_group_id > 0): ?>
  <div class="col-12">

  <div class="table-responsive">

  <table class="table"> 
    <thead>
      <tr>
        <th></th>
      <?php for ($x = 0; $x < $g->vertical_angles; $x++): ?>
        <th>
          <input id="y_value_<?php echo $x?>" value="<?php 


              if($x < count($y_angles)){
                echo $y_angles[$x]['y_value'];
              }

        ?>" style="border-color:green;font-size:12px;color:green;text-align:center;padding:0px;width:50px;height:30px" type="text" class="form-control my-input y_angles_box" >
        </th>
      <?php endfor; ?>
      </tr>
    </thead>
    <tbody>
      

      <?php for ($x = 0; $x < $g->horizontal_angles; $x++): ?>
        <tr>
           <td>
            <input id="x_value_<?php echo $x?>" value="<?php 

              if($x < count($x_angles)){
                echo $x_angles[$x]['x_value'];
              }

             ?>" style="border-color:orange;font-size:12px;color:orange;text-align:center;padding:0px;width:50px;height:30px" type="text" class="form-control my-input x_angles_box x_angles_box_first">
           </td>

           <?php for ($x2 = 0; $x2 < $g->vertical_angles; $x2++): ?>
            <td>

              <?php 

              if($x < count($x_angles)){
                $x_v = $x_angles[$x]['x_value'];
              }
              else{
                $x_v = 10000;
              }

              if($x2 < count($y_angles)){
                $y_v = $y_angles[$x2]['y_value'];
              }
              else{
                $y_v = 10000;
              }

             ?>

              <input id="factor_x<?php echo $x?>_y<?php echo $x2?>" value="<?php echo get_factor($selected_group_id,$x_v,$y_v); ?>" style="font-size:12px;text-align:center;padding:0px;width:50px;height:30px" type="text" class="form-control my-input factor_box">

            </td>
          <?php endfor; ?>
        </tr>
      <?php endfor; ?>
      
    </tbody>
  </table>
  </div>
  
    <div>
      <button style="float:right;width:200px" class="btn-save-angles btn btn-primary btn-lg">Save Angle Values</button>
    </div>
</div>
  <?php endif; ?>
</div>

 

</div>

<script>

  // $(function() {
  //     $('.freeze-table').freezeTable({
  //       'columnNum' : 1,
  //       'shadow':true
  //     });
  //  });

  //


    $(document).ready(function(){


     

       $(".populate-angles").click(function(e){
         e.preventDefault();

         var v_angles_array = [0,2,4,6,8,10,12,14,16,18,20,25,30,35,40,50,60,70,90];

         $( ".y_angles_box" ).each(function( index ) {

          $(this).val(v_angles_array[index]);

         });

         //alert("abc");

       });

      $('select').select2();




      $(".dd").change(function(){

          window.location.replace(siteurl + "elr/angles_new/" + $(this).children("option:selected").val());
      });

      $(".btn-save-angles").click(function(e){
        e.preventDefault();

        var empty_boxes_count = $('.my-input').filter(function(){
            return !$(this).val();
        }).length;

        if(empty_boxes_count > 0){
          alert("Please fill all inputs");
        }else{

          var all_data = [];

          $( ".table .x_angles_box_first" ).each(function( index1 ) {

            console.log("x_angles_box_first");

            var x_angle = $(this);

            $( ".y_angles_box" ).each(function( index2 ) {
              var y_angle = $(this);

              //factor_x0_y0

              var factor = $("#factor_x"+index1+"_y"+index2).val();

              var obj = {"group_id":$(".dd").children("option:selected").val(),"factor":factor,"x_value":x_angle.val(),"y_value":y_angle.val()};

              all_data.push(obj);

               //console.log(x_angle.val() + " - " + y_angle.val() + " - " + factor);

            });
             

          });

          console.log(all_data);

          var options = {
            url: siteurl + "elr/save_angles",
            dataType: "text",
            type: "POST",
            data: { all_data: JSON.stringify( all_data ),group_id:$(".dd").children("option:selected").val()  }, // Our valid JSON string
            success: function( data, status, xhr ) {
               //...
               alert("Data saved");
            },
            error: function( xhr, status, error ) {
                //...
                alert("Error occured");
            }
          };

          $.ajax( options );



        }
        
      });

    });

</script>