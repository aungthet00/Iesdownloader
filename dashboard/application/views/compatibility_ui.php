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

<div  class="freeze-table">          
  <table class="table">
    <thead>
      <tr>
        <th style="font-size:12px" class="text-center" style="min-width: 120px;">Lamp</th>
        <?php foreach ($fixtures as $key=>$fixture): ?>
        	<th style="font-size:12px"  class="text-center" ><?php echo $fixture->fixture; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>

    <?php foreach ($lamps as $key=>$lamp): ?>

      <tr>
        <td class="text-center"  style="width: 100px"><?php echo $lamp->module; ?></td>
        <?php foreach ($fixtures as $key=>$fixture): ?>
        	<td>
        		<?php //echo "L:$lamp->id/F:$fixture->id" ?>
        		<div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
        		<?php foreach ($accessories as $key=>$accessory): ?>

              <?php $is_compatible = is_compatible($lamp->id,$fixture->id,$accessory->id); ?>


						  <button id="btn-id-<?php echo $lamp->id ."-".$fixture->id ."-".$accessory->id; ?>" data-is-compatible="<?php echo $is_compatible; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $accessory->title . " - " . $accessory->id; ?>" data-lamp-id="<?php echo $lamp->id; ?>" data-fixture-id="<?php echo $fixture->id; ?>" data-accessory-id="<?php echo $accessory->id; ?>" type="button" class="btn-compatibility btn btn-<?php echo ($is_compatible) ? 'success' : 'secondary' ?>"><?php echo $accessory->accessory; ?> </button>
						


        		<?php endforeach; ?>
        	</div>

        	</td>
        <?php endforeach; ?>
      </tr>

    <?php endforeach; ?>

    </tbody>
  </table>
  </div>

  <script>
    $(document).ready(function(){

      $(".btn-compatibility").click(function(){

        var is_compatible = $(this).attr("data-is-compatible");
        var lamp_id = $(this).attr("data-lamp-id");
        var fixture_id = $(this).attr("data-fixture-id");
        var accessory_id = $(this).attr("data-accessory-id");
        var action = "";

        $(this).addClass("disabled");



        if(is_compatible){
          action = "remove";
        }
        else{
          action = "add";
        }

        $.post("<?= site_url('elr/update_compatibility') ?>", {action: action,lamp_id: lamp_id,fixture_id: fixture_id, accessory_id: accessory_id}, function(result){

          var response = JSON.parse(result);

          $("#"+response.id_to_update).removeClass("btn-success");
          $("#"+response.id_to_update).removeClass("btn-success");
          $("#"+response.id_to_update).removeClass("disabled");

          if(response.action == "add"){
            $("#"+response.id_to_update).addClass("btn-success");
            $("#"+response.id_to_update).attr("data-is-compatible",1);
          }

          if(response.action == "remove"){
            $("#"+response.id_to_update).addClass("btn-secondary");
            $("#"+response.id_to_update).removeAttr("data-is-compatible");
          }

          //alert(response.action);
          
          //console.log(response);


        });
        


        
      });

    });

   $(function() {
      $('.freeze-table').freezeTable({
        'columnNum' : 1,
        'shadow':true
      });
   });

   $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

</script>

</div>