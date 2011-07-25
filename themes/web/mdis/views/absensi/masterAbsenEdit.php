<?php $this->load->view('header') ?>
<div id="content">
<div class="column full">
		
		<div class="box">
		<div class="box-header">Edit Master Absen</div>
		<div class="box-content">
        <?php echo isAccess('absensi','masterAbsen','view') ? anchor('absensi/masterAbsen/view', 'Master Absensi', 'class="button white fr"') : ''; ?>
		<br /><br />

            <?php if (isset($errorMessage)) : ?>
            	<div class="notification <?php echo ((isset($isSuccess) && $isSuccess) ? 'success' : 'error');?>"><?php echo $errorMessage; ?></div>
	        <?php endif; ?>    	
	        
            <?php if (!(isset($isSuccess) && $isSuccess)) : ?>
            <?php  echo form_open('absensi/masterAbsen/edit/id/'.$dataEdit['id'].'/time/' . time(),array('name'=>'formAddAbsen'),array('kirim'=>'kirim')); ?>
            <table>
                <tr>
                    <td width="200">Hari Kerja</td>
                    <td><br />
                        <?php echo form_input(array('name'=>'harikerja','value'=>get_data($_POST,'harikerja'), 'class'=> 'form-field'));?>
                    </td>
                </tr>
                <tr>
                    <td>Jam Masuk</td>
                    <td>
                        <?php echo form_input(array('name'=>'jam_masuk','value'=>get_data($_POST,'jam_masuk'),'class'=>'form-field'));?>
                    </td>
                </tr>
		<tr>
                    <td>Jam Pulang</td>
                    <td>
                        <?php echo form_input(array('name'=>'jam_pulang','value'=>get_data($_POST,'jam_pulang'),'class'=>'form-field'));?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <?php echo form_submit('submit','Simpan', 'class="button themed"');?>
                    </td>
                </tr>
            </table>
            </form>
            <?php endif;?>

          </div>
        </div>
      </div>
      <!-- End Widget-->
      
      <div class="clear"></div>
    </div>
  </div>

<?php $this->load->view('footer') ?>