<div class="col-md-4"><!--RDG-->
    <h4 class="text-info">По РДГ-та</h4>
    <table class="table table-condensed">
        <?php foreach($rdgsgnls as $rdg):  ?>
            <tr>
                <td class="text-left col-md-5">
                    <a href="spravka_result_rdg.php?glav_pod=<?php echo $rdg->glav_pod ;?>&from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&title=<?php echo $rdg->RDG  ;?>">
                        <?php echo $rdg->RDG ;?>
                    </a>
                </td>
                <td class="text-right col-md-1"><?php echo $rdg->cnt ;?></td>
            </tr>
        <?php endforeach ;?>
        <tr class="alert-info">
            <td class="text-left col-md-5">Всичко:</td>
            <td class="text-right col-md-1"><?php echo $rdgtotalcnt ;?></td>
        </tr>
    </table>
</div><!--End RDG-->

<div class="col-md-4"><!--DP-->
    <h4 class="text-info">По ДП</h4>
    <table class="table table-condensed">
        <?php foreach($dpsgnls as $dp):  ?>
            <tr>
                <td class="text-left col-md-5">
                    <a href="spravka_result_rdg.php?glav_pod=<?php echo $rdg->glav_pod ;?>&from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&title=<?php echo $rdg->RDG  ;?>">
                        <?php echo $dp->DP ;?>
                    </a>
                </td>
                <td class="text-right col-md-1"><?php echo $dp->cnt ;?></td>
            </tr>
        <?php endforeach ;?>
        <tr class="alert-info">
            <td class="text-left col-md-5">Всичко:</td>
            <td class="text-right col-md-1"><?php echo $dptotalcnt ;?></td>
        </tr>
    </table>
</div><!--End DP-->